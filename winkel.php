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

//if (isset($_POST['winkelwagen'])) {
//    if ($_POST['aantal'] > 0) {
//
//        if (!isset($_SESSION['winkelwagen']) || sizeof($_SESSION['winkelwagen']) == 0) {
//            $_SESSION['winkelwagen'] = array(
//                array(
//                    "idproduct" => $_GET['id'],
//                    "urlfoto" => $_POST['urlfoto'],
//                    "titel" => $_POST['titel'],
//                    "prijs" => $_POST['prijs'],
//                    "aantal" => $_POST['aantal'],
//                    "voorraad" => $_POST['voorraad']
//                )
//            );
//        } else {
//            for ($i = 0; $i < sizeof($_SESSION['winkelwagen']); $i++) {
//                $id = array_column($_SESSION['winkelwagen'], 'idproduct');
//                if (!in_array($_GET['id'], $id)) {
//                    $productArray = array(
//                        "idproduct" => $_GET['id'],
//                        "urlfoto" => $_POST['urlfoto'],
//                        "titel" => $_POST['titel'],
//                        "prijs" => $_POST['prijs'],
//                        "aantal" => $_POST['aantal'],
//                        "voorraad" => $_POST['voorraad']
//                    );
//                    array_push($_SESSION['winkelwagen'], $productArray);
//                } else if ($_GET['id'] == $_SESSION['winkelwagen'][$i]['idproduct']) {
//                    $_SESSION['winkelwagen'][$i]['aantal'] = $_POST['aantal'];
//                }
//            }
//        }
//    } else {
//        $error = true;
//        $message[0] = 'Product is niet toegevoegd.';
//    }
//}

if (isset($_POST['winkelwagen'])) {
    $winkelwagen->setIdproduct($_GET['id']);
    $winkelwagen->setIdgebruiker($_SESSION['login']['idgebruiker']);
    $winkelwagen->setAantal($_POST['aantal']);
    if ($winkelwagen->getIdproductByIdgebruiker($_GET['id'])[0] != $_GET['id']) {
        $winkelwagen->insertWinkelwagen();
    } else {
        $winkelwagen->updateIdproduct($_GET['id'], $_SESSION['login']['idgebruiker'], $_POST['aantal']);
    }
    foreach ($winkelwagen as $wkey => $winkel) {
        foreach ($producten as $pkey => $prod) {
            if ($winkel->getAantalById() <= $prod->getVoorraad()) {
                $messages[] = 'Product is toegevoegd aan het winkelwagentje.';
            } else {
                $error_message[] = 'Er zijn niet genoeg producten op voorraad.';
            }
        }
    }
}

include("layout/header.php");
?>
<?php if (isset($error_message)) {
    foreach ($error_message as $key => $error) { ?>
        <div class="alert alert-danger" role="alert">
            <strong><?= htmlspecialchars($error); ?></strong>
        </div>
    <?php }
} ?>
<?php if (isset($messages)) { ?>
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