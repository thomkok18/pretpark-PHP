<?php
include_once('lib/Db.php');

class Saldo {
    private $idsaldo;
    private $saldo;

    /**
     * @return array
     */
    public function getSaldoVoorraad() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("SELECT * FROM saldo");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Saldo');
    }

    /**
     * @param $idsaldo
     * @param $saldo
     * @param $totaal
     * @param $status
     * @return bool
     */
    public function updateSaldo($idsaldo, $saldo, $totaal, $status) {
        $db = new Db();
        $conn = $db->getConnectie();
        if ($status === 'verkocht') {
            $query = 'UPDATE saldo SET saldo = :saldo + :totaal WHERE idsaldo = :idsaldo';
        } else {
            $query = 'UPDATE saldo SET saldo = :saldo - :totaal WHERE idsaldo = :idsaldo';
        }
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':idsaldo', $idsaldo, PDO::PARAM_INT);
        $stmt->bindParam(':saldo', $saldo, PDO::PARAM_STR);
        $stmt->bindParam(':totaal', $totaal, PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * @return mixed
     */
    public function getIdsaldo() {
        return $this->idsaldo;
    }

    /**
     * @param mixed $idsaldo
     */
    public function setIdsaldo($idsaldo) {
        $this->idsaldo = $idsaldo;
    }

    /**
     * @return mixed
     */
    public function getSaldo() {
        return $this->saldo;
    }

    /**
     * @param mixed $saldo
     */
    public function setSaldo($saldo) {
        $this->saldo = $saldo;
    }
}