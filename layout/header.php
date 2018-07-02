<?php
include_once("lib/Gebruiker.php");
include_once("lib/Winkelwagen.php");

$gebruiker = new Gebruiker();
$gebruikers = $gebruiker->getGebruikers();
$winkelwagen = new Winkelwagen();


if (isset($_SESSION['login'])) {
    $user = $gebruiker->getGebruikerById($_SESSION['login']['idgebruiker']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" href="img/pretpark_favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
          crossorigin="anonymous">
    <link rel="stylesheet" href="css/header.css">
    <?php if ($pagina === 'beheerder') { ?>
        <link rel="stylesheet" href="css/beheerder.css">
    <?php } else if ($pagina === 'attractie') { ?>
        <link rel="stylesheet" href="css/attractie.css">
    <?php } else if ($pagina === 'profiel') { ?>
        <link rel="stylesheet" href="css/formProfiel.css">
    <?php } else if ($pagina === 'attractie') { ?>
        <link rel="stylesheet" href="css/index.css">
    <?php } else if ($pagina === 'winkel') { ?>
        <link rel="stylesheet" href="css/winkel.css">
    <?php } else if ($pagina === 'winkelwagen') { ?>
        <link rel="stylesheet" href="css/winkelwagen.css">
    <?php } else if ($pagina === 'product') { ?>
        <link rel="stylesheet" href="css/formProduct.css">
    <?php } else if ($pagina === 'index') { ?>
        <link rel="stylesheet" href="css/index.css">
    <?php } else if ($pagina === 'formAttractie') { ?>
        <link rel="stylesheet" href="css/formAttractie.css">
    <?php } else if ($pagina === 'formAttractieToevoegen') { ?>
        <link rel="stylesheet" href="css/formAttractieToevoegen.css">
    <?php } else if ($pagina === 'voorraad') { ?>
        <link rel="stylesheet" href="css/formWinkel.css">
    <?php } ?>
</head>
<body>
<!-- Static navbar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if ($pagina === 'attractie') { ?> class="active" <?php } ?> ><a href="index.php">Attracties</a></li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login']['rechten'] == 'Beheerder') { ?>
                    <li <?php if ($pagina === 'beheerder') { ?> class="active" <?php } ?> ><a href="beheerder.php">Beheren</a></li>
                <?php } ?>
                <?php if (!isset($_SESSION['login'])) { ?>
                    <li <?php if ($pagina === 'registreren') { ?> class="active" <?php } ?> ><a href="registreren.php">Registreren</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li <?php if ($pagina === 'winkel') { ?> class="active" <?php } ?> ><a id="winkel" href="winkel.php">Winkel</a></li>
                <?php } ?>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li <?php if ($pagina === 'winkelwagen') { ?> class="active" <?php } ?> ><a id="winkelwagenLink" href="winkelwagen.php?id=<?= $_SESSION['login']['idgebruiker']; ?>"><img
                                    id="winkelwagen" src="img/shopping_cart.png"><span id="iconCartCount">
                            <?php if (isset($winkelwagen->getWinkelwagentjeById($_SESSION['login']['idgebruiker'])[0])) {
                                echo htmlspecialchars($winkelwagen->getWinkelwagentjeById($_SESSION['login']['idgebruiker'])[0]);
                            } else {
                                echo htmlspecialchars(0);
                            } ?> </span></a></li>
                <?php } ?>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li><a href="loguit.php">Uitloggen</a></li>
                    <li <?php if ($pagina === 'profiel') { ?> class="active" <?php } ?>><a id="profiel" href="formProfiel.php?id=<?php foreach ($gebruikers as $key => $geb) {
                            if ($_SESSION['login']['idgebruiker'] == $geb->getIdgebruiker()) {
                                echo htmlspecialchars($geb->getIdgebruiker());
                            }
                        } ?>">
                            <img id="profielAfbeelding" src="<?= htmlspecialchars($user->getAvatar()); ?>" alt="<?= htmlspecialchars($user->getLogin()); ?>">
                            <p id="profielnaam"><?= htmlspecialchars($_SESSION['login']['login']); ?></p></a></li>
                <?php } else { ?>
                    <li <?php if ($pagina === 'login') { ?> class="active" <?php } ?>><a href="login.php">Inloggen</a>
                    </li>
                <?php } ?>
            </ul>

        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
<img src="img/pretpark_logo.png" id="pretparkLogo" class="img-responsive" alt="logo pretpark">
<div class="container">
