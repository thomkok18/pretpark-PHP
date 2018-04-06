<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");

if (isset($_POST['login'])) {
    extract($_POST);
    $gebruiker = new Gebruiker();
    $gebruiker->setNaam($voornaam);
    $gebruiker->setTussenvoegsels($tussenvoegsels);
    $gebruiker->setAchternaam($achternaam);
    $gebruiker->setLogin($login);
    $gebruiker->setWachtwoord(password_hash($wachtwoord, PASSWORD_DEFAULT));
    $gebruiker->setIdRechten('1');


    if ($gebruiker->insertGebruiker()) {
        $message[] = "Gebruiker is succesvol toegevoegd!";
    } else {
        $message[] = "Gebruiker is niet toegevoegd.";
    }
}

include("layout/header.php");
print_r($message);
?>

    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <h1>Registreren</h1>
            </div>
        </div>
        <form class="form-horizontal" action="#" method="post">
            <div class="form-group">
                <label for="voornaam" class="col-sm-2 control-label">Voornaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam">
                </div>
            </div>
            <div class="form-group">
                <label for="tussenvoegsels" class="col-sm-2 control-label">Tussenvoegsels</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tussenvoegsels" name="tussenvoegsels" placeholder="Tussenvoegsels">
                </div>
            </div>
            <div class="form-group">
                <label for="achternaam" class="col-sm-2 control-label">Achternaam</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam">
                </div>
            </div>
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">Login</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="login" name="login" placeholder="Login">
                </div>
            </div>
            <div class="form-group">
                <label for="wachtwoord" class="col-sm-2 control-label">Wachtwoord</label>
                <div class="col-sm-10">
                    <input required type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default">Registreren</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>