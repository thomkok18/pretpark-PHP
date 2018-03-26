<?php
session_start();

if (PHP_MAJOR_VERSION < 7 && PHP_MINOR_VERSION < 5) {
    // Versie is lager dan 5.5
    include("lib/compatibility_functions.php");
}