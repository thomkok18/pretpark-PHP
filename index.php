<?php
include_once('lib/config.php');
include_once("lib/AttractieLijst.php");

$attractieLijst = new AttractieLijst();
$attractieLijst->selectAttracties();
$pagina = 'index';

include("layout/header.php");
?>
    <div class="container-fluid">
        <div class="page-header">
            <h1>Attractie overzicht</h1>
        </div>

        <?php foreach ($attractieLijst->getAttracties() as $key => $attractie) { ?>
            <div id="attractieDiv" class="col-xs-12 col-sm-6 col-lg-4">
                <div id="attractieImageDiv">
                    <img id="attractieImage" src="<?= htmlspecialchars($attractie->getUrlfoto()); ?>" alt="Attractie">
                </div>
                <div id="attractieTekstDiv">
                    <h3 id="attractieTitel"><?= htmlspecialchars($attractie->getTitel()); ?></h3>
                    <p><?= htmlspecialchars($attractie->getOmschrijving()); ?></p>
                </div>
                <div id="gemaaktDoorDiv">
                    <i>Door: <?= htmlspecialchars($attractie->getGebruikerById()->getLogin()); ?></i>
                </div>
                <div id="reactiesButtonDiv">
                    <a id="reactieButton" role="button" class="btn btn-default" href="attractie.php?id=<?= htmlspecialchars($attractie->getIdattractie()); ?>&idreactie=0">Reacties</a>
                </div>
            </div>
            <?php if ($key == 1) { ?>
            <div class="clearfix visible-sm visible-md"></div>
            <?php } ?>
            <?php if ($key == 2) { ?>
                <div class="clearfix visible-xs visible-lg"></div>
            <?php } ?>
        <?php } ?>

    </div>

<?php
include("layout/footer.php");
?>