<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Attractie.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder') {
    header('Location: login.php');
    return;
}

$id = $_GET['id'];
$attractie = new Attractie();
$attracties = $attractie->getAttractieById($id);
$pagina = 'formAttractie';

if (isset($_POST['attractiegegevens'])) {
    extract($_POST);
    $attractie->updateAttractiegegevens($id, $_POST['titel'], $_POST['omschrijving']);
    header('Location: formAttractie.php?id=' . $id);
} else if (isset($_POST['attractieFotoOpslaan'])) {
    extract($_POST);
    $attractie->updateUrlfoto($id, $_POST['urlfoto']);
}

include("layout/header.php");
?>

    <div>
        <div class="page-header">
            <h1>Attractie Aanpassen</h1>
        </div>

        <h3>Attractie gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="titel" class="col-lg-2 control-label">Titel</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" id="titel" name="titel" value="<?= htmlspecialchars($attracties->getTitel()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="omschrijving" class="col-lg-2 control-label">Attractie omschrijving</label>
                <div class="col-lg-10">
                    <textarea required class="form-control" rows="5" id="omschrijving" name="omschrijving"><?= htmlspecialchars($attracties->getOmschrijving()); ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default" name="attractiegegevens">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Attractie foto</h3>
        <form action="uploadAttractie.php?id=<?= $id; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="attractieFoto" class="col-lg-2 control-label">Attractie foto</label>
                <div id="uploadButton" class="col-lg-10">
                    <input type="file" name="fileToUpload" id="attractieFoto">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default" name="attractieFotoOpslaan">Opslaan</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>