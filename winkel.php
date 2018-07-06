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
    extract($_POST);
    $id = $_GET['id'];
    $winkelwagen = new Winkelwagen();
    $product = new Product();
    $aantal = preg_replace('/\s+/', '', $_POST['aantal']);
    $voorraad = $product->getProductVoorraadById($id)[0];

    if (intval(intval($aantal) > intval($voorraad))) {
        $error_message[] = 'Er zijn niet genoeg producten op voorraad.';
    }

    if (!isset($error_message)) {
        if (intval($aantal) <= intval($voorraad) && intval($aantal) > 0) {
            $winkelwagen->setIdproduct($id);
            $winkelwagen->setIdgebruiker($_SESSION['login']['idgebruiker']);
            $winkelwagen->setAantal($_POST['aantal']);
            if ($winkelwagen->getIdproductByIdproduct($id, $_SESSION['login']['idgebruiker'])[0] == null) {
                $winkelwagen->insertWinkelwagen();
                $messages[] = 'Product is toegevoegd aan het winkelwagentje.';
            } else {
                $winkelwagen->updateIdproduct($id, $_SESSION['login']['idgebruiker'], $_POST['aantal']);
                $messages[] = 'Product is aangepast in het winkelwagentje.';
            }
        }
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

    <div id="winkelContainer" class="container-fluid">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <?php foreach ($producten as $key => $prod) { ?>
            <form class="form-horizontal" method="post" action="winkel.php?action=add&id=<?= htmlspecialchars($prod->getIdproduct()); ?>">
                <div id="winkelDiv" class="col-lg-12">
                    <div class="col-lg-5">
                        <div id="productAfbeeldingDiv" class="col-xs-12 col-sm-6">
                            <img id="productAfbeelding" src="<?= htmlspecialchars($prod->getUrlFoto()); ?>" alt="Product">
                        </div>
                        <div class="col-xs-12 col-sm-6 tabelWinkel">
                            <h3 id="productTitel"><?= htmlspecialchars($prod->getTitel()); ?></h3>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="col-xs-12 col-sm-2 col-lg-12 tabelWinkel">
                            <b>€ <?= htmlspecialchars($prod->getPrijs()); ?></b>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="col-xs-12 col-sm-6">
                            <?php if ($prod->getVoorraad() != 0) { ?>
                            <select id="voorraadSelectbox" class="tabelWinkel col-xs-12" name="aantal">
                                <?php for ($i = 0; $i <= $prod->getVoorraad(); $i++) { ?>
                                    <option><?= htmlspecialchars($i); ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <button id="winkelwagenButton" class="tabelWinkel btn col-xs-12" type="submit" name="winkelwagen">Winkelwagen</button>
                        </div>
                        <?php } else { ?>
                            <div class="col-xs-12">
                                <b id="uitverkocht" class="col-xs-12 tabelWinkel">Uitverkocht</b>
                            </div>
                        <?php } ?>
                    </div>
                </div>

            </form>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>