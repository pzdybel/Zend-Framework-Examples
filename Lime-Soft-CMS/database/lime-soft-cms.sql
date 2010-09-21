SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `LimeSoftCMS` ;
CREATE SCHEMA IF NOT EXISTS `LimeSoftCMS` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `LimeSoftCMS` ;

-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`AclRoles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`AclRoles` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`AclRoles` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idParent` INT NULL ,
  `name` VARCHAR(16) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `UNIQUE_name` (`name` ASC) ,
  INDEX `FK_AclRoles_self` (`idParent` ASC) ,
  CONSTRAINT `FK_AclRoles_self`
    FOREIGN KEY (`idParent` )
    REFERENCES `LimeSoftCMS`.`AclRoles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`Users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`Users` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`Users` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(32) NOT NULL ,
  `fullName` VARCHAR(256) NULL ,
  `password` VARCHAR(256) NOT NULL ,
  `email` VARCHAR(254) NOT NULL ,
  `role` VARCHAR(16) NOT NULL ,
  `dateCreated` DATETIME NOT NULL ,
  `dateConfirmed` DATETIME NULL ,
  `dateLastLogin` DATETIME NULL ,
  `banned` TINYINT(1)  NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `UNIQUE_name` (`name` ASC) ,
  INDEX `FK_Users_AclRoles` (`role` ASC) ,
  CONSTRAINT `FK_Users_AclRoles`
    FOREIGN KEY (`role` )
    REFERENCES `LimeSoftCMS`.`AclRoles` (`name` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`Session`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`Session` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`Session` (
  `name` VARCHAR(32) NOT NULL ,
  `path` VARCHAR(32) NOT NULL ,
  `id` VARCHAR(32) NOT NULL ,
  `ip` VARCHAR(39) NOT NULL ,
  `username` VARCHAR(32) NULL ,
  `useragent` TEXT NOT NULL ,
  `modified` INT NOT NULL ,
  `lifetime` INT NOT NULL ,
  `data` TEXT NULL ,
  PRIMARY KEY (`modified`, `name`, `path`, `id`) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`Log`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`Log` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`Log` (
  `date` DATETIME NOT NULL ,
  `ip` VARCHAR(39) NOT NULL ,
  `username` VARCHAR(32) NULL ,
  `useragent` TEXT NOT NULL ,
  `url` VARCHAR(256) NOT NULL ,
  `priority` INT NOT NULL ,
  `message` TEXT NOT NULL ,
  INDEX `INDEX` (`date` ASC) )
ENGINE = MyISAM;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`AclResources`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`AclResources` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`AclResources` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `idParent` INT NULL ,
  `name` VARCHAR(200) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `UNIQUE_name` (`name` ASC) ,
  INDEX `FK_AclResources_self` (`idParent` ASC) ,
  CONSTRAINT `FK_AclResources_self`
    FOREIGN KEY (`idParent` )
    REFERENCES `LimeSoftCMS`.`AclResources` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`AclPrivilegeDict`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`AclPrivilegeDict` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`AclPrivilegeDict` (
  `name` VARCHAR(8) NOT NULL ,
  PRIMARY KEY (`name`) ,
  UNIQUE INDEX `UNIQUE_name` (`name` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `LimeSoftCMS`.`AclPermissions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `LimeSoftCMS`.`AclPermissions` ;

CREATE  TABLE IF NOT EXISTS `LimeSoftCMS`.`AclPermissions` (
  `idRole` INT NOT NULL ,
  `idResource` INT NOT NULL ,
  `privilege` VARCHAR(8) NOT NULL ,
  `access` VARCHAR(8) NOT NULL ,
  PRIMARY KEY (`idRole`, `idResource`, `privilege`) ,
  INDEX `FK_AclPermissions_AclRoles` (`idRole` ASC) ,
  INDEX `FK_AclPermissions_AclResources` (`idResource` ASC) ,
  INDEX `FK_AclPermissions_AclPrivilegeDict` (`privilege` ASC) ,
  CONSTRAINT `FK_AclPermissions_AclRoles`
    FOREIGN KEY (`idRole` )
    REFERENCES `LimeSoftCMS`.`AclRoles` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AclPermissions_AclResources`
    FOREIGN KEY (`idResource` )
    REFERENCES `LimeSoftCMS`.`AclResources` (`id` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `FK_AclPermissions_AclPermissionDict`
    FOREIGN KEY (`privilege` )
    REFERENCES `LimeSoftCMS`.`AclPrivilegeDict` (`name` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Placeholder table for view `LimeSoftCMS`.`AclPermissionView`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `LimeSoftCMS`.`AclPermissionView` (`roleId` INT, `roleName` INT, `resourceId` INT, `resourceName` INT, `privilege` INT, `access` INT);

-- -----------------------------------------------------
-- View `LimeSoftCMS`.`AclPermissionView`
-- -----------------------------------------------------
DROP VIEW IF EXISTS `LimeSoftCMS`.`AclPermissionView` ;
DROP TABLE IF EXISTS `LimeSoftCMS`.`AclPermissionView`;
create  OR REPLACE view `LimeSoftCMS`.`AclPermissionView` as
select
    roles.id as roleId,
    roles.name as roleName,
    res.id as resourceId,
    res.name as resourceName,
    perm.privilege,
    perm.access
from AclRoles roles, AclResources res, AclPermissions perm
where
    roles.id = perm.idRole and
    perm.idResource = res.id
;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
