<?php

class Winkelwagen {
    private $idproduct;
    private $titel;
    private $aantal;
    private $prijs;

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
    public function getPrijs() {
        return $this->prijs;
    }

    /**
     * @param mixed $prijs
     */
    public function setPrijs($prijs): void {
        $this->prijs = $prijs;
    }

}