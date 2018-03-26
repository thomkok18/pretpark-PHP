<?php
define("PASSWORD_DEFAULT", "nothing");

/**
 * @param $password
 * @param $hash
 * @return bool
 */
function password_verify($password, $hash) {
    if ($hash == sha1($password.getSalt())) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return string
 */
function getSalt() {
    return "!3rudEDw#$@";
}
?>