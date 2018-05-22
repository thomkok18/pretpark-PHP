<?php
include_once('lib/Db.php');

class Rechten {
    private $idrechten;
    private $rechtomschrijving;

    /**
     * @param $idgebruiker
     * @return mixed
     */
    public function getRechtenByIdGebruiker($idgebruiker) {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM rechten WHERE idrechten = :idgebruiker");
        $stmt->bindParam(':idgebruiker',$idgebruiker, PDO::PARAM_INT);
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
    public function setIdrechten($idrechten): void {
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
    public function setRechtomschrijving($rechtomschrijving): void {
        $this->rechtomschrijving = $rechtomschrijving;
    }
}