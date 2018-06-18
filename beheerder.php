<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");
include_once("lib/Product.php");
include_once("lib/Attractie.php");
include_once('lib/Saldo.php');

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder') {
    header('Location: login.php');
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
<div class="container">
    <div class="page-header">
        <h1>Beheren</h1>
    </div>

    <div class="row">
        <?php foreach ($geldvoorraad as $key => $geld) { ?>
        <h3 class="col-xs-11">Saldo: € <?php echo htmlspecialchars($geld->getSaldo()); ?></h3>
        <?php } ?>
    </div>

    <div class="row">
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
                <th><a href="beheerder.php?deleteGebruiker=<?php echo htmlspecialchars($geb->getIdgebruiker()); ?>"><img
                                class="prullenbak" src="img/prullenbakOpen.jpg"
                                value="<?php echo htmlspecialchars($geb->getIdgebruiker()); ?>"></a>
                    <?php } ?>
                    <?php if ($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving() == "Beheerder") { ?>
                <th><img class="prullenbak" src="img/prullenbakDicht.jpg"
                         value="<?php echo htmlspecialchars($geb->getIdgebruiker()); ?>">
                    <?php } ?>
                <th><a class="btn btn-info" role="button"
                       href="formGebruiker.php?id=<?php echo htmlspecialchars($geb->getIdgebruiker()); ?>"><?php echo htmlspecialchars($geb->getIdgebruiker()); ?></a>
                </th>
                <th class="tabelText"><?php echo htmlspecialchars($geb->getVolledigeNaam()); ?></th>
                <th class="tabelText"><?php echo htmlspecialchars($geb->getLogin()); ?></th>
                <th class="tabelText"><?php echo htmlspecialchars($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving()); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <div class="row">
        <h3 class="col-xs-11">Voorraad</h3>
        <a style="margin-top: 16px;" class="btn btn-default" role="button" href="formWinkel.php">+</a>
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
                <th><a href="beheerder.php?deleteProduct=<?php echo htmlspecialchars($prod->getIdproduct()); ?>"><img
                                class="prullenbak" src="img/prullenbakOpen.jpg"
                                value="<?php echo htmlspecialchars($prod->getIdproduct()); ?>"></a>
                <th class="tabelText"><a class="btn btn-info" role="button"
                                         href="formProduct.php?id=<?php echo htmlspecialchars($prod->getIdproduct()); ?>"><?php echo htmlspecialchars($prod->getIdproduct()); ?></a>
                </th>
                <th class="tabelText"><?php echo htmlspecialchars($prod->getTitel()); ?></th>
                <th class="tabelText"><?php echo htmlspecialchars($prod->getVoorraad()); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <div class="row">
        <h3 class="col-xs-11">Attracties</h3>
        <a style="margin-top: 16px;" class="btn btn-default" role="button" href="formAttractieToevoegen.php">+</a>
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
                <th><a href="beheerder.php?deleteProduct=<?php echo htmlspecialchars($attractie->getIdattractie()); ?>"><img
                                class="prullenbak" src="img/prullenbakOpen.jpg"
                                value="<?php echo htmlspecialchars($attractie->getIdattractie()); ?>"></a>
                <th class="tabelText"><a class="btn btn-info" role="button"
                                         href="formAttractie.php?id=<?php echo htmlspecialchars($attractie->getIdattractie()); ?>"><?php echo htmlspecialchars($attractie->getIdattractie()); ?></a>
                </th>
                <th class="tabelText"><?php echo htmlspecialchars($attractie->getTitel()); ?></th>
                <th class="tabelText"><?php echo htmlspecialchars($attractie->getOmschrijving()); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

</div>
<?php
include("layout/footer.php");
?>
