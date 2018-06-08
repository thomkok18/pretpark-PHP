<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");
include_once("lib/Product.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder') {
    header('Location: login.php');
}

$gebruiker = new Gebruiker();
$gebruikers = $gebruiker->getGebruikers();
$rechten = new Rechten();
$product = new Product();
$producten = $product->getProducten();
$pagina = 'beheerder';

if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $conn = new Gebruiker();
    $conn->deleteGebruiker();
    header('Location: beheerder.php');
}

include("layout/header.php");
?>
<div class="container">
    <div class="page-header">
        <h1>Beheren</h1>
    </div>
    <h3>Gebruikers</h3>

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
                <th><a href="beheerder.php?delete=<?php echo $geb->getIdgebruiker(); ?>"><img class="prullenbak" src="img/prullenbakOpen.jpg" value="<?php echo $geb->getIdgebruiker(); ?>"></a>
                <?php } ?>
                    <?php if ($rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving() == "Beheerder") { ?>
                <th><img class="prullenbak" src="img/prullenbakDicht.jpg" value="<?php echo $geb->getIdgebruiker(); ?>">
                    <?php } ?>
                <th><a class="btn btn-info" role="button" href="formGebruiker.php?id=<?php echo $geb->getIdgebruiker(); ?>"><?php echo $geb->getIdgebruiker(); ?></a></th>
                <th class="tabelText"><?php echo $geb->getVolledigeNaam(); ?></th>
                <th class="tabelText"><?php echo $geb->getLogin(); ?></th>
                <th class="tabelText"><?php echo $rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving(); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <h3>Vooraad</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Product</th>
            <th>Vooraad</th>
        </tr>
        </thead>
        <?php foreach ($producten as $key => $prod) { ?>
        <tbody>
        <tr>
            <th class="tabelText"><a class="btn btn-info" role="button" href="formProduct.php?id=<?php echo $prod->getIdproduct(); ?>"><?php echo $prod->getIdproduct(); ?></a></th>
            <th class="tabelText"><?php echo $prod->getTitel(); ?></th>
            <th class="tabelText"><?php echo $prod->getVoorraad(); ?></th>
        </tr>
        </tbody>
        <?php } ?>
    </table>

</div>
<?php
include("layout/footer.php");
?>
