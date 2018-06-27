<?php
include_once('lib/config.php');
include_once('lib/Product.php');
include_once('lib/Winkelwagen.php');
include_once('lib/Gebruiker.php');

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    return;
}

$product = new Product();
$producten = $product->getProducten();
$winkelwagen = new Winkelwagen();
$gebruiker = new Gebruiker();
$pagina = 'winkel';

if (isset($_POST['winkelwagen'])) {
    foreach ($winkelwagen as $wkey => $winkel) {
        foreach ($producten as $pkey => $prod) {
            extract($_POST);
            if (intval($winkelwagen->getAantalById($_GET['id'])[0]) <= intval($product->getProductVoorraadById($_GET['id'])[0])) {
                $winkelwagen->setIdproduct($_GET['id']);
                $winkelwagen->setIdgebruiker($_SESSION['login']['idgebruiker']);
                $winkelwagen->setAantal($_POST['aantal']);
                if ($winkelwagen->getIdproductByIdgebruiker($_GET['id'])[0] != $_GET['id']) {
                    $winkelwagen->insertWinkelwagen();
                } else {
                    $winkelwagen->updateIdproduct($_GET['id'], $_SESSION['login']['idgebruiker'], $_POST['aantal']);
                }
            }
        }
    }
    if (intval($winkelwagen->getAantalById($_GET['id'])[0]) > intval($product->getProductVoorraadById($_GET['id'])[0])) {
        $error_message[] = 'Er zijn niet genoeg producten op voorraad.';
    }

    if ($winkelwagen->getIdproductByIdgebruiker($_GET['id'])[0] != $_GET['id']) {
        $messages[] = 'Product is toegevoegd aan het winkelwagentje.';
    } else {
        $messages[] = 'Product is aangepast in het winkelwagentje.';
    }
}

include("layout/header.php");
?>
<?php if (isset($error_message) && isset($_POST['winkelwagen'])) {
    foreach ($error_message as $key => $error) { ?>
        <div class="alert alert-danger" role="alert">
            <strong><?= htmlspecialchars($error); ?></strong>
        </div>
    <?php }
} ?>
<?php if (isset($messages) && isset($_POST['winkelwagen'])) { ?>
    <?php foreach ($messages as $key => $message) { ?>
        <div class="alert alert-success" role="alert">
            <strong><?= htmlspecialchars($message); ?></strong>
        </div>
    <?php }
} ?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <?php foreach ($producten as $key => $prod) { ?>
            <form class="form-horizontal" method="post" action="winkel.php?action=add&id=<?= htmlspecialchars($prod->getIdproduct()); ?>">
                <div class="col-xs-12">
                    <div class="col-xs-3">
                        <img id="productAfbeelding" class="img-responsive" src="<?= htmlspecialchars($prod->getUrlFoto()); ?>"
                             alt="Product">
                    </div>
                    <h3 class="tabelWinkel col-xs-3"><?= htmlspecialchars($prod->getTitel()); ?></h3>
                    <b id="prijs" class="col-xs-2">€ <?= htmlspecialchars($prod->getPrijs()); ?></b>
                    <select id="voorraadSelectbox" class="tabelWinkel col-xs-2" name="aantal">
                        <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                            <option><?= htmlspecialchars($i); ?></option>
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