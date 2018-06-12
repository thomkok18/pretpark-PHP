<?php
include_once('lib/config.php');
include_once('lib/Product.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
}

$product = new Product();
$producten = $product->getProducten();
$pagina = 'winkel';
$error = false;

if (isset($_POST['winkelwagen'])) {
    if ($_POST['aantal'] > 0) {

        if (!isset($_SESSION['winkelwagen']) || sizeof($_SESSION['winkelwagen']) == 0) {
            $_SESSION['winkelwagen'] = array(
                array(
                    "idproduct" => $_GET['id'],
                    "urlfoto" => $_POST['urlfoto'],
                    "titel" => $_POST['titel'],
                    "prijs" => $_POST['prijs'],
                    "aantal" => $_POST['aantal'],
                    "voorraad" => $_POST['voorraad']
                )
            );
        } else {
            for ($i = 0; $i < sizeof($_SESSION['winkelwagen']); $i++) {
                $id = array_column($_SESSION['winkelwagen'], 'idproduct');
                if (!in_array($_GET['id'], $id)) {
                    $productArray = array(
                        "idproduct" => $_GET['id'],
                        "urlfoto" => $_POST['urlfoto'],
                        "titel" => $_POST['titel'],
                        "prijs" => $_POST['prijs'],
                        "aantal" => $_POST['aantal'],
                        "voorraad" => $_POST['voorraad']
                    );
                    array_push($_SESSION['winkelwagen'], $productArray);
                } else if ($_GET['id'] == $_SESSION['winkelwagen'][$i]['idproduct']) {
                    $_SESSION['winkelwagen'][$i]['aantal'] = $_POST['aantal'];
                }
            }
        }
    } else {
        $error = true;
        $message[0] = 'Product is niet toegevoegd.';
    }
}

if (isset($_POST['winkelwagen']) && !$error) {
    $message[0] = 'Product is toegevoegd.';
}

include("layout/header.php");
?>
<?php if (isset($message)) {
    if ($error) { ?>
        <div class="alert alert-danger" role="alert">
    <?php } else { ?>
        <div class="alert alert-success" role="alert">
    <?php } ?>
    <strong><?php echo htmlspecialchars($message[0]); ?></strong>
    </div>
<?php } ?>
    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <?php foreach ($producten as $key => $prod) { ?>
            <form class="form-horizontal" method="post"
                  action="winkel.php?action=add&id=<?php echo htmlspecialchars($prod->getIdproduct()); ?>">
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <img id="productAfbeelding" class="img-responsive" src="<?php echo htmlspecialchars($prod->getUrlFoto()); ?>"
                             alt="Product">
                    </div>
                    <h3 class="tabelWinkel col-xs-3"><?php echo htmlspecialchars($prod->getTitel()); ?></h3>
                    <b id="prijs" class="col-xs-2">€ <?php echo htmlspecialchars($prod->getPrijs()); ?></b>
                    <select id="voorraadSelectbox" class="tabelWinkel col-xs-2" name="aantal">
                        <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                            <option><?php echo htmlspecialchars($i); ?></option>
                        <?php } ?>
                    </select>
                    <input hidden name="urlfoto" value="<?php echo htmlspecialchars($prod->getUrlfoto()); ?>">
                    <input hidden name="titel" value="<?php echo htmlspecialchars($prod->getTitel()); ?>">
                    <input hidden name="prijs" value="<?php echo htmlspecialchars($prod->getPrijs()); ?>">
                    <input hidden name="voorraad" value="<?php echo htmlspecialchars($prod->getVoorraad()); ?>">
                    <button class="tabelWinkel btn col-xs-2" type="submit" name="winkelwagen">Winkelwagen</button>
                </div>
            </form>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>