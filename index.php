<?php
include_once('lib/config.php');
include_once("lib/AttractieLijst.php");
$attractieLijst = new AttractieLijst();
$attractieLijst->selectAttracties();

include("layout/header.php");
?>

    <div class="container">

        <div class="page-header">
            <h1>Attractie overzicht</h1>
        </div>

        <?php foreach ($attractieLijst->getAttracties() as $attractie) { ?>
            <div class="row">
                <div class="offset-md-4 col-md-8">
                    <?php echo $attractie->getGebruikerById()->getVolledigeNaam();?>
                </div>
            </div>

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
                    <a href="attractie.php?id=<?php echo $attractie->getIdattractie(); ?>">Reacties</a>
                </div>
            </div>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>