<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");

$id = $_GET['id'];
$gebruiker = new Gebruiker();
$gebruiker = $gebruiker->getGebruikerById($id);

if (isset($_POST['aanpassen'])) {
    extract($_POST);
    $gebruiker->setNaam($naam);
    $gebruiker->setTussenvoegsels($tussenvoegsels);
    $gebruiker->setAchternaam($achternaam);
    $gebruiker->setLogin($login);
    $gebruiker->setWachtwoord($wachtwoord);
    $gebruiker->setRechten($rechten);

    if ($attractie->insertAttractie()) {
        $message[] = "Gebruiker is aangepast";
    } else {
        $message[] = "Gebruiker is niet aangepast";
    }
}

include("layout/header.php");
?>

    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <h1>Gebruiker Aanpassen</h1>
            </div>
        </div>
        <form class="form-horizontal" action="#" method="post">
            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">Id</label>
                <div class="col-sm-10">
                    <input disabled type="text" class="form-control" id="id" name="id" value="<?php echo $id; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="naam" class="col-sm-2 control-label">Voornaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="naam" name="naam" value="<?php echo $gebruiker->getNaam(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="tussenvoegsels" class="col-sm-2 control-label">Tussenvoegsels</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tussenvoegsels" name="tussenvoegsels"
                           value="<?php echo $gebruiker->getTussenvoegsels(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="achternaam" class="col-sm-2 control-label">Achternaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="achternaam" name="achternaam" value="<?php echo $gebruiker->getAchternaam(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="login" name="login" value="<?php echo $gebruiker->getLogin(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="wachtwoordHuidig" class="col-sm-2 control-label">Huidige wachtwoord</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="wachtwoordHuidig" name="wachtwoordHuidig" value="">
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
                    <input type="password" class="form-control" id="wachtwoordHerhalen" name="wachtwoordHerhalen" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="rechten" class="col-sm-2 control-label">Rechten</label>
                <div class="col-sm-10">
                    <select class="form-control" id="rechten" name="rechten" <?php echo $gebruiker->getRechten(); ?>>
                        <option>Beheerder</option>
                        <option>Bezoeker</option>
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