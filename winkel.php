<?php
include_once('lib/config.php');
include_once('lib/Product.php');

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
            <div class="col-md-4">
                <img class="img-responsive" src="<?php echo $prod->getUrlFoto(); ?>" alt="Product" height="100" width="100">
            </div>
            <h3 style="margin-top:42px;" class="col-xs-4"><?php echo $prod->getTitel(); ?></h3>
            <select style="margin-top:42px; padding-top: 6px; padding-bottom: 6px;" class="col-xs-2">
                <?php for ($i = 0; $i <= $prod->getAantal(); $i++) { ?>
                    <option><?php echo $i; ?></option>
                <?php } ?>
            </select>
            <button style="margin-top:42px;" class="btn col-xs-2" type="button">Winkelwagen</button>
            <?php } ?>
        </div>

    </div>

<?php
include("layout/footer.php");
?>