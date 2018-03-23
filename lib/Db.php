<?php

class Db {
    private $connectie;

    function getConnectie() {
        if ($_SERVER['SERVER_NAME'] == "localhost") {
            $host = 'localhost';
            $port = 8889;
            $db = 'pretpark';
            $user = 'root';
            $password = 'root';
        } else {
            $host = 'website';
            $port = 8889;
            $db = 'school';
            $user = 'root';
            $password = 'root';
        }

        try {
            $this->connectie = new PDO("mysql:host=" . $host . ";port=" . $port . ";dbname=" . $db, $user, $password);
            //echo "De verbinding is gelukt.";
        } catch (PDOException $e) {
            echo 'De verbinding is niet gelukt, Connection failed: ' . $e->getMessage();
        }

//        try {
//            $this->$connectie = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
//            $dbh = null;
//        } catch (PDOException $e) {
//            print "Error!: " . $e->getMessage() . "<br/>";
//            die();
//        }

        return $this->connectie;
    }
}

?>