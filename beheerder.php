<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");
include_once("lib/Product.php");
include_once("lib/Attractie.php");
include_once('lib/Saldo.php');

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] != 'Beheerder') {
    header('Location: login.php');
    return;
}

$gebruiker = new Gebruiker();
$gebruikers = $gebruiker->getGebruikers();
$rechten = new Rechten();
$product = new Product();
$producten = $product->getProducten();
$attractie = new Attractie();
$attracties = $attractie->getAttracties();
$saldo = new Saldo();
$geldvoorraad = $saldo->getSaldoVoorraad();

$pagina = 'beheerder';

if (isset($_GET['deleteGebruiker']) && !empty($_GET['deleteGebruiker'])) {
    $conn = new Gebruiker();
    $conn->deleteGebruiker();
    header('Location: beheerder.php');
} else if (isset($_GET['deleteProduct']) && !empty($_GET['deleteProduct'])) {
    $conn = new Product();
    $conn->deleteProduct();
    header('Location: beheerder.php');
}

include("layout/header.php");
?>
<div class="container-fluid">
    <div class="page-header">
        <h1>Beheren</h1>
    </div>

    <div>
        <?php foreach ($geldvoorraad as $key => $geld) { ?>
            <h3 class="col-xs-12 col-sm-2"><b>Saldo</b></h3>
            <h3 class="col-xs-12 col-sm-10">€ <?= htmlspecialchars($geld->getSaldo()); ?></h3>
        <?php } ?>
    </div>

    <div>
        <h3 class="col-xs-11">Gebruikers</h3>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Volledige naam</th>
            <th>Login</th>
            <th>Rechten</th>
        </tr>
        </thead>
        <?php foreach ($gebruikers as $key => $geb) { ?>
            <tbody>
            <tr>
                <?php if ($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving() == "Bezoeker") { ?>
                    <th><a href="beheerder.php?deleteGebruiker=<?= htmlspecialchars($geb->getIdgebruiker()); ?>"><img class="prullenbak" src="img/prullenbakOpen.jpg"></a></th>
                <?php } ?>
                <?php if ($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving() == "Beheerder") { ?>
                    <th><img class="prullenbak" src="img/prullenbakDicht.jpg"></th>
                <?php } ?>
                <th><a id="formGebruikerButton" class="btn btn-info" role="button" href="formGebruiker.php?id=<?= htmlspecialchars($geb->getIdgebruiker()); ?>"><?= htmlspecialchars($geb->getIdgebruiker()); ?></a></th>
                <th class="tabelText"><?= htmlspecialchars($geb->getVolledigeNaam()); ?></th>
                <th class="tabelText"><?= htmlspecialchars($geb->getLogin()); ?></th>
                <th class="tabelText"><?= htmlspecialchars($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving()); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <div>
        <h3 class="col-xs-11">Voorraad</h3>
        <a id="formWinkelButton" class="btn btn-default" role="button" href="formWinkel.php">+</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Product</th>
            <th>Voorraad</th>
        </tr>
        </thead>
        <?php foreach ($producten as $key => $prod) { ?>
            <tbody>
            <tr>
                <th><a href="beheerder.php?deleteProduct=<?= htmlspecialchars($prod->getIdproduct()); ?>"><img class="prullenbak" src="img/prullenbakOpen.jpg"></a>
                <th class="tabelText"><a id="formProductButton" class="btn btn-info" role="button" href="formProduct.php?id=<?= htmlspecialchars($prod->getIdproduct()); ?>&productAantal=0"><?= htmlspecialchars($prod->getIdproduct()); ?></a></th>
                <th class="tabelText"><?= htmlspecialchars($prod->getTitel()); ?></th>
                <?php if ($prod->getVoorraad() != 0) { ?>
                    <th class="tabelText"><?= htmlspecialchars($prod->getVoorraad()); ?></th>
                <?php } else { ?>
                    <th><b id="uitverkocht" class="tabelText">Uitverkocht</b></th>
                <?php } ?>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <div>
        <h3 class="col-xs-11">Attracties</h3>
        <a id="formAttractieToevoegenButton" class="btn btn-default" role="button" href="formAttractieToevoegen.php">+</a>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Titel</th>
            <th>Omschrijving</th>
        </tr>
        </thead>
        <?php foreach ($attracties as $key => $attractie) { ?>
            <tbody>
            <tr>
                <th><a href="beheerder.php?deleteProduct=<?= htmlspecialchars($attractie->getIdattractie()); ?>"><img class="prullenbak" src="img/prullenbakOpen.jpg"></a>
                <th class="tabelText"><a id="formAttractieButton" class="btn btn-info" role="button" href="formAttractie.php?id=<?= htmlspecialchars($attractie->getIdattractie()); ?>"><?= htmlspecialchars($attractie->getIdattractie()); ?></a></th>
                <th class="tabelText"><?= htmlspecialchars($attractie->getTitel()); ?></th>
                <th class="tabelText"><?= htmlspecialchars($attractie->getOmschrijving()); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

</div>
<?php
include("layout/footer.php");
?>
