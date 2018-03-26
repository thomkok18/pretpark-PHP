<?php
include_once('lib/Db.php');

class Gebruiker {
    private $idgebruiker;
    private $naam;
    private $tussenvoegsels;
    private $achternaam;
    private $login;
    private $wachtwoord;
    private $rechten = 'Bezoeker';

    /**
     * Beheerder constructor.
     */
    public function __construct() {
    }

    public function checkLogin($orgWachtwoord, $login) {
        $db = new Db();
        $conn = $db->getConnectie();
        $query = "SELECT * FROM gebruiker WHERE login = :login";
        $sth = $conn->prepare($query);
        $sth->bindParam(':login', $login, PDO::PARAM_STR);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_CLASS, 'Gebruiker');
        $gebruiker = $sth->fetch();
        if ($gebruiker && password_verify($orgWachtwoord, $gebruiker->getWachtwoord())) {
            $_SESSION['login'] = array (
                "volledige naam" => $gebruiker->getVolledigeNaam(),
                "idgebruiker" => $gebruiker->getIdgebruiker()
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
        $query = "INSERT INTO gebruiker (naam, tussenvoegsels, achternaam, login, wachtwoord, rechten) "
            ."VALUES(:naam, :tussenvoegsels, :achternaam, :login, :wachtwoord, :rechten)";
        $sth = $conn->prepare($query);
        $sth->bindParam(':naam', $this->naam, PDO::PARAM_STR);
        $sth->bindParam(':tussenvoegsels', $this->tussenvoegsels, PDO::PARAM_STR);
        $sth->bindParam(':achternaam', $this->achternaam, PDO::PARAM_STR);
        $sth->bindParam(':login', $this->login, PDO::PARAM_STR);
        $sth->bindParam(':wachtwoord', $this->wachtwoord, PDO::PARAM_STR);
        $sth->bindParam(':rechten', $this->rechten, PDO::PARAM_STR);
        return $sth->execute();
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
    public function getRechten() {
        return $this->rechten;
    }

    /**
     * @param $rechten
     */
    public function setRechten($rechten): void {
        $this->rechten = $rechten;
    }
}