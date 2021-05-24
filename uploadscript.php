<?php

error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    $id = $_POST['id'];
    $path = "uploads/"; //set your folder path
    $ext = pathinfo($_FILES['video_local']['name'], PATHINFO_EXTENSION);
    $mp3_local = rand(0, 99999) . "_" . str_replace(" ", "-", "Vid" . $id . "." . $ext);

    $tmp = $_FILES['video_local']['tmp_name'];
    if (move_uploaded_file($tmp, $path . $mp3_local)) { //check if it the file move successfully.
        echo $mp3_local;
    } else {
        echo "failed";
    }
    exit;
}