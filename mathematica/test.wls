#!/usr/bin/env wolframscript

(*ParallelMap[f[#]&,{1,2,3,4,5,6,7,8}];

Print[$KernelCount];*)

<<FlypeCode`
(*
reversePDcode[pdcode_] :=
 With[{pdlist = removePDCode@pdcode,
   f := (RotateRight@Reverse@Range[2*Length[pdcode]])[[#]] &},
  Return[f /@ pdlist]];


knotWithReverse[n_,k_] := {PD@Knot[n,k], replacePDCode@reversePDcode[PD@Knot[n,k]]};

For[n = 8, n <= 9, n++,

    For[k = 1, k <= NumberOfKnots[n, Alternating], k++,
        testList = knotWithReverse[n,k];

        exportPDsAsTxt[testList, "/var/www/html/sandboxes/dj/knot_site/c/pdcodes.txt"];

        Run["/var/www/html/sandboxes/dj/knot_site/c/example /var/www/html/sandboxes/dj/knot_site/c/ >/dev/null"];

        reducedCodesFound = Import["/var/www/html/sandboxes/dj/knot_site/c/reduced_codes.txt", "Data"];

        If[Length@reducedCodesFound != 2, Print[{n,k}];Print["\n"];];
    ];
];*)
CSavePath = "/var/www/html/sandboxes/dj/knot_site/c/p4/";
Run["/var/www/html/sandboxes/dj/knot_site/c/example " <> CSavePath];