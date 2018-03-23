<?php
include("layout/header.php");
include_once("lib/Gebruiker.php");

if (isset($_POST['login'])) {
    extract($_POST);
    $gebruiker = new Gebruiker();
    if ($resultaat = $gebruiker->checkLogin($wachtwoord, $login)) {
        echo "Ik ben ingelogd";
    } else {
        echo "Niet ingelogd";
    }
}
?>

    <div class="container">
        <div class="row">
            <div class="col-sm-offset-2 col-sm-10">
                <h1>Inloggen</h1>
            </div>
        </div>
        <form class="form-horizontal" action="#" method="post">
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
                    <button type="submit" class="btn btn-default">Login</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>