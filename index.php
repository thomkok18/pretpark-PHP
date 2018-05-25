<?php
include_once('lib/config.php');
include_once("lib/AttractieLijst.php");
$attractieLijst = new AttractieLijst();
$attractieLijst->selectAttracties();
$pagina = 'attractie';

include("layout/header.php");
?>
    <div class="container">

        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-10">Attractie overzicht</h1>
                <?php if (isset($_SESSION['login']) && $_SESSION['login']['rechten'] == 'Beheerder') { ?>
                    <a id="attractieButton" role="button" class="btn btn-default col-xs-2" href="formAttractie.php">Attractie toevoegen</a>
                <?php } ?>
            </div>
        </div>

        <?php foreach ($attractieLijst->getAttracties() as $key => $attractie) { ?>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo $attractie->getUrlfoto(); ?>" alt="Attractie">
                </div>
                <div class="col-md-8">
                    <h3><?php echo $attractie->getTitel(); ?></h3>
                    <p><?php echo $attractie->getOmschrijving(); ?></p>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-8">
                    <?php echo $attractie->getGebruikerById()->getLogin(); ?>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-8">
                    <a id="reactieButton" role="button" class="btn btn-default col-xs-2" href="attractie.php?id=<?php echo $attractie->getIdattractie(); ?>">Reacties</a>
                </div>
            </div>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>