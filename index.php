<?php

shell_exec("c/example");

$originalCodes = fopen("c/pdcodes.txt", "r");

while(!feof($originalCodes)) {
    echo fgets($originalCodes) . "<br>";
}

echo "<br>----------------------------------------<br><br>";

$reducedCodes = fopen("c/reduced_codes.txt", "r");

$count = 0;
while(!feof($reducedCodes)) {
    echo fgets($reducedCodes) . "<br>";
    $count++;
}

echo "<br><h1>$count codes when reduced</h1>";