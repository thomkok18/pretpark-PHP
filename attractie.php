<?php
include_once('lib/config.php');
include_once('lib/Attractie.php');
$id = $_GET['id'];
$attractie = new Attractie();
$attractie = $attractie->getAttractieById($id);
$reacties = $attractie->getReactiesByIdAttractie();
$gebruiker = $attractie->getGebruikerById();

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Attractie</h1>
            <p><a href="formReactie.php?id=<?php echo $attractie->getIdAttractie(); ?>">Reactie plaatsen</a></p>
        </div>

        <div class="row">
            <div class="col-md-4">
                <img class="img-responsive" src="<?php echo $attractie->getUrlFoto(); ?>">
            </div>

            <div class="col-md-8">
                <p><i><?php echo $gebruiker->getVolledigeNaam(); ?></i></p>
                <h3><?php echo $attractie->getTitel(); ?></h3>
                <p><?php echo $attractie->getOmschrijving(); ?></p>
            </div>
        </div>
        <?php foreach ($reacties as $reactie) {
            $gebruiker = $reactie->getGebruikerById();
            ?>
            <div class="row">
                <div class="col-md-offset-3 col-md-2">
                    <img class="img-responsive" src="img/<?php echo $gebruiker->getLogin(); ?>.png" alt="plaatje gebruiker">
                </div>
                <div class="col-md-8">
                    <p><?php echo $reactie->getReactietekst(); ?></p>
                    <p><i>Door: <?php echo $gebruiker->getVolledigeNaam(); ?></i></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
include("layout/footer.php");
?>