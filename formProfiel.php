<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");

$id = $_GET['id'];

if (!isset($_SESSION['login']) || $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
    return;
}

$gebruiker = new Gebruiker();
$rechten = new Rechten();
$user = $gebruiker->getGebruikerById($id);
$pagina = 'profiel';
$error = false;

if (isset($_POST['persoonsgegevensOpslaan'])) {
    extract($_POST);
    $gebruiker = new Gebruiker();
    $voornaam = preg_replace('/\s+/', '', $_POST['voornaam']);
    $tussenvoegsels = $_POST['tussenvoegsels'];
    $achternaam = preg_replace('/\s+/', '', $_POST['achternaam']);
    $login = preg_replace('/\s+/', '', $_POST['login']);

    if (ctype_alpha($voornaam) == false) {
        $error_message[] = 'Alleen letters zijn toegestaan voor de voornaam.';
    }

    if (ctype_alpha($tussenvoegsels) == false && $tussenvoegsels != '') {
        $error_message[] = 'Alleen letters zijn toegestaan voor de tussenvoegsels.';
    }

    if (ctype_alpha($achternaam) == false) {
        $error_message[] = 'Alleen letters zijn toegestaan voor de achternaam.';
    }

    if ($voornaam != '' && $achternaam != '' && $login != '') {
        if (!isset($error_message)) {
            $gebruiker->updatePersoonsgegevens($id, $login, $voornaam, $tussenvoegsels, $achternaam);
            $messages[] = 'Uw persoonsgegevens zijn aangepast.';
            header('Location: formProfiel.php?id='. $id);
        }
    }
} else if (isset($_POST['wachtwoordOpslaan'])) {
    $wachtwoord = preg_replace('/\s+/', '', $_POST['wachtwoord']);
    if (password_verify($_POST['wachtwoord'], $user->getWachtwoord()) && !empty($_POST['nieuwWachtwoord']) && $_POST['nieuwWachtwoord'] == $_POST['herhaalWachtwoord']) {
        extract($_POST);
        $gebruiker->updateWachtwoord($id, password_hash($_POST['nieuwWachtwoord'], PASSWORD_DEFAULT));
        $messages[] = 'Wachtwoord is aangepast.';
    } else {
        $error_message[] = 'Het nieuwe wachtwoord komt niet overeen.';
    }
} else if (isset($_POST['profielFotoOpslaan'])) {
    extract($_POST);
    $gebruiker->updateAvatar($id, $avatar);
    header('Location: formProfiel.php?id='. $id);
}
include("layout/header.php");
?>
<?php if (isset($error_message) && (isset($_POST['persoonsgegevensOpslaan']) || isset($_POST['wachtwoordOpslaan']))) {
    foreach ($error_message as $key => $error) { ?>
        <div class="alert alert-danger" role="alert">
            <strong><?= htmlspecialchars($error); ?></strong>
        </div>
    <?php }
} ?>
<?php if (isset($messages) && (isset($_POST['persoonsgegevensOpslaan']) || isset($_POST['wachtwoordOpslaan']))) { ?>
    <?php foreach ($messages as $key => $message) { ?>
        <div class="alert alert-success" role="alert">
            <strong><?= htmlspecialchars($message); ?></strong>
        </div>
    <?php }
}
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
                    <input required type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars($user->getLogin()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="voornaam" class="col-sm-2 control-label">Voornaam</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="voornaam" name="voornaam" value="<?= htmlspecialchars($user->getNaam()); ?>">
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
                    <input required type="password" class="form-control" id="wachtwoordHerhalen" name="herhaalWachtwoord" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="wachtwoordOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Profiel foto</h3>
        <form action="uploadProfiel.php?id=<?php echo $_SESSION['login']['idgebruiker']; ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profielFoto" class="col-sm-2 control-label">Profiel foto</label>
                <div id="uploadButton" class="col-sm-10">
                    <input type="file" name="fileToUpload" id="profielFoto">
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