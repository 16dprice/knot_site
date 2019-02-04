<?php

$valid_extensions = array('jpeg', 'jpg', 'png', 'gif', 'bmp', 'pdf', 'doc', 'ppt'); // valid extensions
$path = '/uploads/'; // upload directory

if (!empty($_POST['name']) || !empty($_POST['email']) || $_FILES['image']) {
    $img = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $errorimg = $_FILES['image']['error'];

    // get uploaded file's extension
    $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

    // can upload same image using rand function
    $final_image = rand(1000, 1000000) . $img;

    // check's valid format
    if (in_array($ext, $valid_extensions)) {
        $path = getcwd() . $path . strtolower($final_image);
        echo var_export($_FILES['image']) . "<br>";
        echo $path  . "<br>";
        if (move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
            echo "<img src='$path' />";
            $name = $_POST['name'];
            $email = $_POST['email'];

            echo "here";

        } else {
        }
    } else {
        echo 'invalid';
    }
}