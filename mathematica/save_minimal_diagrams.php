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

$db = Database::getInstance();

$reducedCodes = fopen($argv[1] . "/reduced_codes.txt", "r");
$reducedCodes = getPDsFromTxtFile($reducedCodes);

$crossings = $argv[2];
$listing = $argv[3];

// run the queries
foreach ($reducedCodes as $code) {
    $query = "INSERT INTO minimal_diagrams_14cr (crossings, listing, pd_code) VALUES ($crossings, $listing, '$code')";
    $db->runInsertQuery($query);
}