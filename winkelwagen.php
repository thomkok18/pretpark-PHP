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

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <form class="form-horizontal" method="post">
            <?php if (isset($_SESSION['winkelwagen'])) { ?>
                <?php for ($i = 0; $i < sizeof($_SESSION['winkelwagen']); $i++) { ?>
                    <div class="col-xs-12">
                        <div class="col-xs-4">
                            <img id="productAfbeelding" class="img-responsive"
                                 src="<?php echo $_SESSION['winkelwagen'][$i]['urlfoto']; ?>" alt="Product">
                        </div>
                        <h3 class="tabelWinkel col-xs-4"><?php echo $_SESSION['winkelwagen'][$i]['titel']; ?></h3>
                        <select id="voorraadSelectbox" class="tabelWinkel col-xs-2" name="aantal">
                            <?php for ($voorraad = 0; $voorraad <= $_SESSION['winkelwagen'][$i]['voorraad']; $voorraad++) { ?>
                                <option <?php if ($voorraad == $_SESSION['winkelwagen'][$i]['aantal']) {?> selected <?php } ?> ><?php echo $voorraad; ?></option>
                            <?php } ?>
                        </select>
                        <b id="prijs"
                           class="col-xs-2"><?php echo '€ ' . number_format($_SESSION['winkelwagen'][$i]['prijs'] * $_SESSION['winkelwagen'][$i]['aantal'], 2); ?></b>
                    </div>
                <?php } ?>
                <div class="col-xs-12">
                    <button id="betalen" class="col-xs-2 tabelWinkel btn" type="submit" name="betalen">Betalen</button>
                </div>
            <?php } else {
                echo 'Er zijn nog geen producten in het winkelwagentje.';
            } ?>
        </form>

    </div>

<?php
include("layout/footer.php");
?>