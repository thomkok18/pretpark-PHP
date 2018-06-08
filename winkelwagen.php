<?php
include_once('lib/config.php');
include_once('lib/Product.php');
include_once('lib/Winkelwagen.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkelwagen';
$winkelwagen = new Winkelwagen();

$subtotaal = 0;
$verzendkosten = 0.95;
$totaal = 0;

if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    foreach ($_SESSION['winkelwagen'] as $key => $wagen) {
        if ($wagen['idproduct'] == $_GET['delete']) {
            unset($_SESSION['winkelwagen'][$key]);
            $_SESSION['winkelwagen'] = array_values($_SESSION['winkelwagen']);
            header('Location: winkelwagen.php');
        }
    }
}

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <form class="form-horizontal" method="post">
            <?php if (isset($_SESSION['winkelwagen']) && sizeof($_SESSION['winkelwagen']) > 0) { ?>
                <?php for ($i = 0; $i < sizeof($_SESSION['winkelwagen']); $i++) {
                    $id = array_column($_SESSION['winkelwagen'], 'idproduct');
                    if (in_array($_SESSION['winkelwagen'][$i]['idproduct'], $id)) { ?>
                        <div class="col-xs-12">
                            <div class="col-xs-3">
                                <img id="productAfbeelding" class="img-responsive" src="<?php echo $_SESSION['winkelwagen'][$i]['urlfoto']; ?>" alt="Product">
                            </div>
                            <h3 class="tabelWinkel col-xs-3"><?php echo $_SESSION['winkelwagen'][$i]['titel']; ?></h3>
                            <a id="verwijderen" class="col-xs-2" href="winkelwagen.php?delete=<?php echo $_SESSION['winkelwagen'][$i]['idproduct']; ?>"><span class="text-danger">Verwijderen</span></a>
                            <select id="voorraadSelectbox" class="tabelWinkel col-xs-2" name="aantal">
                                <?php for ($voorraad = 0; $voorraad <= $_SESSION['winkelwagen'][$i]['voorraad']; $voorraad++) { ?>
                                    <option <?php if ($voorraad == $_SESSION['winkelwagen'][$i]['aantal']) { ?> selected <?php } ?> ><?php echo $voorraad; ?></option>
                                <?php } ?>
                            </select>
                            <b id="prijs" class="col-xs-2"><?php echo '€ ' . number_format($_SESSION['winkelwagen'][$i]['prijs'] * $_SESSION['winkelwagen'][$i]['aantal'], 2); ?></b>
                        </div>
                        <?php
                        $aantalProducten = 0;
                        $aantalProducten = $aantalProducten + $_SESSION['winkelwagen'][$i]['aantal'];
                        $subtotaal = $subtotaal + $_SESSION['winkelwagen'][$i]['prijs'] * $_SESSION['winkelwagen'][$i]['aantal'];
                        $totaal = $subtotaal + $verzendkosten;
                        ?>
                    <?php } ?>
                <?php } ?>
                <div class="col-xs-12">
                    <div class="row">
                        <b class="col-xs-2 totaal"><?php echo '€ ' . number_format($subtotaal, 2); ?></b>
                        <b class="col-xs-2 totaal">Subtotaal</b>
                    </div>
                    <div class="row">
                        <p class="col-xs-2 totaal"><?php echo '€ ' . number_format($verzendkosten, 2); ?></p>
                        <p class="col-xs-2 totaal">Verzendskosten</p>
                    </div>
                    <div class="row">
                        <b class="col-xs-2 totaal"><?php echo '€ ' . number_format($totaal, 2); ?></b>
                        <b class="col-xs-2 totaal">Totaal</b>
                    </div>
                </div>
                <div class="col-xs-12">
                    <button id="betalen" class="col-xs-2 tabelWinkel btn" type="submit" name="betalen">Betalen</button>
                </div>
            <?php } else {
                echo 'Er zijn nog geen producten in het winkelwagentje.';
            } ?>
            <?php if (isset($_POST['betalen'])) {
                unset($_SESSION['winkelwagen']);
                $_SESSION['winkelwagen'] = array_values($_SESSION['winkelwagen']);
                header('Location: winkelwagen.php');
            }
            ?>
        </form>

    </div>

<?php
include("layout/footer.php");
?>