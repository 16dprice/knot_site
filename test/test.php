<?php

//<editor-fold desc="Error Reporting">

// setup error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//</editor-fold>

$servername = "db";
$username = "root";
$password = "research-pass124";
$dbname = "flype_db";

echo "$servername :: $username :: $password :: $dbname";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";