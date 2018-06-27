<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");

$upload_folder = '/img/';
$allowed_mime = ['image/png', 'image/jpeg'];

if (isset($_POST['profielFotoOpslaan']) && isset($_FILES['fileToUpload'])) {
    $file_mime = mime_content_type($_FILES['fileToUpload']);
    if (in_array($file_mime, $allowed_mime)) {
        $file_ext = getExtension($file_mime);
        $target = getcwd() . $upload_folder . $_SESSION['login']['login'] . "." . $file_ext;
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target)) {
            $message = 'Profiel foto is geupload!';
        } else {
            $message = 'Er is een fout opgetreden bij het verplaatsen van je foto!';
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
    if ($ext == 'jpeg') $ext = 'jpg';
    return $ext;
}

echo $message;


//$upload_folder = '/profilePictureFolder???/';
//$allowed_mime = ['image/png', 'image/jpeg'];
//
//if (isset($_POST['changePicture???']) && isset($_FILES['fileToUpload???'])) {
//    $file_mime = mime_content_type($_FILES['fileToUpload???']);
//    if (in_array($file_mime, $allowed_mime)) {
//        $file_ext = getExtension($file_mime);
//        $target = getcwd() . $upload_folder . $_SESSION['user???']['name???'] . "." . $file_ext;
//        if (move_uploaded_file($_FILES['fileToUpload???']['tmp_name'], $target)) {
//            $message = 'Profiel foto is geupload!';
//        } else {
//            $message = 'Er is een fout opgetreden bij het verplaatsen van je foto!';
//        }
//    } else {
//        $message = 'Dit type bestand is verboden!';
//    }
//} else {
//    $message = 'Er is geen bestand geupload of de post variabele is niet gezet!';
//}
//
//function getExtension($file_mime) {
//    $mime = explode('/', $file_mime);
//    $ext = end($mime);
//    if ($ext == 'jpeg') $ext = 'jpg';
//    return $ext;
//}
?>