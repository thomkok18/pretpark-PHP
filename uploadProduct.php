<?php
include_once('lib/config.php');
include_once("lib/Product.php");

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    return;
}

$id = $_GET['id'];
$product = new Product();
$upload_folder = '/img/';
$allowed_mime = ['image/png', 'image/jpeg'];

if (isset($_POST['productFotoOpslaan']) && isset($_FILES['fileToUpload'])) {
    $file_mime = mime_content_type($_FILES['fileToUpload']['tmp_name']);
    $corrupt = isCorrupt($_FILES['fileToUpload']['tmp_name']);
    if (in_array($file_mime, $allowed_mime)) {
        $file_ext = getExtension($file_mime);
        $target = getcwd() . $upload_folder . $product->getProductTitelById($id)[0] . "." . $file_ext;
        if (!$corrupt) {
            if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) {
                $message = 'Profiel foto is geupload!';
                header('Location:formProduct.php?id=' . $id . '&productAantal=0');
            } else {
                $message = 'Er is een fout opgetreden bij het verplaatsen van je foto!';
            }
        } else {
            $message = 'Dit bestand is beschadigd!';
        }
    } else {
        $message = 'Dit type bestand is verboden!';
    }
} else {
    $message = 'Er is geen bestand geupload of de post variabele is niet gezet!';
}

function getExtension($file_mime) {
    $mime = explode('/', $file_mime);
    $ext = end($mime);
    if ($ext == 'jpeg' || $ext == 'jpg') $ext = 'png';
    return $ext;
}

function isCorrupt($image) {
    try {
        new Imagick($image);
        return false;
    } catch (ImagickException $e) {
        return true;
    }
}

echo $message;