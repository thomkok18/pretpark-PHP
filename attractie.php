<?php
include_once('lib/config.php');
include_once('lib/Attractie.php');

if (!isset($_SESSION)) {
    session_start();
}

$id = $_GET['id'];
$Attractie = new Attractie();
$attractie = $Attractie->getAttractieById($id);
$reacties = $attractie->getReactiesByIdAttractieOrderByDESC();
$gebruiker = $attractie->getGebruikerById();
$pagina = 'attractie';

if (isset($_POST['toevoegen'])) {
    extract($_POST);
    $reactie = new Reactie();
    $reactie->setReactietekst($reactietekst);
    $reactie->setIdGebruiker($_SESSION['login']['idgebruiker']);
    $reactie->setIdAttractie($id);

    if ($reactie->insertReactie()) {
        header('Location: attractie.php?id=' . $id. '&idreactie=0');
    } else {
        $message[] = "Reactie is niet toegevoegd";
    }
}

if (isset($_POST['aanpassen'])) {
    extract($_POST);
    $reactie = new Reactie();
    $reactie->updateReactieById($idreactie,$reactietekstAanpassen);
    header('Location: attractie.php?id=' . $id. '&idreactie=0');
}

include("layout/header.php");
?>
    <div class="container">
        <div class="page-header">
            <h1>Attractie</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo htmlspecialchars($attractie->getUrlFoto()); ?>" alt="Attractie" width="300" height="300">
            </div>

            <div class="col-md-8">
                <div class="row">
                    <?php if (isset($_SESSION['login'])) { ?>
                        <h3 style="margin-top: 0;" class="col-xs-10"><?php echo htmlspecialchars($attractie->getTitel()); ?></h3>
                    <?php } ?>
                </div>
                <p><?php echo htmlspecialchars($attractie->getOmschrijving()); ?></p>
            </div>
        </div>
        <?php if (isset($_SESSION['login'])) { ?>
            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id=" . $id); ?>" method="post">
                <div class="form-group">
                    <div class="col-xs-12" style="margin-top:20px;">
                        <div class="col-xs-1">
                            <img id="profielAfbeelding" src="<?php echo htmlspecialchars($_SESSION['login']['avatar']); ?>" alt="<?php echo htmlspecialchars($gebruiker->getLogin()); ?>">
                        </div>
                        <div class="col-xs-10">
                            <textarea style="margin-top:5px;" class="form-control" name="reactietekst" placeholder="Voeg reactie toe" rows="1"></textarea>
                        </div>
                        <div class="col-xs-1">
                            <button style="margin-top:5px;" type="submit" class="btn btn-default" name="toevoegen">Reageren</button>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
        <hr>
        <?php foreach ($reacties as $reactie) {
            $gebruiker = $reactie->getGebruikerById();
            ?>
            <div class="row" id="test">
                <div class="col-md-1">
                    <img style="margin-top: 15px;" id="reactieProfielfoto" src="<?php echo htmlspecialchars($gebruiker->getAvatar()); ?>" alt="<?php echo htmlspecialchars($gebruiker->getLogin()); ?>">
                </div>
                <div class="col-md-11">
                    <?php if (isset($_SESSION['login'])) { ?>
                    <?php if ($_SESSION['login']['login'] == $gebruiker->getLogin()) { ?>
                    <?php if ($reactie->getIdreactie() != $_GET['idreactie']) { ?>
                        <div style="float:right;">
                            <img style="margin-top: 10px; cursor: pointer;" onclick="bewerken(<?php echo $id; ?>,<?php echo $reactie->getIdreactie(); ?>)" src="img/bewerk.jpg" height="20" width="20">
                        </div>
                    <?php } else { ?>
                            <div style="float:right;">
                                <img style="margin-top: 10px; cursor: pointer;" onclick="cancel(<?php echo $id; ?>)" src="img/cancel.png" height="20" width="20">
                            </div>
                        <?php }
                    } } ?>
                    <p style="margin-top: 10px;"><b><?php echo htmlspecialchars($gebruiker->getLogin()); ?></b></p>
                    <?php if ($reactie->getIdreactie() != $_GET['idreactie']) { ?>
                    <p style="white-space: nowrap;"><?php echo htmlspecialchars($reactie->getReactietekst()); ?></p>
                    <?php } else { ?>
                        <form class="form-horizontal" method="post">
                            <input hidden name="id" value="<?php echo $id; ?>">
                            <input hidden name="idreactie" value="<?php echo $reactie->getIdreactie(); ?>">
                            <div style="padding-left: 0;" class="col-xs-10">
                                <textarea class="form-control" name="reactietekstAanpassen" rows="1"><?php echo $reactie->getReactietekst(); ?></textarea>
                            </div>
                            <div class="col-xs-2">
                                <button style="margin-top:5px;" type="submit" class="btn btn-default" name="aanpassen">Aanpassen</button>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
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