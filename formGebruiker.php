<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");

$id = $_GET['id'];
$gebruiker = new Gebruiker();
$rechten = new Rechten();
$user = $gebruiker->getGebruikerById($id);

if (isset($_POST['aanpassen'])) {
    extract($_POST);
    $gebruiker->updateGebruiker($id, $naam, $tussenvoegsels, $achternaam, $login, $wachtwoord, $idrechten);
//    $gebruiker->setNaam($naam);
//    $gebruiker->setTussenvoegsels($tussenvoegsels);
//    $gebruiker->setAchternaam($achternaam);
//    $gebruiker->setLogin($login);
//    $gebruiker->setWachtwoord(password_hash($wachtwoord, PASSWORD_DEFAULT));
//    $gebruiker->setRechten($recht);

    if ($gebruiker->updateGebruiker($id, $naam, $tussenvoegsels, $achternaam, $login, $wachtwoord, $idrechten)) {
        $message[] = "Gebruiker is aangepast";
    } else {
        $message[] = "Gebruiker is niet aangepast";
    }
}

include("layout/header.php");
//if (isset($_POST['aanpassen'])) {
//    echo $message[0];
//}
?>

<!-- TODO form tags en submit knoppen toevoegen -->
    <div>
        <div class="page-header">
            <h1>Gebruiker Aanpassen</h1>
        </div>

        <h3>Persoonlijke gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">Id</label>
                <div class="col-sm-10">
                    <input disabled type="text" class="form-control" id="id" name="idgebruiker" value="<?php echo $id; ?>">
                </div>
            </div>
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

            <h3>Wachtwoord</h3>
            <div class="form-group">
                <label for="wachtwoordHuidig" class="col-sm-2 control-label">Huidige wachtwoord</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="wachtwoordHuidig" name="wachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="nieuwWachtwoord" class="col-sm-2 control-label">Nieuw wachtwoord</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="nieuwWachtwoord" name="nieuwWachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="wachtwoordHerhalen" class="col-sm-2 control-label">Wachtwoord herhalen</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="wachtwoordHerhalen" name="wachtwoordHerhalen"
                           value="">
                </div>
            </div>

            <h3>Rechten</h3>
            <div class="form-group">
                <label for="rechten" class="col-sm-2 control-label">Rechten</label>
                <div class="col-sm-10">
                    <select class="form-control" id="rechten" name="idrechten">
                        <option value="1">Beheerder</option>
                        <option value="2">Bezoeker</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="aanpassen">Aanpassen</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>