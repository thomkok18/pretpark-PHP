<?php
include_once('lib/config.php');
include_once('lib/Product.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkel';

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <div>
            <?php foreach ($producten as $key => $prod) { ?>
                <div class="col-xs-12">
                    <div class="col-xs-4">
                        <img id="productAfbeelding" class="img-responsive" src="<?php echo $prod->getUrlFoto(); ?>" alt="Product">
                    </div>
                    <h3 class="tabelWinkel col-xs-4"><?php echo $prod->getTitel(); ?></h3>
                    <select id="voorraadSelectbox" class="tabelWinkel col-xs-2">
                        <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                            <option><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <button class="tabelWinkel btn col-xs-2" type="button">Winkelwagen</button>
                </div>
            <?php } ?>
        </div>

    </div>

<?php
include("layout/footer.php");
?>