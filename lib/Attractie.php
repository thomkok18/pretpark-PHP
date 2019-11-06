<?php
include_once('lib/Db.php');
include_once('lib/Gebruiker.php');
include_once('lib/Reactie.php');

class Attractie {
    private $idattractie;
    private $idgebruiker;
    private $titel;
    private $omschrijving;
    private $urlfoto;

    /**
     * @return array
     */
    public function getAttracties() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM attractie");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Attractie');
    }

    public function insertAttractie() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO attractie (idgebruiker, titel, omschrijving, urlfoto) VALUES (:idgebruiker, :titel, :omschrijving, :urlfoto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $stmt->bindParam(':titel',$this->titel, PDO::PARAM_STR);
        $stmt->bindParam(':omschrijving',$this->omschrijving, PDO::PARAM_STR);
        $stmt->bindParam(':urlfoto',$this->urlfoto, PDO::PARAM_STR);
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

    /**
     * @param $id
     * @return mixed
     */
    public function getAttractieById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM attractie WHERE idattractie = :id");
        $stmt->bindParam(':id',$id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Attractie');
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAttractieTitelById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT titel FROM attractie WHERE idattractie = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
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
    public function setIdattractie($idattractie) {
        $this->idattractie = $idattractie;
    }

    /**
     * @return array
     */
    function getReactiesByIdAttractieOrderByDESC() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM reactie WHERE idattractie = :idattractie ORDER BY idreactie DESC");
        $stmt->bindParam(':idattractie',$this->idattractie, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, "Reactie");
    }

    /**
     * @param $idattractie
     * @param $urlfoto
     * @return bool
     */
    public function updateUrlfoto($idattractie, $urlfoto) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE attractie SET urlfoto = :urlfoto WHERE idattractie = :idattractie';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idattractie', $idattractie, PDO::PARAM_INT);
        $stmt->bindParam(':urlfoto', $urlfoto, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param $idattractie
     * @param $titel
     * @param $omschrijving
     * @return bool
     */
    public function updateAttractiegegevens($idattractie, $titel, $omschrijving) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE attractie SET titel = :titel, omschrijving = :omschrijving WHERE idattractie = :idattractie';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idattractie', $idattractie, PDO::PARAM_INT);
        $stmt->bindParam(':titel', $titel, PDO::PARAM_STR);
        $stmt->bindParam(':omschrijving', $omschrijving, PDO::PARAM_STR);
        return $stmt->execute();
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
    public function setIdgebruiker($idgebruiker) {
        $this->idgebruiker = $idgebruiker;
    }

    /**
     * @return mixed
     */
    public function getTitel() {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel) {
        $this->titel = $titel;
    }

    /**
     * @return mixed
     */
    public function getOmschrijving() {
        return $this->omschrijving;
    }

    /**
     * @param mixed $omschrijving
     */
    public function setOmschrijving($omschrijving) {
        $this->omschrijving = $omschrijving;
    }

    /**
     * @return mixed
     */
    public function getUrlfoto() {
        return $this->urlfoto;
    }

    /**
     * @param mixed $urlfoto
     */
    public function setUrlfoto($urlfoto) {
        $this->urlfoto = $urlfoto;
    }
}
?>