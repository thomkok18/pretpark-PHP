<?php
include_once('lib/config.php');
include_once('lib/Attractie.php');
include_once('lib/Reactie.php');

if (!isset($_SESSION)) {
    session_start();
}

$id = $_GET['id'];
$Attractie = new Attractie();
$attractie = $Attractie->getAttractieById($id);
$reacties = $attractie->getReactiesByIdAttractieOrderByDESC();
$gebruiker = $attractie->getGebruikerById();
$reactie = new Reactie();
$pagina = 'attractie';

if (isset($_POST['toevoegen'])) {
    extract($_POST);
    $reactie = new Reactie();
    $reactie->setReactietekst($_POST['reactietekst']);
    $reactie->setIdGebruiker($_SESSION['login']['idgebruiker']);
    $reactie->setIdAttractie($id);

    if ($reactie->insertReactie()) {
        header('Location: attractie.php?id=' . $id . '&idreactie=0');
    } else {
        $message[] = "Reactie is niet toegevoegd";
    }
}

if (isset($_POST['aanpassen'])) {
    extract($_POST);
    $reactie = new Reactie();
    $reactie->updateReactieById($_POST['idreactie'], $_POST['reactietekstAanpassen']);
    header('Location: attractie.php?id=' . $id . '&idreactie=0');
}

if (isset($_GET['deleteReactie']) && !empty($_GET['deleteReactie'])) {
    $conn = new Reactie();
    $conn->deleteReactie();
    header('Location: attractie.php?id=' . $id . '&idreactie=0');
}

include("layout/header.php");
?>
    <div class="container-fluid">
        <div class="page-header">
            <h1>Attractie</h1>
        </div>

        <div>
            <div class="col-md-4">
                <img id="attractieImage" src="<?= htmlspecialchars($attractie->getUrlFoto()); ?>" alt="Attractie">
            </div>

            <div class="col-md-8">
                <div>
                    <h3><?= htmlspecialchars($attractie->getTitel()); ?></h3>
                </div>
                <p><?= htmlspecialchars($attractie->getOmschrijving()); ?></p>
            </div>
        </div>
        <?php if (isset($_SESSION['login'])) { ?>
            <form class="form-horizontal" action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . $id); ?>" method="post">
                <div class="form-group">
                    <div id="reactieBalk" class="col-xs-12">
                        <div class="col-xs-12 col-sm-1">
                            <img id="profielAfbeelding" src="<?= htmlspecialchars($_SESSION['login']['avatar']); ?>" alt="<?= htmlspecialchars($gebruiker->getLogin()); ?>">
                        </div>
                        <div class="col-xs-12 col-sm-10">
                            <textarea id="tekstvak" class="form-control" name="reactietekst" placeholder="Voeg reactie toe" rows="1"></textarea>
                        </div>
                        <div class="col-xs-12 col-sm-1">
                            <button id="reageerButton" type="submit" class="btn btn-default" name="toevoegen">Reageren</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
        <hr>
        <?php foreach ($reacties

        as $reactie) {
        $gebruiker = $reactie->getGebruikerById();
        ?>
        <div id="regel">
            <div class="col-md-1">
                <img id="reactieProfielfoto" src="<?= htmlspecialchars($gebruiker->getAvatar()); ?>" alt="<?= htmlspecialchars($gebruiker->getLogin()); ?>">
            </div>
            <div class="col-md-11">
                <?php if (isset($_SESSION['login'])) {
                    if ($_SESSION['login']['login'] == $gebruiker->getLogin()) {
                        if ($reactie->getIdreactie() != $_GET['idreactie']) { ?>
                            <div id="bewerkButton">
                                <img id="bewerkImage" onclick="bewerken(<?= $id; ?>,<?= $reactie->getIdreactie(); ?>)" src="img/bewerk.jpg">
                                <a href="attractie.php?id=<?= htmlspecialchars($attractie->getIdattractie()); ?>&deleteReactie=<?= htmlspecialchars($reactie->getIdreactie()); ?>"><img
                                            id="prullenbakImage" src="img/prullenbakOpen.jpg"></a>
                            </div>
                        <?php } else { ?>
                            <div id="cancelButton">
                                <img id="cancelImage" onclick="cancel(<?= $id; ?>)" src="img/cancel.png">
                            </div>
                        <?php }
                    }
                } ?>
                <p id="gebruikersnaam"><b><?= htmlspecialchars($gebruiker->getLogin()); ?></b></p>
                <?php if ($reactie->getIdreactie() != $_GET['idreactie'] || $reactie->getIdgebruikerByIdReactie($_GET['idreactie'])[0] != $_SESSION['login']['idgebruiker']) { ?>
                    <p id="reactieTekst"><?= htmlspecialchars($reactie->getReactietekst()); ?></p>
                <?php } else { ?>
                    <form class="form-horizontal" method="post">
                        <input hidden name="id" value="<?= $id; ?>">
                        <input hidden name="idreactie" value="<?= $reactie->getIdreactie(); ?>">
                        <div id="reactieAanpassen" class="col-xs-10">
                            <textarea class="form-control" name="reactietekstAanpassen" rows="4"><?= $reactie->getReactietekst(); ?></textarea>
                        </div>
                        <div class="col-xs-2">
                            <button id="aanpassenButton" type="submit" class="btn btn-default" name="aanpassen">Aanpassen</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
            <?php } ?>
            <?php if (sizeof($reacties) <= 0 && isset($_SESSION['login'])) { ?>
                <p><?= 'Er zijn geen reacties geplaatst.'; ?></p>
            <?php } ?>
        </div>
    </div>
</div>
    <script>
        function bewerken(idattractie, idreactie) {
            window.location.href = "attractie.php?id=" + idattractie + "&idreactie=" + idreactie;
        }

        function cancel(idattractie) {
            window.location.href = "attractie.php?id=" + idattractie + "&idreactie=0";
        }
    </script>
<?php
include("layout/footer.php");
?>