<?php
include_once("lib/config.php");
$_SESSION = array();
session_destroy();
header('Location: login.php');
?>