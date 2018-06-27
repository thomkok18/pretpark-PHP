<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");

if (isset($_POST['registreren'])) {
    extract($_POST);
    $gebruiker = new Gebruiker();
    $voornaam = preg_replace('/\s+/', '', $_POST['voornaam']);
    $tussenvoegsels = $_POST['tussenvoegsels'];
    $achternaam = preg_replace('/\s+/', '', $_POST['achternaam']);
    $login = preg_replace('/\s+/', '', $_POST['login']);
    $wachtwoord = preg_replace('/\s+/', '', $_POST['wachtwoord']);

    if (ctype_alpha($voornaam) == false) {
        $error_message[] = 'Alleen letters zijn toegestaan voor de voornaam.';
    }

    if (ctype_alpha($tussenvoegsels) == false && $tussenvoegsels != '') {
        $error_message[] = 'Alleen letters zijn toegestaan voor de tussenvoegsels.';
    }

    if (ctype_alpha($achternaam) == false) {
        $error_message[] = 'Alleen letters zijn toegestaan voor de achternaam.';
    }

    if ($voornaam != '' && $achternaam != '' && $login != '' && $wachtwoord != '') {
        if (!isset($error_message)) {
            $gebruiker->setNaam($voornaam);
            $gebruiker->setTussenvoegsels($tussenvoegsels);
            $gebruiker->setAchternaam($achternaam);
            $gebruiker->setLogin($login);
            $gebruiker->setWachtwoord(password_hash($wachtwoord, PASSWORD_DEFAULT));
            $gebruiker->setIdRechten('2');
            $gebruiker->setAvatar('img/profiel.png');

            if ($gebruiker->insertGebruiker()) {
                header('Location: login.php');
            } else {
                $error_message[] = "Gebruiker is niet toegevoegd.";
            }
        }
    } else {
        $error_message[] = "Vul alle verplichte gegevens in.";
    }
}

$pagina = 'registreren';

include("layout/header.php");
?>
    <?php if (isset($_POST['registreren']) && isset($error_message)) { ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($error_message as $key => $error){ ?>
        <strong><?= htmlspecialchars($error) . "<br>"; ?></strong>
        <?php } ?>
    </div>
    <?php } ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <h1>Registreren</h1>
                <p>* zijn verplichte velden.</p>
            </div>
        </div>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="voornaam" class="col-sm-2 control-label">* Voornaam</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="voornaam" name="voornaam" placeholder="Voornaam">
                </div>
            </div>
            <div class="form-group">
                <label for="tussenvoegsels" class="col-sm-2 control-label">Tussenvoegsels</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tussenvoegsels" name="tussenvoegsels" placeholder="Tussenvoegsels">
                </div>
            </div>
            <div class="form-group">
                <label for="achternaam" class="col-sm-2 control-label">* Achternaam</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="achternaam" name="achternaam" placeholder="Achternaam">
                </div>
            </div>
            <div class="form-group">
                <label for="login" class="col-sm-2 control-label">* Login</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="login" name="login" placeholder="Login">
                </div>
            </div>
            <div class="form-group">
                <label for="wachtwoord" class="col-sm-2 control-label">* Wachtwoord</label>
                <div class="col-sm-10">
                    <input required type="password" class="form-control" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="registreren">Registreren</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>