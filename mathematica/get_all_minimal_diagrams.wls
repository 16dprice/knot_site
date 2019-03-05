#!/usr/bin/env wolframscript
<<FlypeCode`

(*
To execute this script, run './get_all_minimal_diagrams.wls n k' where n is the number of crossings
on the knot and k is the listing of the knot in the knot table. For example: ./get_all_minimal_diagrams.wls 10 15 would
find all the minimal diagrams of knot 10 15. The results are stored in ../c/reduced_codes.txt.
NOTE: this code only works for ALTERNATING knots. Non-alternating knots will return no results
*)

crossings = ToExpression[$ScriptCommandLine[[2]]];
listing = ToExpression[$ScriptCommandLine[[3]]];

If[crossings <= 10,
    knot = PD@Knot[crossings, listing],
    knot = PD@Knot[crossings, Alternating, listing]
];

If[!isAlternating[knot],Print["\n"];Abort[]];

hasPDCodeBeenFound[pdcode_, codesFound_]:=Module[{},

    If[codesFound == {}, Return[False]];
    If[pdcode == {}, Return[True]];

    (* get the reduced version of the codes that have been found *)
    exportPDsAsTxt[codesFound, "/var/www/html/sandboxes/dj/knot_site/c/pdcodes.txt"];
    Run["/var/www/html/sandboxes/dj/knot_site/c/example /var/www/html/sandboxes/dj/knot_site/c/"];
    reducedCodesFound = Import["/var/www/html/sandboxes/dj/knot_site/c/reduced_codes.txt", "Data"];

    (* get the reduced version of the codes that have been found along with the pd code being checked *)
    (* if this list is bigger than the first, then the pd being checked is distinct *)
    exportPDsAsTxt[Union[codesFound, {pdcode}], "/var/www/html/sandboxes/dj/knot_site/c/pdcodes.txt"];
    Run["/var/www/html/sandboxes/dj/knot_site/c/example /var/www/html/sandboxes/dj/knot_site/c/"];
    reducedCodesFoundWithPDCode = Import["/var/www/html/sandboxes/dj/knot_site/c/reduced_codes.txt", "Data"];

    Return[Length[reducedCodesFound] == Length[reducedCodesFoundWithPDCode]];

];

allMinimalDiagrams = {};

getAllMinimalDiagrams[pdcode_]:=Module[{pdlist=removePDCode@pdcode, allFlypesPerformed},

    (* if it's already been found, do nothing i.e. the base case *)
    If[hasPDCodeBeenFound[pdlist, allMinimalDiagrams], Return[]];

    (* if it's not an empty list (those are returned sometimes) *)
    If[Length[pdlist] != 0, AppendTo[allMinimalDiagrams, pdlist]];

    (* recursive call *)
    allFlypesPerformed = performAllFlypes[pdlist];
    getAllMinimalDiagrams/@allFlypesPerformed;

];


getAllMinimalDiagrams[knot];

If[Length[allMinimalDiagrams] == 1,
    Export["/var/www/html/sandboxes/dj/knot_site/c/reduced_codes.txt", ToString/@(replacePDCode/@allMinimalDiagrams)],
    exportPDsAsTxt[allMinimalDiagrams, "/var/www/html/sandboxes/dj/knot_site/c/pdcodes.txt"];
    Run["/var/www/html/sandboxes/dj/knot_site/c/example /var/www/html/sandboxes/dj/knot_site/c/"]
];