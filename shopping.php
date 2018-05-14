<?php
include_once('lib/config.php');
$pagina = 'shopping';

include("layout/header.php");
?>

    <div class="container">
        <div class="page-header">
            <h1>Winkel</h1>
        </div>

        <div>
            <p class="col-xs-11">Test</p>
            <select style="padding-top: 6px; padding-bottom: 6px;" class="col-xs-1">
                <?php for ($i = 0; $i <= 100; $i++) { ?>
                    <option><?php echo $i; ?></option>
                <?php } ?>
            </select>
        </div>

    </div>

<?php
include("layout/footer.php");
?>