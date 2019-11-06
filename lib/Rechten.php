<?php
include_once('lib/Db.php');

class Rechten {
    private $idrechten;
    private $rechtomschrijving;

    /**
     * @param $idgebruiker
     * @return mixed
     */
    public function getRechtenByIdGebruiker($idrechten) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM rechten WHERE idrechten = :idrechten");
        $stmt->bindParam(':idrechten',$idrechten, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Rechten');
        return $stmt->fetch();
    }

    /**
     * @return mixed
     */
    public function getIdrechten() {
        return $this->idrechten;
    }

    /**
     * @param mixed $idrechten
     */
    public function setIdrechten($idrechten) {
        $this->idrechten = $idrechten;
    }

    /**
     * @return mixed
     */
    public function getRechtomschrijving() {
        return $this->rechtomschrijving;
    }

    /**
     * @param $rechtomschrijving
     */
    public function setRechtomschrijving($rechtomschrijving) {
        $this->rechtomschrijving = $rechtomschrijving;
    }
}