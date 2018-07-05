<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Attractie.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder' && $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
    return;
}

$pagina = 'formAttractieToevoegen';

if (isset($_POST['toevoegen'])) {
    extract($_POST);
    $attractie = new Attractie();
    $attractie->setTitel($titel);
    $attractie->setOmschrijving($omschrijving);
    $attractie->setUrlfoto($urlfoto);
    $attractie->setIdgebruiker($_SESSION['login']['idgebruiker']);
    header('Location: index.php');

    if ($attractie->insertAttractie()) {
        $message[] = "Attractie is toegevoegd";
    } else {
        $message[] = "Attractie is niet toegevoegd";
    }
}

include("layout/header.php");
?>

    <div>
        <div class="page-header">
            <h1>Attractie Toevoegen</h1>
        </div>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="titel" class="col-lg-2 control-label">Titel</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" id="titel" name="titel" placeholder="Titel">
                </div>
            </div>
            <div class="form-group">
                <label for="omschrijving" class="col-lg-2 control-label">Attractie omschrijving</label>
                <div class="col-lg-10">
                    <textarea required class="form-control" rows="5" id="omschrijving" name="omschrijving"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="attractieFoto" class="col-lg-2 control-label">Attractie foto</label>
                <div id="uploadButton" class="col-lg-10">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default" name="toevoegen">Toevoegen</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>