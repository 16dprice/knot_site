<?php

// get the pd codes that will be stored into the database
$pdInput = filter_input(INPUT_POST, "pdInput", FILTER_SANITIZE_STRING);
$pdInput = html_entity_decode($pdInput); // so pdInput is just pure JSON

// get the knot type that will go into the database
$knotType = filter_input(INPUT_POST, "knotType", FILTER_SANITIZE_STRING);

// instance of database
$db = Database::getInstance();

// the pdInput will be stored as raw JSON in a LONGTEXT field
$query = "INSERT INTO minimal_diagrams (knot_type, pd_codes) VALUES ('$knotType', '$pdInput');";

$isValid = $db->runInsertQuery($query);

// return an array with the success of the query and what the query actually was
$retArray = [];
$retArray["success"] = $isValid;
$retArray["query"] = $query;

echo json_encode($retArray, JSON_FORCE_OBJECT);