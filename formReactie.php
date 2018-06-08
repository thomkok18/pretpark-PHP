<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Attractie.php");
include_once("lib/Reactie.php");

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = 0;
}

$pagina = '';

if (isset($_POST['toevoegen'])) {
    extract($_POST);
    $reactie = new Reactie();
    $reactie->setReactietekst($reactietekst);
    $reactie->setIdGebruiker($_SESSION['login']['idgebruiker']);
    $reactie->setIdAttractie($id);

    if ($reactie->insertReactie()) {
        header('Location: attractie.php?id='. $id);
    } else {
        $message[] = "Reactie is niet toegevoegd";
    }
}

include("layout/header.php");
?>

    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <h1>Reactie Toevoegen</h1>
            </div>
        </div>
        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']."?id=".$id; ?>" method="post">
            <div class="form-group">
                <label for="reactietekst" class="col-sm-2 control-label">Reactie</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="5" id="reactietekst" name="reactietekst"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="toevoegen">Verstuur</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>