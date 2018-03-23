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
        $sth = $conn->prepare("select * from attractie");
        $sth->execute();
        $this->attracties = $sth->fetchAll(PDO::FETCH_CLASS, "Attractie");
    }
}
?>