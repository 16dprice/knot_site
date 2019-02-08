<?php

$pdInput = filter_input(INPUT_POST, "pdInput", FILTER_SANITIZE_STRING);
$pdInput = json_decode(html_entity_decode($pdInput), TRUE);

$pdCount = $pdInput["count"];
$cwd = getcwd();

$pdInputFile = fopen("$cwd/c/pdcodes.txt", "w");

fwrite($pdInputFile, "$pdCount\n");

for($i = 0; $i < $pdCount; $i++) {
    fwrite($pdInputFile, $pdInput[$i]);
}

fclose($pdInputFile);

shell_exec("c/example $cwd/c");

$originalCodes = fopen("c/pdcodes.txt", "r");
$reducedCodes = fopen("c/reduced_codes.txt", "r");


$PDprocessor = new Simplify_PD_Processor($originalCodes, $reducedCodes);

$inputDisplay = $PDprocessor->getInputFileContainer();
$outputDisplay = $PDprocessor->getOutputFileContainer();

$retArray = [];

$retArray["inputContainer"] = $inputDisplay->__toString();
$retArray["outputContainer"] = $outputDisplay->__toString();

echo json_encode($retArray, JSON_FORCE_OBJECT);