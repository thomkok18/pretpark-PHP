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
    <h3>Gebruikers</h3>

    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Id</th>
            <th>Volledige naam</th>
            <th>Login</th>
            <th>Rechten</th>
        </tr>
        </thead>
        <?php foreach ($gebruikers as $key => $geb) { ?>
            <tbody>
            <tr>
                <?php //TODO delete gebruiker functie laten werken. ?>
                <th><a href="beheerder.php?delete=<?php echo $geb->idgebruiker; ?>"><img style="margin-top: 5px;" src="img/prullenbak.jpg" value="<?php echo $geb->idgebruiker; ?>" width="20" height="20"></a>
                <th><a class="btn btn-info" role="button" href="formGebruiker.php?id=<?php echo $geb->getIdgebruiker(); ?>"> <?php echo $geb->getIdgebruiker(); ?></a></th>
                <th class="tabelText"><?php echo $geb->getVolledigeNaam(); ?></th>
                <th class="tabelText"><?php echo $geb->getLogin(); ?></th>
                <th class="tabelText"><?php echo $rechten->getRechtenByIdGebruiker($geb->getIdrechten())->getRechtomschrijving(); ?></th>
            </tr>
            </tbody>
        <?php } ?>
    </table>

    <h3>Vooraad</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Id</th>
            <th>Product</th>
            <th>Vooraad</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th class="tabelText"><?php echo "1" //Id ?></th>
            <th class="tabelText"><?php echo "Test" //Product ?></th>
            <th class="tabelText"><?php echo "23" //Vooraad ?></th>
        </tr>
        </tbody>
    </table>

    <h3>Bestellen</h3>
    <div>
        <p class="col-xs-9 col-md-11">Test</p>
        <select class="col-xs-1 col-md-1">
            <?php for ($i = 0; $i <= 100; $i++) { ?>
                <option><?php echo $i; ?></option>
            <?php } ?>
        </select>
        <button class="btn col-xs-2" type="button">Winkelwagen</button>
    </div>

</div>
<?php
include("layout/footer.php");
?>
