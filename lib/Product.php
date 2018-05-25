<?php
include_once('lib/Db.php');

class Product {
    private $idproduct;
    private $idgebruiker;
    private $titel;
    private $productomschrijving;
    private $aantal;
    private $prijs;
    private $urlfoto;

    /**
     * @return bool
     */
    public function insertProduct() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO product (idproduct, idgebruiker, titel, productomschrijving, aantal, prijs, urlfoto) VALUES(:idproduct, :idgebruiker, :titel, :productomschrijving, :aantal, :prijs, :urlfoto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $this->idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':idgebruiker', $this->idgebruiker, PDO::PARAM_INT);
        $stmt->bindParam(':titel', $this->titel, PDO::PARAM_STR);
        $stmt->bindParam(':productomschrijving', $this->productomschrijving, PDO::PARAM_STR);
        $stmt->bindParam(':aantal', $this->aantal, PDO::PARAM_INT);
        $stmt->bindParam(':prijs', $this->prijs, PDO::PARAM_STR);
        $stmt->bindParam(':urlfoto', $this->urlfoto, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM product WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Product');
        return $stmt->fetch();
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
    public function getPrijs() {
        return $this->prijs;
    }

    /**
     * @param mixed $prijs
     */
    public function setPrijs($prijs): void {
        $this->prijs = $prijs;
    }

    /**
     * @return array
     */
    public function getProducten() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Product');
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
    public function getProductomschrijving() {
        return $this->productomschrijving;
    }

    /**
     * @param mixed $productomschrijving
     */
    public function setProductomschrijving($productomschrijving): void {
        $this->productomschrijving = $productomschrijving;
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
}