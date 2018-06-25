<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder' && $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
    return;
}

$id = $_GET['id'];
$gebruiker = new Gebruiker();
$rechten = new Rechten();
$user = $gebruiker->getGebruikerById($id);
$pagina = '';

if (isset($_POST['persoonsgegevensOpslaan'])) {
    extract($_POST);
    $gebruiker->updatePersoonsgegevens($id, $login, $naam, $tussenvoegsels, $achternaam);
    header('Location: formGebruiker.php?id='. $id);
} else if (isset($_POST['wachtwoordOpslaan'])) {
    extract($_POST);
    $gebruiker->updateWachtwoord($id, password_hash($wachtwoord, PASSWORD_DEFAULT));
    header('Location: formGebruiker.php?id='. $id);
} else if (isset($_POST['rechtenOpslaan'])) {
    extract($_POST);
    $gebruiker->updateRechten($id, $idrechten);
    header('Location: formGebruiker.php?id='. $id);
}
include("layout/header.php");
?>

    <div>
        <div class="page-header">
            <h1>Gebruiker Aanpassen</h1>
        </div>

        <h3>Persoonlijke gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">Id</label>
                <div class="col-sm-10">
                    <input required disabled type="text" class="form-control" id="id" name="idgebruiker" value="<?= htmlspecialchars($id); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($user->getLogin()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="naam" class="col-sm-2 control-label">Voornaam</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="naam" name="naam" value="<?= htmlspecialchars($user->getNaam()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tussenvoegsels" class="col-sm-2 control-label">Tussenvoegsels</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tussenvoegsels" name="tussenvoegsels" value="<?= htmlspecialchars($user->getTussenvoegsels()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="achternaam" class="col-sm-2 control-label">Achternaam</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="achternaam" name="achternaam" value="<?= htmlspecialchars($user->getAchternaam()); ?>">
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

        <h3>Rechten</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="rechten" class="col-sm-2 control-label">Rechten</label>
                <div class="col-sm-10">
                    <select class="form-control" id="rechten" name="idrechten">
                        <?php if ($gebruiker->getRechtomschrijvingByIdGebruiker($id)[0] === "1") { ?>
                        <option value="1">Beheerder</option>
                        <option value="2">Bezoeker</option>
                        <?php } else { ?>
                        <option value="2">Bezoeker</option>
                        <option value="1">Beheerder</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="rechtenOpslaan">Opslaan</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>