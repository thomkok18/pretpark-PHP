<?php
session_start();

$id = $_GET['id'];

if (!isset($_SESSION['login']) || $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
}

include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");

$gebruiker = new Gebruiker();
$rechten = new Rechten();
$user = $gebruiker->getGebruikerById($id);
$pagina = 'profiel';

if (isset($_POST['persoonsgegevensOpslaan'])) {
    extract($_POST);
    $gebruiker->updatePersoonsgegevens($id, $login, $naam, $tussenvoegsels, $achternaam);
} else if (isset($_POST['wachtwoordOpslaan'])) {
    extract($_POST);
    $gebruiker->updateWachtwoord($id, password_hash($wachtwoord, PASSWORD_DEFAULT));
} else if (isset($_POST['profielFotoOpslaan'])) {
    extract($_POST);
    $gebruiker->updateAvatar($id, $avatar);
}

include("layout/header.php");
?>

    <div>
        <div class="page-header">
            <h1>Instellingen</h1>
        </div>

        <h3>Persoonlijke gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="login" name="login"
                           value="<?php echo $user->getLogin(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="naam" class="col-sm-2 control-label">Voornaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="naam" name="naam"
                           value="<?php echo $user->getNaam(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tussenvoegsels" class="col-sm-2 control-label">Tussenvoegsels</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tussenvoegsels" name="tussenvoegsels"
                           value="<?php echo $user->getTussenvoegsels(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="achternaam" class="col-sm-2 control-label">Achternaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="achternaam" name="achternaam"
                           value="<?php echo $user->getAchternaam(); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="persoonsgegevensOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Wachtwoord</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="wachtwoordHuidig" class="col-sm-2 control-label">Huidige wachtwoord</label>
                <div class="col-sm-10">
                    <input required type="password" class="form-control" id="wachtwoordHuidig" name="wachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="nieuwWachtwoord" class="col-sm-2 control-label">Nieuw wachtwoord</label>
                <div class="col-sm-10">
                    <input required type="password" class="form-control" id="nieuwWachtwoord" name="nieuwWachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="wachtwoordHerhalen" class="col-sm-2 control-label">Wachtwoord herhalen</label>
                <div class="col-sm-10">
                    <input required type="password" class="form-control" id="herhaalWachtwoord" name="herhaalWachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="wachtwoordOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Profiel foto</h3>
        <form action="upload.php?id=<?php foreach ($gebruikers as $key => $geb) { if ($_SESSION['login']['idgebruiker'] == $geb->getIdgebruiker()) { echo $geb->getIdgebruiker(); } } ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profielFoto" class="col-sm-2 control-label">Profiel foto</label>
                <div class="col-sm-10">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="profielFotoOpslaan">Opslaan</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>