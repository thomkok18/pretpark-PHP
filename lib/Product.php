<?php
include_once('lib/Db.php');

class Product {
    private $idproduct;
    private $idgebruiker;
    private $titel;
    private $productomschrijving;
    private $voorraad;
    private $prijs;
    private $urlfoto;

    /**
     * @return bool
     */
    public function insertProduct() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO product (titel, productomschrijving, voorraad, prijs, urlfoto) VALUES(:titel, :productomschrijving, :voorraad, :prijs, :urlfoto)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':titel', $this->titel, PDO::PARAM_STR);
        $stmt->bindParam(':productomschrijving', $this->productomschrijving, PDO::PARAM_STR);
        $stmt->bindParam(':voorraad', $this->voorraad, PDO::PARAM_INT);
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
     * @param $id
     * @return mixed
     */
    public function getProductTitelById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT titel FROM product WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductUrlfotoById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT urlfoto FROM product WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 'Product');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductPrijsById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT prijs FROM product WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getProductVoorraadById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT voorraad FROM product WHERE idproduct = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN, 'Product');
    }

    /**
     * @return mixed
     */
    public function getProductPrijs() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct, prijs FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function getProductTitel() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct, titel FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function getProductUrl() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct, urlfoto FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    /**
     * @return mixed
     */
    public function getProductVoorraad() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct, voorraad FROM product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * @return mixed
     */
    public function getIdproducten() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT idproduct FROM product");
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * @param $idproduct
     * @param $titel
     * @param $productomschrijving
     * @param $prijs
     * @return bool
     */
    public function updateProductgegevens($idproduct, $titel, $productomschrijving, $prijs) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE product SET titel = :titel, productomschrijving = :productomschrijving, prijs = :prijs WHERE idproduct = :idproduct';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':titel', $titel, PDO::PARAM_STR);
        $stmt->bindParam(':productomschrijving', $productomschrijving, PDO::PARAM_STR);
        $stmt->bindParam(':prijs', $prijs, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @param $idproduct
     * @param $voorraad
     * @param $aantal
     * @param $status
     * @return bool
     */
    public function updateVoorraad($idproduct, $voorraad, $aantal, $status) {
        $db = new Db();
        $conn = $db->getConnectie();
        if ($status == 'verkocht') {
            $query = 'UPDATE product SET voorraad = :voorraad - :aantal WHERE idproduct = :idproduct';
        } else {
            $query = 'UPDATE product SET voorraad = :voorraad + :aantal WHERE idproduct = :idproduct';
        }
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':voorraad', $voorraad, PDO::PARAM_INT);
        $stmt->bindParam(':aantal', $aantal, PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * @return bool
     */
    public function deleteProduct() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "DELETE FROM product WHERE idproduct = :idproduct";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $_GET['deleteProduct']);
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
    public function getPrijs() {
        return $this->prijs;
    }

    /**
     * @param mixed $prijs
     */
    public function setPrijs($prijs) {
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
     * @param $idproduct
     * @param $urlfoto
     * @return bool
     */
    public function updateProductfoto($idproduct, $urlfoto) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE product SET urlfoto = :urlfoto WHERE idproduct = :idproduct';
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idproduct', $idproduct, PDO::PARAM_INT);
        $stmt->bindParam(':urlfoto', $urlfoto, PDO::PARAM_STR);
        return $stmt->execute();
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
    public function setIdproduct($idproduct) {
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
    public function setTitel($titel) {
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
    public function setProductomschrijving($productomschrijving) {
        $this->productomschrijving = $productomschrijving;
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

    /**
     * @return mixed
     */
    public function getVoorraad() {
        return $this->voorraad;
    }

    /**
     * @param mixed $voorraad
     */
    public function setVoorraad($voorraad) {
        $this->voorraad = $voorraad;
    }
}