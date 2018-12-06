<?php

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
$form->text .= new HTML_Element("input", ['type' => 'subimt', 'value' => 'Upload File', 'name' => 'submit']);

echo $form;
echo "<br><br>";

shell_exec("c/example");


$originalCodes = fopen("c/pdcodes.txt", "r");

while(!feof($originalCodes)) {
    echo fgets($originalCodes) . "<br>";
}

echo "<br>----------------------------------------<br><br>";

$reducedCodes = fopen("c/reduced_codes.txt", "r");

$count = -1; // starts at -1 because the file has an extra line at the end
while(!feof($reducedCodes)) {
    echo fgets($reducedCodes) . "<br>";
    $count++;
}

echo "<br><h1>$count codes when reduced</h1>";