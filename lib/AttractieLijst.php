<?php
include_once("Db.php");
include_once("lib/Attractie.php");

class AttractieLijst {
    private $attracties;

    /**
     * AttractieLijst constructor.
     */
    public function __construct() {
        $this->attracties = array();
    }

    /**
     * @return array
     */
    public function getAttracties() {
        return $this->attracties;
    }

    /**
     * @param array $attracties
     */
    public function setAttracties(array $attracties): void {
        $this->attracties($attracties);
    }

    /**
     *
     */
    function selectAttracties() {
        $db = new Db();
        $conn = $db->getConnectie();
        $stmt = $conn->prepare("select * from attractie");
        $stmt->execute();
        $this->attracties = $stmt->fetchAll(PDO::FETCH_CLASS, "Attractie");
    }
}
?>