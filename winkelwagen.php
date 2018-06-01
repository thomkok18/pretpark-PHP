<?php
include_once('lib/config.php');
include_once('lib/Product.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkelwagen';

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <div>
            <?php foreach ($producten as $key => $prod) { ?>
                <div class="col-xs-3">
                    <img id="winkelwagenProduct" class="img-responsive" src="<?php echo $prod->getUrlFoto(); ?>" alt="Product">
                </div>
                <h3 id="productnaam" class="col-xs-5"><?php echo $prod->getTitel(); ?></h3>
                <select id="koopSelectbox" class="col-xs-2">
                    <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                        <option><?php echo $i; ?></option>
                    <?php } ?>
                </select>
                <b id="prijs" class="col-xs-2">€<?php echo $prod->getPrijs() * $i; ?></b>
            <?php } ?>
        </div>
        <br>

    </div>

<?php
include("layout/footer.php");
?>