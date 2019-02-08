<?php

session_start();

//<editor-fold desc="Error Reporting">

// setup error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//</editor-fold>

//<editor-fold desc="Tab Constants">

const HOME_TAB = 20;
const SIMPLIFY_PD = 21;
const UPLOAD_PD_CODES = 22;

//</editor-fold>

//<editor-fold desc="Autoload">

require_once("php/autoload/autoload.class.php");

new Autoload(['php']);

//</editor-fold>

$runShell = TRUE;

if(isset($_REQUEST['AJAX']) && $_REQUEST['AJAX'] == TRUE) {

    $runShell = FALSE;

    if(isset($_REQUEST['file'])) {
        include($_REQUEST['file']);
        die('');
    }
}

if($runShell) {

    // init shell
    $shell = new Shell();

    // get the html from the shell with page title
    $html = $shell->getHtml("Knot Site");

    // echo the html
    echo $html;

}