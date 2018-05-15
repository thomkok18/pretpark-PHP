<?php
include_once('lib/Db.php');
include_once('lib/Rechten.php');

class Gebruiker {
    public $idgebruiker;
    private $idrechten;
    private $naam;
    private $tussenvoegsels;
    private $achternaam;
    private $login;
    private $wachtwoord;
    private $avatar;

    /**
     * Beheerder constructor.
     */
    public function __construct() {
    }

    /**
     * @param $idgebruiker
     * @return mixed
     */
    public function getRechtomschrijvingByIdGebruiker($idgebruiker) {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT idrechten FROM gebruiker WHERE idgebruiker = :idgebruiker AND idrechten = 1");
        $sth->bindParam(':idgebruiker', $idgebruiker, PDO::PARAM_INT);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_COLUMN, 'Rechten');
        return $sth->fetch();
    }

    /**
     * @param $orgWachtwoord
     * @param $login
     * @return bool|mixed
     */
    public function checkLogin($orgWachtwoord, $login) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "SELECT * FROM gebruiker WHERE login = :login";
        $sth = $conn->prepare($query);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        $gebruiker = $sth->fetch();
        $rechten = new Rechten();
        if ($gebruiker && password_verify($orgWachtwoord, $gebruiker->getWachtwoord())) {
            $_SESSION['login'] = array (
                "volledige naam" => $gebruiker->getVolledigeNaam(),
                "idgebruiker" => $gebruiker->getIdgebruiker(),
                "login" => $gebruiker->getLogin(),
                "rechten" => $rechten->getRechtenByIdGebruiker(
                    $gebruiker->getIdrechten()
                )->getRechtomschrijving()
            );
            return $gebruiker;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function insertGebruiker() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "INSERT INTO gebruiker (naam, tussenvoegsels, achternaam, login, wachtwoord, idrechten) VALUES(:naam, :tussenvoegsels, :achternaam, :login, :wachtwoord, :idrechten)";
        $sth = $conn->prepare($query);
        $sth->bindParam(':naam', $this->naam, PDO::PARAM_STR);
        $sth->bindParam(':tussenvoegsels', $this->tussenvoegsels, PDO::PARAM_STR);
        $sth->bindParam(':achternaam', $this->achternaam, PDO::PARAM_STR);
        $sth->bindParam(':login', $this->login, PDO::PARAM_STR);
        $sth->bindParam(':wachtwoord', $this->wachtwoord, PDO::PARAM_STR);
        $sth->bindParam(':idrechten', $this->idrechten, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * @param $idgebruiker
     * @param $login
     * @param $naam
     * @param $tussenvoegsels
     * @param $achternaam
     * @return bool
     */
    public function updatePersoonsgegevens($idgebruiker, $login, $naam, $tussenvoegsels, $achternaam) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE gebruiker SET login = :login, naam = :naam, tussenvoegsels = :tussenvoegsels, achternaam = :achternaam WHERE idgebruiker = :idgebruiker';
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker', $idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        $sth->bindParam(':naam', $naam, PDO::PARAM_STR);
        $sth->bindParam(':tussenvoegsels', $tussenvoegsels, PDO::PARAM_STR);
        $sth->bindParam(':achternaam', $achternaam, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * @param $idgebruiker
     * @param $wachtwoord
     * @return bool
     */
    public function updateWachtwoord($idgebruiker, $wachtwoord) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE gebruiker SET wachtwoord = :wachtwoord WHERE idgebruiker = :idgebruiker';
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker', $idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':wachtwoord', $wachtwoord, PDO::PARAM_STR);
        return $sth->execute();
    }

    /**
     * @param $idgebruiker
     * @param $idrechten
     * @return bool
     */
    public function updateRechten($idgebruiker, $idrechten) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = 'UPDATE gebruiker SET idrechten = :idrechten WHERE idgebruiker = :idgebruiker';
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker', $idgebruiker, PDO::PARAM_INT);
        $sth->bindParam(':idrechten', $idrechten, PDO::PARAM_INT);
        return $sth->execute();
    }

    /**
     * @return bool
     */
    public function deleteGebruiker() {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "DELETE FROM gebruiker WHERE idgebruiker = :idgebruiker";
        $sth = $conn->prepare($query);
        $sth->bindParam(':idgebruiker', $_GET['delete']);
        return $sth->execute();
    }

    /**
     * @return array
     */
    public function getGebruikers() {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM gebruiker");
        $sth->execute();
        return $sth->fetchAll(PDO::FETCH_CLASS, 'Gebruiker');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getGebruikerById($id) {
        $db = new Db();
        $conn = $db->getConnectie();
        $sth = $conn->prepare("SELECT * FROM gebruiker WHERE idgebruiker = :id");
        $sth->bindParam(':id', $id, PDO::PARAM_INT);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        return $sth->fetch();
    }

    /**
     * @return string
     */
    public function getVolledigeNaam() {
        return $this->naam . " " . $this->tussenvoegsels . " " . $this->achternaam;
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
    public function getNaam() {
        return $this->naam;
    }

    /**
     * @param mixed $naam
     */
    public function setNaam($naam): void {
        $this->naam = $naam;
    }

    /**
     * @return mixed
     */
    public function getTussenvoegsels() {
        return $this->tussenvoegsels;
    }

    /**
     * @param mixed $tussenvoegsels
     */
    public function setTussenvoegsels($tussenvoegsels): void {
        $this->tussenvoegsels = $tussenvoegsels;
    }

    /**
     * @return mixed
     */
    public function getAchternaam() {
        return $this->achternaam;
    }

    /**
     * @param mixed $achternaam
     */
    public function setAchternaam($achternaam): void {
        $this->achternaam = $achternaam;
    }

    /**
     * @return mixed
     */
    public function getLogin() {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getWachtwoord() {
        return $this->wachtwoord;
    }

    /**
     * @param mixed $wachtwoord
     */
    public function setWachtwoord($wachtwoord): void {
        $this->wachtwoord = $wachtwoord;
    }

    /**
     * @return mixed
     */
    public function getIdRechten() {
        return $this->idrechten;
    }

    /**
     * @param $idrechten
     */
    public function setIdRechten($idrechten): void {
        $this->idrechten = $idrechten;
    }

    /**
     * @return mixed
     */
    public function getAvatar() {
        return $this->avatar;
    }

    /**
     * @param mixed $avatar
     */
    public function setAvatar($avatar): void {
        $this->avatar = $avatar;
    }
}