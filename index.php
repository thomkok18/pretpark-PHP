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
            <div class="row">
                <h1 class="col-xs-10">Attractie overzicht</h1>
            </div>
        </div>

        <?php foreach ($attractieLijst->getAttracties() as $key => $attractie) { ?>
            <div style="margin-bottom:20px; text-align: -webkit-center;" class="col-xs-12 col-sm-6 col-lg-4">
                <div style="max-width: 300px;">
                    <img src="<?= htmlspecialchars($attractie->getUrlfoto()); ?>" alt="Attractie" width="300" height="300">
                </div>
                <div style="max-width: 300px; text-align: initial;">
                    <h3 style="margin-top: 0;"><?= htmlspecialchars($attractie->getTitel()); ?></h3>
                    <p style=""><?= htmlspecialchars($attractie->getOmschrijving()); ?></p>
                </div>
                <div style="max-width: 300px;  text-align: initial;">
                    <i>Door: <?= htmlspecialchars($attractie->getGebruikerById()->getLogin()); ?></i>
                </div>
                <div style="max-width: 300px;  text-align: initial;">
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