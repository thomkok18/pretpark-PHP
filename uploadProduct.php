<?php
include_once('lib/config.php');
include_once("lib/Product.php");

$id = $_GET['id'];

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    return;
}

// Settings
$allowed_mime = array('image/png', 'image/jpeg');

// If statements with safety checks
if (isset($_FILES['file'])) {
    $target_mime = mime_content_type($_FILES['file']['tmp_name']);
    if (in_array($target_mime, $allowed_mime)) {
        $real_ext = getExtension($target_mime);
        $target = getcwd() . '/img/' . createName() . "." . $real_ext;
        if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
            $target_parts = explode('/file/', $target);
        } else {
            echo 'Sorry, there was a problem uploading your file.';
        }
    } else {
        echo 'That type of file isn\'t allowed by the server.';
    }
} else {
    echo 'You didn\'t upload a file.';
}

// Get the real extension of the file
function getExtension($file_mime) {
    $mime = explode('/', $file_mime);
    $ext = end($mime);
    if ($ext == 'jpeg') $ext = 'jpg';
    else if ($ext == 'png') $ext = 'png';
    return $ext;
}

// Create a random name for the uploaded file
function createName() {
    $name = '';
    $pos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';

    for ($i = 0; $i < 7; $i++) {
        $name .= $pos[rand(0, 61)];
    }

    return $name;
}
?>