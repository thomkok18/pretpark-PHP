<?php
include_once('lib/config.php');
include_once('lib/Product.php');
include_once('lib/Saldo.php');
include_once('lib/Winkelwagen.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    return;
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkelwagen';
$winkelwagen = new Winkelwagen();
$winkelwagens = $winkelwagen->getWinkelwagens();
$saldo = new Saldo();
$geldvoorraad = $saldo->getSaldoVoorraad();
$id = $_GET['id'];

$subtotaal = 0;
$verzendkosten = 0.95;
$totaal = 0.00;
$aantalProducten = 0;

for ($i = 0; $i < sizeof($winkelwagen->getProductByIdgebruiker($id)); $i++) {
    $idproduct = $winkelwagen->getProductByIdgebruiker($id)[$i]->getIdproduct();
    $aantalProducten = $aantalProducten + $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0];
    $subtotaal = $subtotaal + $product->getProductPrijsById($idproduct)[0] * $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0];
    $totaal = $subtotaal + $verzendkosten;
}

if (isset($_POST['betalen'])) {
    if ($totaal === $subtotaal + $verzendkosten) {
        foreach ($geldvoorraad as $key => $geld) {
            $saldo->updateSaldo(1, $geld->getSaldo(), number_format($totaal, 2), 'verkocht');
        }
        for ($i = 0; $i < sizeof($winkelwagen->getProductByIdgebruiker($id)); $i++) {
            $idproduct = $winkelwagen->getProductByIdgebruiker($id)[$i]->getIdproduct();
            $product->updateVoorraad($idproduct, $product->getProductVoorraadById($idproduct)[0], $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0], 'verkocht');
        }
        $winkelwagen->deleteWinkelwagen($_SESSION['login']['idgebruiker']);
        header('Location:winkelwagen.php?id=' . $_SESSION['login']['idgebruiker']);
    }
}

if (isset($_GET['deleteProduct']) && !empty($_GET['deleteProduct'])) {
    $winkelwagen->deleteProduct($_GET['deleteProduct'], $_SESSION['login']['idgebruiker']);
    header('Location: winkelwagen.php?id=' . $_SESSION['login']['idgebruiker']);
}

if (isset($_GET['idproduct']) && !empty($_GET['idproduct']) && isset($_GET['productAantal']) && $_GET['productAantal'] != null) {
    $winkelwagen->updateAantal($_GET['idproduct'], $_SESSION['login']['idgebruiker'], $_GET['productAantal']);
    if ($_GET['productAantal'] == 0) {
        $winkelwagen->deleteProduct($_GET['idproduct'], $_SESSION['login']['idgebruiker']);
    }
    header('Location: winkelwagen.php?id=' . $_SESSION['login']['idgebruiker']);
}

include("layout/header.php");
?>

    <div class="container-fluid">
    <div class="page-header">
        <h1>Winkel</h1>
    </div>

    <form class="form-horizontal" method="post">
    <div>
        <?php if ($winkelwagen->getProductByIdgebruiker($id) != null) {
            for ($i = 0; $i < sizeof($winkelwagen->getProductByIdgebruiker($id)); $i++) {
                $idproduct = $winkelwagen->getProductByIdgebruiker($id)[$i]->getIdproduct();
                ?>
                <div style="margin-bottom: 20px;" class="col-lg-12">
                    <div class="col-lg-5">
                        <div style="text-align: center;" class="col-xs-12 col-sm-6">
                            <img id="productAfbeelding" src="<?= $product->getProductUrlfotoById($idproduct)[0]; ?>" alt="Product">
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <h3 class="tabelWinkel"><?= $product->getProductTitelById($idproduct)[0]; ?></h3>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="col-xs-12 col-sm-2 col-md-1" style="text-align: center; margin-top: 48px;">
                            <a class="text-danger" href="winkelwagen.php?deleteProduct=<?= $idproduct; ?>">Verwijderen</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="col-xs-12 col-sm-6">
                            <select id="voorraadSelectbox<?= $idproduct; ?>" class="tabelWinkel voorraad col-xs-12" name="aantal"
                                    onchange="refresh(<?= $_SESSION['login']['idgebruiker']; ?>, <?= $idproduct; ?>);">
                                <?php for ($prod = 0; $prod <= $product->getProductVoorraadById($idproduct)[0]; $prod++) { ?>
                                    <option <?php if ($prod == $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0]) { ?> selected <?php } ?> ><?= $prod; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div style="margin-top: 48px; margin-bottom: 20px;" class="col-xs-12 col-sm-6">
                            <b id="prijs"><?= htmlspecialchars('€ ' . number_format($product->getProductPrijsById($idproduct)[0] * $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0], 2)); ?></b>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-lg-12">
                <div style="padding:0;" class="col-xs-12">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <b class="col-xs-12 col-sm-6">Subtotaal</b>
                        <b class="col-xs-12 col-sm-6"><?= htmlspecialchars('€ ' . number_format($subtotaal, 2)); ?></b>
                    </div>
                </div>
                <div style="padding:0;" class="col-xs-12">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <p style="margin:0;" class="col-xs-12 col-sm-6">Verzendskosten</p>
                        <p style="margin:0;" class="col-xs-12 col-sm-6"><?= htmlspecialchars('€ ' . number_format($verzendkosten, 2)); ?></p>
                    </div>
                </div>
                <div style="padding:0;" class="col-xs-12">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <b class="col-xs-12 col-sm-6">Totaal</b>
                        <b class="col-xs-12 col-sm-6"><?= htmlspecialchars('€ ' . number_format($totaal, 2)); ?></b>
                    </div>
                </div>
                <div style="padding:0;" class="col-xs-12">
                    <div class="col-lg-7"></div>
                    <div class="col-lg-5">
                        <button id="betalen" class="col-xs-12 btn" type="submit" name="betalen">Betalen</button>
                    </div>
                </div>
            </div>

            <?php
        } else {
            echo htmlspecialchars('Er zijn nog geen producten in het winkelwagentje.');
        }
        ?>

    </div>
    <script>
        function refresh(idgebruiker, idproduct) {
            var e = document.getElementById("voorraadSelectbox" + idproduct);
            var productAantal = e.options[e.selectedIndex].value;
            window.location.href = "winkelwagen.php?id=" + idgebruiker + "&idproduct=" + idproduct + "&productAantal=" + productAantal;
        }
    </script>

<?php
include("layout/footer.php");
?>