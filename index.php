<?php

$form = "<form action='php/upload.php' method='post' enctype='multipart/form-data'>
    
    Select file to upload:
    <input type='file' name='fileToUpload' id='fileToUpload'>
    <input type='submit' value='Upload File' name='submit'>

</form>
";

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