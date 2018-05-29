<?php
session_start();

include_once('lib/config.php');
include_once("lib/Gebruiker.php");

$id = $_GET['id'];

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder') {
    header('Location: login.php');
}

$product = new Product();
$productTitel = $product->getTitel();

$target_dir = "img/";
//TODO: Filenaam moet worden veranderd naar de titel van het product
$_FILES["fileToUpload"]["name"] = $_SESSION['login']['login'] . '.png';

$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $product->updateProductfoto($id, 'img/' . $_FILES["fileToUpload"]["name"]);
       header('Location: formProduct.php?id='.$id);
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>