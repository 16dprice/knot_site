#!/usr/bin/env wolframscript
Needs["FlypeCode`"];
ParallelNeeds["FlypeCode`"];

hasPDCodeBeenFound[pdcode_, codesFound_, CSavePath_] := Module[{reducedCodesFound, reducedCodesFoundWithPDCode},

   If[codesFound == {}, Return[False]];
   If[pdcode == {}, Return[True]];

   (*get the reduced version of the codes that have been found*)
   exportPDsAsTxt[codesFound, CSavePath <> "pdcodes.txt"];
   Run["/var/www/html/sandboxes/dj/knot_site/c/example " <> CSavePath];
   reducedCodesFound = Import[CSavePath <> "reduced_codes.txt", "Data"];

   (*get the reduced version of the codes that have been found along with the pd code being checked*)
   (*if this list is bigger than the first,then the pd being checked is distinct*)

   exportPDsAsTxt[Union[codesFound, {pdcode}], CSavePath <> "pdcodes.txt"];
   Run["/var/www/html/sandboxes/dj/knot_site/c/example " <> CSavePath];
   reducedCodesFoundWithPDCode = Import[CSavePath <> "reduced_codes.txt", "Data"];

   Return[ Length[reducedCodesFound] == Length[reducedCodesFoundWithPDCode] ];

];


SetAttributes[getAllMinimalDiagrams, HoldAll];
getAllMinimalDiagrams[pdcode_, retList_, CSavePath_] := Module[{pdlist = removePDCode@pdcode, allFlypesPerformed},

   (*if it's already been found,do nothing i.e.the base case*)
   If[hasPDCodeBeenFound[pdlist, retList, CSavePath], Return[]];

   (*if it's not an empty list (those are returned sometimes)*)
   If[Length[pdlist] != 0, AppendTo[retList, pdlist]];

   (*recursive call*)
   allFlypesPerformed = performAllFlypes[pdlist];
   getAllMinimalDiagrams[#, retList, CSavePath] & /@ allFlypesPerformed;

];


runGetAllMinimalDiagrams[knot_] := Module[{retList = {}, CSavePath, crossings, listing, pdcode},

   crossings = knot[[1]];
   listing = knot[[3]];

   pdcode = PD[Knot[crossings, Alternating, listing]];

   CSavePath = "/var/www/html/sandboxes/dj/knot_site/c/p" <> ToString[$KernelID] <> "/";

   getAllMinimalDiagrams[pdcode, retList, CSavePath];

   If[Length[retList] == 1,
       (* TRUE *)
       Export[CSavePath <> "reduced_codes.txt", ToString /@ (replacePDCode /@ retList)],
       (* FALSE *)
       exportPDsAsTxt[retList, CSavePath <> "pdcodes.txt"];
       Run["/var/www/html/sandboxes/dj/knot_site/c/example " <> CSavePath];
   ];

   Run["php /var/www/html/sandboxes/dj/knot_site/mathematica/save_minimal_diagrams.php " <> CSavePath <> " " <> ToString[crossings] <> " " <> ToString[listing]];

];

ParallelMap[ runGetAllMinimalDiagrams[#] &, AllKnots[14, Alternating] ];