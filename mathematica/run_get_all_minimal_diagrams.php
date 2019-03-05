<?php

//<editor-fold desc="Error Reporting">

// setup error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//</editor-fold>

//<editor-fold desc="Autoload">

require_once("../php/autoload/autoload.class.php");

new Autoload(['../php']);

//</editor-fold>

function getPDsFromTxtFile($file) {

    if($file != NULL) {

        $pdCount = -1;
        $PDs = [];

        while (!feof($file)) {

            $line = fgets($file);

            if (strpos($line, "PD") !== false) {
                // if the line has PD in it, it's a new pd code
                $pdCount++;

                $PDs[$pdCount] = $line;

            } else if (strpos($line, "X[") !== false) {
                // if the line didn't have PD in it but does have X[ in it, it's not the end of the pd code yet
                // so append it
                $PDs[$pdCount] .= $line;
            }

        }

        return $PDs;

    }

}

$knotData = [
    [
        "crossings" => 3,
        "count" => 1
    ],
    [
        "crossings" => 4,
        "count" => 1
    ],
    [
        "crossings" => 5,
        "count" => 2
    ],
    [
        "crossings" => 6,
        "count" => 3
    ],
    [
        "crossings" => 7,
        "count" => 7
    ],
    [
        "crossings" => 8,
        "count" => 21
    ],
    [
        "crossings" => 9,
        "count" => 49
    ],
    [
        "crossings" => 10,
        "count" => 165
    ],
    [
        "crossings" => 11,
        "count" => 367
    ],
    [
        "crossings" => 12,
        "count" => 1288
    ],
    [
        "crossings" => 13,
        "count" => 4878
    ],
    [
        "crossings" => 14,
        "count" => 19536
    ],
    [
        "crossings" => 15,
        "count" => 85263
    ],
    [
        "crossings" => 16,
        "count" => 379799
    ],
];

$db = Database::getInstance();

//$crossings = 8;
//$listing = 21;
//echo getcwd() . "<br>";
//$output = shell_exec(getcwd() . "/get_all_minimal_diagrams.wls $crossings $listing");
//if(strpos($output, '$Aborted') !== false) { echo "found it"; }

foreach($knotData as $knotInfo) {

    // get the crossings and number of knots in the knot table with those crossings
    $crossings = $knotInfo["crossings"];
    $count = $knotInfo["count"];

    for($listing = 1; $listing <= $count; $listing++) {
        $output = shell_exec("./get_all_minimal_diagrams.wls $crossings $listing");

        // if the operation wasn't aborted, then store results
        if (strpos($output, '$Aborted') === false) {

            $reducedCodes = fopen("../c/reduced_codes.txt", "r");
            $reducedCodes = getPDsFromTxtFile($reducedCodes);

            // run the queries
            foreach ($reducedCodes as $code) {
                $query = "INSERT INTO minimal_diagrams (crossings, listing, pd_code) VALUES ($crossings, $listing, '$code')";
                $db->runInsertQuery($query);
            }

        }

    }

}