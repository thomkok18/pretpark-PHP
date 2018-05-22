<?php
session_start();

if (!isset($_SESSION['login']) && $_SESSION['login']['rechten'] === 'Gebruiker') {
    header('Location: login.php');
}

include_once('lib/config.php');
include_once('lib/Product.php');

$product = new Product();
$producten = $product->getProducten();
$pagina = 'shopping';

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <div>
            <?php foreach ($producten as $key => $prod) { ?>
                <img class="col-xs-1 img-responsive" src="<?php echo $prod->getUrlFoto(); ?>" alt="Product" height="50" width="50">
                <p style="margin-top: 25px; margin-bottom: 25px;" class="col-xs-10"><?php echo $prod->getTitel(); ?></p>
                <select style="padding-top: 6px; padding-bottom: 6px; margin-top: 20px; margin-bottom: 20px;" class="col-xs-1">
                    <?php for ($i = 0; $i <= 100; $i++) { ?>
                        <option><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            <?php } ?>
        </div>
        <br>

    </div>

<?php
include("layout/footer.php");
?>