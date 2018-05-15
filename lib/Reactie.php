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
        $query = "INSERT INTO reactie (idgebruiker, idattractie, reactietekst) VALUES (:idgebruiker, :idattractie, :reactietekst)";
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':idattractie',$this->idattractie, PDO::PARAM_INT);
        $sth->bindParam(':reactietekst',$this->reactietekst, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * @return mixed
     */
    public function getGebruikerById() {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM gebruiker WHERE idgebruiker = :idgebruiker");
        $sth->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        return $sth->fetch();
    }

    /**
     * @return mixed
     */
    public function getIdreactie() {
        return $this->idreactie;
    }

    /**
     * @param mixed $idreactie
     */
    public function setIdreactie($idreactie): void {
        $this->idreactie = $idreactie;
    }

    /**
     * @return mixed
     */
    public function getIdattractie() {
        return $this->idattractie;
    }

    /**
     * @param mixed $idattractie
     */
    public function setIdattractie($idattractie): void {
        $this->idattractie = $idattractie;
    }

    /**
     * @return mixed
     */
    public function getIdgebruiker() {
        return $this->idgebruiker;
    }

    /**
     * @param mixed $idgebruiker
     */
    public function setIdgebruiker($idgebruiker): void {
        $this->idgebruiker = $idgebruiker;
    }

    /**
     * @return mixed
     */
    public function getReactietekst() {
        return $this->reactietekst;
    }

    /**
     * @param mixed $reactietekst
     */
    public function setReactietekst($reactietekst): void {
        $this->reactietekst = $reactietekst;
    }
}
?>