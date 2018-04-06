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
            <?php if (isset($_SESSION['login'])) { ?>
                <p><a class="btn btn-default" role="button" href="formReactie.php?id=<?php echo $attractie->getIdAttractie(); ?>">Reactie plaatsen</a></p>
            <?php } ?>
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
        <hr>
        <?php foreach ($reacties as $reactie) {
            $gebruiker = $reactie->getGebruikerById();
            ?>
            <div class="row">
                <div class="col-md-1">
                    <img style="width:42px;height:42px;" src="img/<?php echo $gebruiker->getLogin(); ?>.png"
                         alt="plaatje gebruiker">
                </div>
                <div class="col-md-11">
                    <p><?php echo $reactie->getReactietekst(); ?></p>
                    <p><i>Door: <?php echo $gebruiker->getVolledigeNaam(); ?></i></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
include("layout/footer.php");
?>