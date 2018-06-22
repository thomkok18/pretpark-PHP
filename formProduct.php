<?php
include_once('lib/config.php');
include_once("lib/Product.php");
include_once("lib/Saldo.php");

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder' && $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
}

$id = $_GET['id'];
$Product = new Product();
$products = $Product->getProducten();
$product = $Product->getProductById($id);
$saldo = new Saldo();
$geldvoorraad = $saldo->getSaldoVoorraad();
$totaal = $_GET['productAantal'] * 2;
$pagina = 'product';

if (isset($_POST['productOpslaan'])) {
    extract($_POST);
    $product->updateProductgegevens($id, $titel, $productomschrijving, $prijs);
    header('Location: formProduct.php?id=' . $id. '&productAantal=0');
} else if (isset($_POST['productFotoOpslaan'])) {
    extract($_POST);
    $product->updateProductfoto($id, $urlfoto);
} else if (isset($_POST['productBijvullen'])) {
    extract($_POST);
    foreach ($geldvoorraad as $key => $geld) {
        $saldo->updateSaldo(1, $geld->getSaldo(), number_format($totaal, 2), 'gekocht');
    }
    $product->updateVoorraad($id, $product->getVoorraad(), $_GET['productAantal'], 'gekocht');
    header('Location: formProduct.php?id=' . $id. '&productAantal=0');
}
include("layout/header.php");
?>

    <div>
        <div class="page-header">
            <h1>Product Aanpassen</h1>
        </div>

        <h3>Product gegevens</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="id" class="col-sm-2 control-label">Id</label>
                <div class="col-sm-10">
                    <input required disabled type="text" class="form-control" id="id" name="idproduct" value="<?php echo htmlspecialchars($id); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="titel" class="col-sm-2 control-label">Titel</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="titel" name="titel" value="<?php echo htmlspecialchars($product->getTitel()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="productomschrijving" class="col-sm-2 control-label">Productomschrijving</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="productomschrijving" name="productomschrijving" value="<?php echo htmlspecialchars($product->getProductomschrijving()); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="prijs" class="col-sm-2 control-label">Prijs</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="prijs" name="prijs" value="<?php echo htmlspecialchars($product->getPrijs()); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="productOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Product foto</h3>
        <form action="uploadProduct.php?id=<?php foreach ($products as $key => $prod) {
            if ($_SESSION['login']['idgebruiker'] == $prod->getIdgebruiker()) {
                echo $prod->getIdproduct();
            }
        } ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productFoto" class="col-sm-2 control-label">Product foto</label>
                <div id="uploadButton" class="col-sm-10">
                    <input type="file" name="file" id="fileToUpload">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="productFotoOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Product bijvullen</h3>
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="voorraad" class="col-sm-2 control-label">Voorraad:  <?php ?></label>
            </div>
            <div class="form-group">
                <label for="prijs" class="col-sm-2 control-label">Bijvullen</label>
                <div class="col-sm-10">
                    <select style="padding: 6px 0 6px 0;" id="bijvullenSelectbox<?php echo htmlspecialchars($id); ?>" name="bijvullen" onchange="refresh(<?php echo htmlspecialchars($id); ?>)">
                        <?php for ($voorraad = 0; $voorraad <= 1000; $voorraad++) { ?>
                            <option <?php if ($voorraad == $_GET['productAantal']) { ?> selected <?php } ?> ><?php echo htmlspecialchars($voorraad); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label id="prijs<?php echo $id; ?>" for="prijs" class="col-sm-2 control-label">Prijs: € <?php echo number_format($totaal,2); ?></label>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="productBijvullen">Bijvullen</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function refresh(idproduct) {
            var e = document.getElementById("bijvullenSelectbox" + idproduct);
            var productAantal = e.value;
            window.location.href = "formProduct.php?id=" + idproduct + "&productAantal=" + productAantal;
        }
    </script>

<?php include("layout/footer.php"); ?>