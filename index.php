<?php
include_once('lib/config.php');
include_once("lib/AttractieLijst.php");

$attractieLijst = new AttractieLijst();
$attractieLijst->selectAttracties();
$pagina = 'index';

include("layout/header.php");
?>
    <div class="container">

        <div class="page-header">
            <div class="row">
                <h1 class="col-xs-10">Attractie overzicht</h1>
            </div>
        </div>

        <?php foreach ($attractieLijst->getAttracties() as $key => $attractie) { ?>
            <div class="row">
                <div class="col-md-4">
                    <img src="<?php echo htmlspecialchars($attractie->getUrlfoto()); ?>" alt="Attractie" width="300" height="300">
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top: 0;"><?php echo htmlspecialchars($attractie->getTitel()); ?></h3>
                    <p><?php echo htmlspecialchars($attractie->getOmschrijving()); ?></p>
                </div>
                <div class="offset-md-4 col-md-8">
                    <i>Door: <?php echo htmlspecialchars($attractie->getGebruikerById()->getLogin()); ?></i>
                </div>
                <div class="offset-md-4 col-md-8">
                    <a id="reactieButton" role="button" class="btn btn-default col-xs-2" href="attractie.php?id=<?php echo htmlspecialchars($attractie->getIdattractie()); ?>">Reacties</a>
                </div>
            </div>
            <div class="row">
            </div>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>