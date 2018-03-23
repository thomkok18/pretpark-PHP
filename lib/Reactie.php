<?php
include_once("lib/Gebruiker.php");

class Reactie {
    private $idreactie;
    private $idattractie;
    private $idgebruiker;
    private $reactietekst;

    function __construct() {
    }

    public function getReactietekst() {
        return$this->reactietekst;
    }

    /**
     * @return mixed
     */
    public function getGebruikerById() {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM gebruiker WHERE idgebruiker = ".$this->idgebruiker);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        return $sth->fetch();
    }
}
?>