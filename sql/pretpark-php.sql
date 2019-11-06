-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema pretpark-php
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `pretpark-php` ;

-- -----------------------------------------------------
-- Schema pretpark-php
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `pretpark-php` DEFAULT CHARACTER SET utf8 ;
USE `pretpark-php` ;

-- -----------------------------------------------------
-- Table `pretpark-php`.`rechten`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`rechten` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`rechten` (
  `idrechten` INT NOT NULL AUTO_INCREMENT,
  `rechtenomschrijving` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idrechten`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`gebruiker`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`gebruiker` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`gebruiker` (
  `idgebruiker` INT NOT NULL AUTO_INCREMENT,
  `idrechten` INT NOT NULL,
  `naam` VARCHAR(45) NOT NULL,
  `tussenvoegsels` VARCHAR(45) NULL,
  `achternaam` VARCHAR(45) NOT NULL,
  `login` VARCHAR(45) NOT NULL,
  `wachtwoord` VARCHAR(45) NOT NULL,
  `avatar` LONGTEXT NULL,
  PRIMARY KEY (`idgebruiker`, `idrechten`),
  INDEX `gebruiker_rechten_idx` (`idrechten` ASC),
  CONSTRAINT `gebruiker_rechten`
    FOREIGN KEY (`idrechten`)
    REFERENCES `pretpark-php`.`rechten` (`idrechten`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`attractie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`attractie` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`attractie` (
  `idattractie` INT NOT NULL AUTO_INCREMENT,
  `idgebruiker` INT NOT NULL,
  `titel` VARCHAR(45) NOT NULL,
  `omschrijving` VARCHAR(250) NOT NULL,
  `urlfoto` LONGTEXT NULL,
  PRIMARY KEY (`idattractie`, `idgebruiker`),
  INDEX `attractie_gebruiker_idx` (`idgebruiker` ASC),
  CONSTRAINT `attractie_gebruiker`
    FOREIGN KEY (`idgebruiker`)
    REFERENCES `pretpark-php`.`gebruiker` (`idgebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`product`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`product` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`product` (
  `idproduct` INT NOT NULL AUTO_INCREMENT,
  `idgebruiker` INT NOT NULL,
  `titel` VARCHAR(45) NOT NULL,
  `productomschrijving` VARCHAR(45) NOT NULL,
  `voorraad` INT NOT NULL,
  `prijs` FLOAT NOT NULL,
  `urlfoto` LONGTEXT NULL,
  PRIMARY KEY (`idproduct`, `idgebruiker`),
  INDEX `product_gebruiker_idx` (`idgebruiker` ASC),
  CONSTRAINT `product_gebruiker`
    FOREIGN KEY (`idgebruiker`)
    REFERENCES `pretpark-php`.`gebruiker` (`idgebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`reactie`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`reactie` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`reactie` (
  `idreactie` INT NOT NULL AUTO_INCREMENT,
  `idgebruiker` INT NOT NULL,
  `idattractie` INT NOT NULL,
  `reactietekst` VARCHAR(200) NOT NULL,
  PRIMARY KEY (`idreactie`, `idgebruiker`, `idattractie`),
  INDEX `attractie_reactie_idx` (`idattractie` ASC),
  INDEX `attractie_gebruiker_idx` (`idgebruiker` ASC),
  CONSTRAINT `reactie_attractie`
    FOREIGN KEY (`idattractie`)
    REFERENCES `pretpark-php`.`attractie` (`idattractie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `reactie_gebruiker`
    FOREIGN KEY (`idgebruiker`)
    REFERENCES `pretpark-php`.`gebruiker` (`idgebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`saldo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`saldo` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`saldo` (
  `idsaldo` INT NOT NULL AUTO_INCREMENT,
  `saldo` FLOAT NOT NULL,
  PRIMARY KEY (`idsaldo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pretpark-php`.`winkelwagen`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `pretpark-php`.`winkelwagen` ;

CREATE TABLE IF NOT EXISTS `pretpark-php`.`winkelwagen` (
  `idwinkelwagen` INT NOT NULL AUTO_INCREMENT,
  `idgebruiker` INT NOT NULL,
  `idproduct` INT NOT NULL,
  `aantal` INT NOT NULL,
  PRIMARY KEY (`idwinkelwagen`, `idgebruiker`, `idproduct`),
  INDEX `winkelwagen_gebruiker_idx` (`idgebruiker` ASC),
  INDEX `winkelwagen_product_idx` (`idproduct` ASC),
  CONSTRAINT `winkelwagen_gebruiker`
    FOREIGN KEY (`idgebruiker`)
    REFERENCES `pretpark-php`.`gebruiker` (`idgebruiker`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `winkelwagen_product`
    FOREIGN KEY (`idproduct`)
    REFERENCES `pretpark-php`.`product` (`idproduct`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `pretpark-php`.`rechten`
-- -----------------------------------------------------
START TRANSACTION;
USE `pretpark-php`;
INSERT INTO `pretpark-php`.`rechten` (`idrechten`, `rechtenomschrijving`) VALUES (1, 'Beheerder');
INSERT INTO `pretpark-php`.`rechten` (`idrechten`, `rechtenomschrijving`) VALUES (2, 'Gebruiker');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pretpark-php`.`gebruiker`
-- -----------------------------------------------------
START TRANSACTION;
USE `pretpark-php`;
INSERT INTO `pretpark-php`.`gebruiker` (`idgebruiker`, `idrechten`, `naam`, `tussenvoegsels`, `achternaam`, `login`, `wachtwoord`, `avatar`) VALUES (1, 1, 'Thom', NULL, 'Kok', 'thomkok13@hotmail.com', '$2y$10$z5y85DeakwItk7enN57ysOWz93j8vGkeKBbHlGnU242iRCJ7fMNk.', 'thomkok21.png');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pretpark-php`.`attractie`
-- -----------------------------------------------------
START TRANSACTION;
USE `pretpark-php`;
INSERT INTO `pretpark-php`.`attractie` (`idattractie`, `idgebruiker`, `titel`, `omschrijving`, `urlfoto`) VALUES (1, 1, 'Achtbaan', 'Dit is een achtbaan!', 'img/Achtbaan.png');
INSERT INTO `pretpark-php`.`attractie` (`idattractie`, `idgebruiker`, `titel`, `omschrijving`, `urlfoto`) VALUES (2, 1, 'Ghostship', 'Dit is een schip!', 'img/Ghostship.png');
INSERT INTO `pretpark-php`.`attractie` (`idattractie`, `idgebruiker`, `titel`, `omschrijving`, `urlfoto`) VALUES (3, 1, 'Locomotief', 'Dit is een locomotief!', 'img/Locomotief.png');
INSERT INTO `pretpark-php`.`attractie` (`idattractie`, `idgebruiker`, `titel`, `omschrijving`, `urlfoto`) VALUES (4, 1, 'Reuzenrad', 'Dit is een reuzenrad!', 'img/Reuzenrad.png');
INSERT INTO `pretpark-php`.`attractie` (`idattractie`, `idgebruiker`, `titel`, `omschrijving`, `urlfoto`) VALUES (5, 1, 'Zweefmolen', 'Dit is een zweefmolen!', 'img/Zweefmolen.png');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pretpark-php`.`product`
-- -----------------------------------------------------
START TRANSACTION;
USE `pretpark-php`;
INSERT INTO `pretpark-php`.`product` (`idproduct`, `idgebruiker`, `titel`, `productomschrijving`, `voorraad`, `prijs`, `urlfoto`) VALUES (1, 1, 'Ticket', 'Hiermee krijg je toegang tot het pretpark.', 50, 5.50, 'Ticket.png');
INSERT INTO `pretpark-php`.`product` (`idproduct`, `idgebruiker`, `titel`, `productomschrijving`, `voorraad`, `prijs`, `urlfoto`) VALUES (2, 1, 'VIP-Ticket', 'Hiermee krijg je voorrang in de rijen in het pretpark.', 50, 12.50, 'VIP-Ticket.png');

COMMIT;


-- -----------------------------------------------------
-- Data for table `pretpark-php`.`saldo`
-- -----------------------------------------------------
START TRANSACTION;
USE `pretpark-php`;
INSERT INTO `pretpark-php`.`saldo` (`idsaldo`, `saldo`) VALUES (1, 50000);

COMMIT;

