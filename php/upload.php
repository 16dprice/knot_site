<?php

$target_dir = "../c/";
$target_file = $target_dir . "pdcodes.txt";
$uploadOk = 1;

$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if($fileType != "txt") {
    $uploadOk = 0;
}

if($uploadOk == 0) {
    echo "Sorry, it didn't work.";
} else {
    if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The pdcodes file was uploaded.";
    } else {
        echo "Sorry. Error.";
    }
}

$hostName = $_SERVER['HTTP_HOST']; // need this in case if coming from local context (i.e. local IP instead of public URL)
$sitePath = $_SERVER['PHP_SELF']; // need this to differentiate between different contexts

//header("Location: http://$hostName");
header("Location: ../index.php");