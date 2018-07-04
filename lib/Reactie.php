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
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $stmt->bindParam(':idattractie',$this->idattractie, PDO::PARAM_INT);
        $stmt->bindParam(':reactietekst',$this->reactietekst, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getGebruikerById() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM gebruiker WHERE idgebruiker = :idgebruiker");
        $stmt->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        return $stmt->fetch();
    }

    public function updateReactieById($idreactie, $reactietekst) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE reactie SET reactietekst = :reactietekst WHERE idreactie = :idreactie';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idreactie', $idreactie, PDO::PARAM_INT);
        $stmt->bindParam(':reactietekst', $reactietekst, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param $idreactie
     * @return mixed
     */
    public function getIdgebruikerByIdReactie($idreactie) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idgebruiker FROM reactie WHERE idreactie = :idreactie");
        $stmt->bindParam(':idreactie', $idreactie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
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