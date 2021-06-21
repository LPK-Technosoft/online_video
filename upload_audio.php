<?php

error_reporting(0);
if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    $id = $_POST['id'];
    $path = "uploads/audio/"; //set your folder path
    $ext = pathinfo($_FILES['audio_local']['name'], PATHINFO_EXTENSION);
    $mp3_local = rand(0, 99999) . "_" . str_replace(" ", "-", "Aud" . $id . "." . $ext);

    $tmp = $_FILES['audio_local']['tmp_name'];
    //print_r($_FILES['audio_local']);
    if (move_uploaded_file($tmp, $path . $mp3_local)) { //check if it the file move successfully.
        echo $mp3_local;
    } else {
        echo "failed";
    }
    exit;
}