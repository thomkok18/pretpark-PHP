<?php
include_once("lib/Db.php");
include_once("lib/Gebruiker.php");

class Reactie {
    private $idreactie;
    private $idattractie;
    private $idgebruiker;
    private $reactietekst;

    function __construct() {
    }

    /**
     * @return bool
     */
    public function insertReactie() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO reactie (idgebruiker, idattractie, reactietekst) "
            ."VALUES (:idgebruiker, :idattractie, :reactietekst)";
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':idattractie',$this->idattractie, PDO::PARAM_INT);
        $sth->bindParam(':reactietekst',$this->reactietekst, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * @return mixed
     */
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

    /**
     * @param $tekst
     */
    public function setReactietekst($tekst) {
        $this->reactietekst = $tekst;
    }

    /**
     * @param $id
     */
    public function setIdGebruiker($id) {
        $this->idgebruiker = $id;
    }

    /**
     * @param $id
     */
    public function setIdAttractie($id) {
        $this->idattractie = $id;
    }
}
?>