<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login']['rechten'] !== 'Beheerder' && $_SESSION['login']['idgebruiker'] !== $id) {
    header('Location: login.php');
}

include_once('lib/config.php');
include_once("lib/Product.php");

$id = $_GET['id'];
$Product = new Product();
$products = $Product->getProducten();
$product = $Product->getProductById($id);
$pagina = 'product';

//if (isset($_POST['persoonsgegevensOpslaan'])) {
//    extract($_POST);
//    $gebruiker->updatePersoonsgegevens($id, $login, $naam, $tussenvoegsels, $achternaam);
//    header('Location: formGebruiker.php?id='. $id);
//} else if (isset($_POST['wachtwoordOpslaan'])) {
//    extract($_POST);
//    $gebruiker->updateWachtwoord($id, password_hash($wachtwoord, PASSWORD_DEFAULT));
//    header('Location: formGebruiker.php?id='. $id);
//} else if (isset($_POST['rechtenOpslaan'])) {
//    extract($_POST);
//    $gebruiker->updateRechten($id, $idrechten);
//    header('Location: formGebruiker.php?id='. $id);
//}
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
                    <input required disabled type="text" class="form-control" id="id" name="idproduct" value="<?php echo $id; ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="titel" class="col-sm-2 control-label">Titel</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="titel" name="titel" value="<?php echo $product->getTitel(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="productomschrijving" class="col-sm-2 control-label">Productomschrijving</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="productomschrijving" name="productomschrijving" value="<?php echo $product->getProductomschrijving(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="aantal" class="col-sm-2 control-label">Voorraad</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="aantal" name="aantal" value="<?php echo $product->getAantal(); ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="prijs" class="col-sm-2 control-label">Prijs</label>
                <div class="col-sm-10">
                    <input required type="text" class="form-control" id="prijs" name="prijs" value="<?php echo $product->getPrijs(); ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="productOpslaan">Opslaan</button>
                </div>
            </div>
        </form>

        <h3>Product foto</h3>
        <form action="uploadProduct.php?id=<?php foreach ($products as $key => $prod) { if ($_SESSION['login']['idgebruiker'] == $prod->getIdgebruiker()) { echo $prod->getIdproduct(); } } ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="productFoto" class="col-sm-2 control-label">Product foto</label>
                <div id="uploadButton" class="col-sm-10">
                    <input type="file" name="fileToUpload" id="fileToUpload">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-default" name="productFotoOpslaan">Opslaan</button>
                </div>
            </div>
        </form>
    </div>

<?php include("layout/footer.php"); ?>