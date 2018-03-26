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
    private $aangemaakt;
    private $gewijzigd;


    public function __construct() {

    }

    public function insertAttractie() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO attractie (idgebruiker, titel, omschrijving, urlfoto) "
            ."VALUES (:idgebruiker, :titel, :omschrijving, :urlfoto)";
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':titel',$this->titel, PDO::PARAM_STR);
        $sth->bindParam(':omschrijving',$this->omschrijving, PDO::PARAM_STR);
        $sth->bindParam(':urlfoto',$this->urlfoto, PDO::PARAM_STR);
        return $sth->execute();
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
     * @param $id
     * @return mixed
     */
    public function getAttractieById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM attractie WHERE idattractie = ".$id);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Attractie');
        return $sth->fetch();
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
     * @return array
     */
    function getReactiesByIdAttractie() {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM reactie WHERE idattractie = ".$this->idattractie);
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS, "Reactie");
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
    public function getTitel() {
        return $this->titel;
    }

    /**
     * @param mixed $titel
     */
    public function setTitel($titel): void {
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
    public function setOmschrijving($omschrijving): void {
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
    public function setUrlfoto($urlfoto): void {
        $this->urlfoto = $urlfoto;
    }

    /**
     * @return mixed
     */
    public function getAangemaakt() {
        return $this->aangemaakt;
    }

    /**
     * @param mixed $aangemaakt
     */
    public function setAangemaakt($aangemaakt): void {
        $this->aangemaakt = $aangemaakt;
    }

    /**
     * @return mixed
     */
    public function getGewijzigd() {
        return $this->gewijzigd;
    }

    /**
     * @param mixed $gewijzigd
     */
    public function setGewijzigd($gewijzigd): void {
        $this->gewijzigd = $gewijzigd;
    }
}
?>