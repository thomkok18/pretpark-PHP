<?php
include_once('lib/config.php');
include_once('lib/Product.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkel';

if (isset($_POST['winkelwagen'])) {
    $message[0] = 'Product niet toegevoegd.';
}

include("layout/header.php");
?>
<?php if (isset($_POST['winkelwagen'])) { ?>
    <div class="alert alert-danger" role="alert">
        <strong><?php echo $message[0]; ?></strong>
    </div>
<?php } ?>
    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>


            <?php foreach ($producten as $key => $prod) { ?>
        <form class="form-horizontal" method="post" action="winkel.php?action=add&id=<?php echo $prod->getIdproduct(); ?>">
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <img id="productAfbeelding" class="img-responsive" src="<?php echo $prod->getUrlFoto(); ?>" alt="Product">
                    </div>
                    <h3 class="tabelWinkel col-xs-3"><?php echo $prod->getTitel(); ?></h3>
                    <b id="prijs" class="col-xs-2">€<?php echo $prod->getPrijs(); ?></b>
                    <select id="voorraadSelectbox" class="tabelWinkel col-xs-2">
                        <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                            <option><?php echo $i; ?></option>
                        <?php } ?>
                    </select>
                    <button class="tabelWinkel btn col-xs-2" type="submit" name="winkelwagen">Winkelwagen</button>
                </div>
        </form>
            <?php } ?>


    </div>

<?php
include("layout/footer.php");
?>