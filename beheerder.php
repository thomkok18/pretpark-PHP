<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
$gebruiker = new Gebruiker();
$gebruikers = $gebruiker->getGebruikers();

include("layout/header.php");
?>
<div class="container">
    <div class="page-header">
        <h1>Beheren</h1>
    </div>

    <?php foreach ($gebruikers as $gebruiker) { ?>
        <p><?php echo "Id: ". $gebruikers->getIdgebruiker(); ?></p>
        <p><?php echo "Naam: ".$gebruikers->getVolledigeNaam(); ?></p>
        <p><?php echo "Login: ".$gebruikers->getLogin(); ?></p>
        <p><?php echo "Wachtwoord: ".$gebruikers->getWachtwoord(); ?></p>
        <p><?php echo "Rechten: ". $gebruikers->getRechten(); ?></p>
    <?php } ?>


</div>
<?php
include("layout/footer.php");
?>
