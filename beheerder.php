<?php
include_once('lib/config.php');
include_once("lib/Gebruiker.php");
include_once("lib/Rechten.php");
$gebruiker = new Gebruiker();
$gebruikers = $gebruiker->getGebruikers();
$rechten = new Rechten();
$pagina = 'beheerder';

include("layout/header.php");
?>
<div class="container">
    <div class="page-header">
        <h1>Beheren</h1>
    </div>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Volledige naam</th>
            <th>Login</th>
            <th>Wachtwoord</th>
            <th>Rechten</th>
        </tr>
        </thead>
        <?php foreach ($gebruikers as $key => $gebruiker) { ?>
            <tbody>
            <tr>
                <th><a href="beheerder.php?delete= <?php// $gebruiker['idgebruiker']?>"><img style="margin-top: 5px;" src="img/prullenbak.jpg" value="<?php echo $gebruiker->getIdgebruiker(); ?>" width="20" height="20"></a>
                <th><a class="btn btn-info" role="button" href="formGebruiker.php?id=<?php echo $gebruiker->getIdgebruiker(); ?>"> <?php echo $gebruiker->getIdgebruiker(); ?></a></th>
                <th class="tabelText"><?php echo $gebruiker->getVolledigeNaam(); ?></th>
                <th class="tabelText"><?php echo $gebruiker->getLogin(); ?></th>
                <th class="tabelText"><?php echo $gebruiker->getWachtwoord(); ?></th>
                <th class="tabelText"><?php echo $rechten->getRechtenByIdGebruiker($gebruiker->getIdrechten())->getRechtomschrijving(); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>
</div>
<?php
include("layout/footer.php");
?>
