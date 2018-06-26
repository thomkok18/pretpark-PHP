<?php

class Winkelwagen {
    private $idwinkelwagen;
    private $idgebruiker;
    private $idproduct;
    private $aantal;

    /**
     * @return bool
     */
    public function insertWinkelwagen() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO winkelwagen (idwinkelwagen, idgebruiker, idproduct, aantal) VALUES (:idwinkelwagen, :idgebruiker, :idproduct, :aantal)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idwinkelwagen',$this->idwinkelwagen, PDO::PARAM_INT);
        $stmt->bindParam(':idgebruiker',$this->idgebruiker, PDO::PARAM_INT);
        $stmt->bindParam(':idproduct',$this->idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':aantal',$this->aantal, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAantalById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT aantal FROM winkelwagen WHERE idgebruiker = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_COLUMN, 'Winkelwagen');
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getIdproductByIdgebruiker($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct FROM winkelwagen WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param $idproduct
     * @param $idgebruiker
     * @param $aantal
     * @return bool
     */
    public function updateIdproduct($idproduct, $idgebruiker, $aantal) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE winkelwagen SET idproduct = :idproduct, aantal = :aantal WHERE idproduct = :idproduct AND idgebruiker = :idgebruiker';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':idgebruiker', $idgebruiker, PDO::PARAM_INT);
        $stmt->bindParam(':aantal', $aantal, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getIdwinkelwagen() {
        return $this->idwinkelwagen;
    }

    /**
     * @param mixed $idwinkelwagen
     */
    public function setIdwinkelwagen($idwinkelwagen): void {
        $this->idwinkelwagen = $idwinkelwagen;
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
    public function getIdproduct() {
        return $this->idproduct;
    }

    /**
     * @param mixed $idproduct
     */
    public function setIdproduct($idproduct): void {
        $this->idproduct = $idproduct;
    }

    /**
     * @return mixed
     */
    public function getAantal() {
        return $this->aantal;
    }

    /**
     * @param mixed $aantal
     */
    public function setAantal($aantal): void {
        $this->aantal = $aantal;
    }

}