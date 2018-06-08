<?php
include_once('lib/config.php');
include_once('lib/Attractie.php');

if(!isset($_SESSION)) {
    session_start();
}

$id = $_GET['id'];
$Attractie = new Attractie();
$attractie = $Attractie->getAttractieById($id);
$reacties = $attractie->getReactiesByIdAttractie();
$gebruiker = $attractie->getGebruikerById();
$pagina = 'attractie';

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
                <img class="img-responsive" src="<?php echo $attractie->getUrlFoto(); ?>" alt="Attractie">
            </div>

            <div class="col-md-8">
                <p><i><?php echo $gebruiker->getLogin(); ?></i></p>
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
                    <img id="reactieProfielfoto" src="<?php echo $gebruiker->getAvatar(); ?>" alt="<?php echo $gebruiker->getLogin(); ?>">
                </div>
                <div class="col-md-11">
                    <p><?php echo $reactie->getReactietekst(); ?></p>
                    <p><i>Door: <?php echo $gebruiker->getLogin(); ?></i></p>
                </div>
            </div>
        <?php } ?>
    </div>
<?php
include("layout/footer.php");
?>