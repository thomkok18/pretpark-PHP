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

if (isset($_GET['deleteProduct']) && !empty($_GET['deleteProduct'])) {
    $winkelwagen->deleteProduct($_GET['deleteProduct'], $_SESSION['login']['idgebruiker']);
    header('Location: winkelwagen.php?id='.$_SESSION['login']['idgebruiker']);
}

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <form class="form-horizontal" method="post">
            <?php if ($winkelwagen->getProductByIdgebruiker($id) != null) { //TODO: Juiste overzicht geven in het winkelwagentje. ?>
                <?php for ($i = 0; $i < sizeof($winkelwagen->getProductByIdgebruiker($id)); $i++) { ?>
                    <?php
                    $idproduct = $winkelwagen->getProductByIdgebruiker($id)[$i]->getIdproduct();
                    ?>
                    <div class="col-xs-12">
                        <div class="col-xs-3">
                            <img id="productAfbeelding" class="img-responsive" src="<?= $product->getProductUrlfotoById($idproduct)[0]; ?>" alt="Product">
                        </div>
                        <h3 class="tabelWinkel col-xs-3"><?= $product->getProductTitelById($idproduct)[0]; ?></h3>
                        <a id="verwijderen" class="col-xs-2" href="winkelwagen.php?deleteProduct=<?= $idproduct; ?>"><span class="text-danger">Verwijderen</span></a>
                        <select style="padding: 6px 0 6px 0;" id="voorraadSelectbox" class="tabelWinkel col-xs-2" name="aantal" onchange="refresh();"> <?php //TODO: Aantal refreshen als het word aangepast. ?>
                            <?php for ($prod = 0; $prod <= $product->getProductVoorraadById($idproduct)[0]; $prod++) { ?>
                                <option <?php if ($prod == $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0]) { ?> selected <?php } ?> ><?= $prod; ?></option>
                            <?php } ?>
                        </select>
                        <b id="prijs" class="col-xs-2"><?= htmlspecialchars('€ ' . number_format($product->getProductPrijsById($idproduct)[0] * $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0], 2)); ?></b>
                    </div>
                    <?php
                    $aantalProducten = 0;
                    $aantalProducten = $aantalProducten + $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0];
                    $subtotaal = $subtotaal + $product->getProductPrijsById($idproduct)[0] * $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0];
                    $totaal = $subtotaal + $verzendkosten;
                }
                ?>
                <div class="col-xs-12">
                    <div class="row">
                        <b class="col-xs-2 totaal"><?= htmlspecialchars('€ ' . number_format($subtotaal, 2)); ?></b>
                        <b class="col-xs-2 totaal">Subtotaal</b>
                    </div>
                    <div class="row">
                        <p class="col-xs-2 totaal"><?= htmlspecialchars('€ ' . number_format($verzendkosten, 2)); ?></p>
                        <p class="col-xs-2 totaal">Verzendskosten</p>
                    </div>
                    <div class="row">
                        <b class="col-xs-2 totaal"><?= htmlspecialchars('€ ' . number_format($totaal, 2)); ?></b>
                        <b class="col-xs-2 totaal">Totaal</b>
                    </div>
                </div>
                <div class="col-xs-12">
                    <button id="betalen" class="col-xs-2 tabelWinkel btn" type="submit" name="betalen">Betalen</button>
                </div>
                <?php if (isset($_POST['betalen'])) {
                    if ($totaal === $subtotaal + $verzendkosten) {
                        foreach ($geldvoorraad as $key => $geld) {
                            $saldo->updateSaldo(1, $geld->getSaldo(), number_format($totaal, 2), 'verkocht');
                        }
                        for ($i = 0; $i < sizeof($winkelwagen->getProductByIdgebruiker($id)); $i++) {
                            $idproduct = $winkelwagen->getProductByIdgebruiker($id)[$i]->getIdproduct();
                            $product->updateVoorraad($idproduct, $product->getProductVoorraadById($idproduct)[0], $winkelwagen->getAantalById($idproduct, $_SESSION['login']['idgebruiker'])[0], 'verkocht');
                        }
                        //TODO: Winkelwagens die gelinkt zijn met de gebruiker moeten worden verwijderd.
                        $winkelwagen->deleteWinkelwagen($_SESSION['login']['idgebruiker']);
                        header('Location: winkelwagen.php?id='.$_SESSION['login']['idgebruiker']);
                    }
                }
            } else {
                echo htmlspecialchars('Er zijn nog geen producten in het winkelwagentje.');
            }
            ?>
        </form>

    </div>
    <script>
        function refresh(idproduct) {
            var e = document.getElementById("voorraadSelectbox" + idproduct);
            var productAantal = e.options[e.selectedIndex].value;
            window.location.href = "winkelwagen.php?id=" + idproduct + "&productAantal=" + productAantal;
        }
    </script>

<?php
include("layout/footer.php");
?>