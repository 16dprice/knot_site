<?php

// get tab constant
$tab = filter_input(INPUT_POST, "entryConst", FILTER_SANITIZE_NUMBER_INT);

// set session tab var to be used by shell
$_SESSION["tab"] = $tab;