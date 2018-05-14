<?php
include_once('lib/Db.php');

class Product {
    private $idproduct;
    private $titel;
    private $productomschrijving;
    private $aantal;
    private $urlfoto;

    /**
     * @return array
     */
    public function getProducten() {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM product");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS, 'Product');
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