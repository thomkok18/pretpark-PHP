<?php
include_once('lib/Db.php');

class Rechten {
    private $idrechten;
    private $rechtenomschrijving;

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
    public function getRechtenomschrijving() {
        return $this->rechtenomschrijving;
    }

    /**
     * @param mixed $rechtenomschrijving
     */
    public function setRechtenomschrijving($rechtenomschrijving): void {
        $this->rechtenomschrijving = $rechtenomschrijving;
    }
}