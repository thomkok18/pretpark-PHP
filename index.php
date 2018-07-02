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
            <div style="margin-bottom:20px;" class="row">
                <div class="col-md-4">
                    <img src="<?= htmlspecialchars($attractie->getUrlfoto()); ?>" alt="Attractie" width="300" height="300">
                </div>
                <div class="col-md-8">
                    <h3 style="margin-top: 0;"><?= htmlspecialchars($attractie->getTitel()); ?></h3>
                    <p><?= htmlspecialchars($attractie->getOmschrijving()); ?></p>
                </div>
                <div class="offset-md-4 col-md-8">
                    <i>Door: <?= htmlspecialchars($attractie->getGebruikerById()->getLogin()); ?></i>
                </div>
                <div class="offset-md-4 col-md-8">
                    <a id="reactieButton" role="button" class="btn btn-default col-xs-2" href="attractie.php?id=<?= htmlspecialchars($attractie->getIdattractie()); ?>&idreactie=0">Reacties</a>
                </div>
            </div>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>