<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <?php if ($pagina === 'beheerder') { ?>
        <link rel="stylesheet" href="../css/beheerder.css">
    <?php } ?>
</head>
<body>
<!-- Static navbar -->
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li <?php if ($pagina === 'attractie') { ?> class="active" <?php } ?> ><a
                            href="index.php">Attracties</a></li>
                <?php if (isset($_SESSION['login']) && $_SESSION['login']['rechten'] == 'Beheerder') { ?>
                    <li <?php if ($pagina === 'beheerder') { ?> class="active" <?php } ?> ><a href="beheerder.php">Beheren</a>
                    </li>
                <?php } ?>
                <?php if (!isset($_SESSION['login'])) { ?>
                    <li <?php if ($pagina === 'registreren') { ?> class="active" <?php } ?> ><a href="registreren.php">Registreren</a>
                    </li>
                <?php } ?>
                <?php if (isset($_SESSION['login'])) { ?>
                    <li><a href="loguit.php">Uitloggen</a></li>
                    <li><img style="width:42px;height:42px; margin-top:4px;"
                             src="img/<?php echo $_SESSION['login']['login']; ?>.png"
                             alt="plaatje gebruiker"></li>
                    <li><a><?php echo $_SESSION['login']['volledige naam']; ?></a></li>
                <?php } else { ?>
                    <li <?php if ($pagina === 'login') { ?> class="active" <?php } ?>><a href="login.php">Inloggen</a>
                    </li>
                <?php } ?>
            </ul>

        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>
<img style="width:20%;margin:auto;" src="img/pretpark_logo.png" class="img-responsive" alt="logo pretpark">
<div class="container">
    <?php if (isset($messages) && count($messages) > 0) { ?>
        <div class="well">
            <ul>
                <?php foreach ($messages as $message) { ?>
                    <li class="message"><?php echo $message; ?></li>
                <?php } ?>
            </ul>
        </div>
    <?php } ?>
