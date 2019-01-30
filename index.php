<?php

//<editor-fold desc="Error Reporting">

// setup error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//</editor-fold>

//<editor-fold desc="Autoload">
require_once("php/autoload/autoload.class.php");

new Autoload(['php']);
//</editor-fold>

$form = new HTML_Element("form");
$form->action = 'php/upload.php';
$form->method = 'post';
$form->enctype = 'multipart/form-data';

$form->text .= "Select file to Upload:";
$form->text .= new HTML_Element("input", ['type' => 'file', 'name' => 'fileToUpload', 'id' => 'fileToUpload']);
$form->text .= new HTML_Element("input", ['type' => 'submit', 'value' => 'Upload File', 'name' => 'submit']);

$form->style = "width: 80%; margin: 0 auto;";

echo $form;
echo "<br><br>";

$cwd = getcwd();
shell_exec("c/example $cwd/c/"); // need $cwd because c script needs full path (makes it easier)


$originalCodes = fopen("c/pdcodes.txt", "r");
$reducedCodes = fopen("c/reduced_codes.txt", "r");


$PDprocessor = new Simplified_PD_Processor($originalCodes, $reducedCodes);

$inputDisplay = $PDprocessor->getInputFileContainer();
$outputDisplay = $PDprocessor->getOutputFileContainer();

echo $inputDisplay;
echo "<br><br>";
echo $outputDisplay;