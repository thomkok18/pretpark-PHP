<?php
include_once('lib/config.php');
include_once("lib/Product.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder') {
    header('Location: login.php');
    return;
}

$Product = new Product();
$pagina = 'voorraad';
$message = array();

if (isset($_POST['productOpslaan'])) {
    extract($_POST);
    $product = new Product();
    $product->setTitel($_POST['titel']);
    $product->setProductomschrijving($_POST['productomschrijving']);
    $product->setVoorraad(0);
    $product->setPrijs(number_format($_POST['prijs'],2));
    $product->setUrlfoto('img/product.png');

    if ($product->insertProduct()) {
        header('Location: beheerder.php');
    } else {
        $message[0] = "Product is niet toegevoegd.";
    }
}

include("layout/header.php");
?>

<?php if (isset($_POST['productOpslaan'])) { ?>
    <div class="alert alert-danger" role="alert">
        <strong><?= htmlspecialchars($message[0]); ?></strong>
    </div>
<?php } ?>

    <div>
        <div class="page-header">
            <h1>Product Aanmaken</h1>
            <p>* zijn verplichte velden.</p>
        </div>

        <h3>Product gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="titel" class="col-lg-2 control-label">* Titel</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" id="titel" name="titel" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="productomschrijving" class="col-lg-2 control-label">* Productomschrijving</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" id="productomschrijving" name="productomschrijving" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="prijs" class="col-lg-2 control-label">* Prijs</label>
                <div class="col-lg-10">
                    <input required type="text" class="form-control" id="prijs" name="prijs" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="productFoto" class="col-lg-2 control-label">Product foto</label>
                <div id="uploadButton" class="col-lg-10">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <button type="submit" class="btn btn-default" name="productOpslaan">Opslaan</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>