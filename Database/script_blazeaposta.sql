-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema blazeaposta
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blazeaposta
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blazeaposta` DEFAULT CHARACTER SET utf8 ;
USE `blazeaposta` ;

-- -----------------------------------------------------
-- Table `blazeaposta`.`history`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`history` (
  `his_id` INT NOT NULL AUTO_INCREMENT,
  `his_key_blaze` VARCHAR(45) NOT NULL,
  `his_crash_point` FLOAT NOT NULL,
  `his_created` DATETIME NOT NULL,
  `his_total_bets_placed` INT NULL,
  PRIMARY KEY (`his_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`betting_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`betting_user` (
  `beu_id` INT NOT NULL AUTO_INCREMENT,
  `beu_key_number` INT NULL,
  `beu_key_blaze` VARCHAR(45) NOT NULL,
  `beu_username` VARCHAR(100) NOT NULL,
  `beu_rank` VARCHAR(50) NOT NULL,
  `beu_level` INT NOT NULL,
  PRIMARY KEY (`beu_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`bets_detail`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`bets_detail` (
  `bet_id` INT NOT NULL AUTO_INCREMENT,
  `bet_his_id` INT NOT NULL,
  `bet_beu_id` INT NOT NULL,
  `bet_key_blaze` VARCHAR(45) NOT NULL,
  `bet_cashed_out_at` FLOAT NOT NULL,
  `bet_amount` FLOAT NOT NULL COMMENT 'Quantia',
  `bet_win_amount` FLOAT NOT NULL,
  `bet_status` VARCHAR(45) NULL COMMENT 'win\ncreated',
  PRIMARY KEY (`bet_id`),
  INDEX `fk_detail_history_idx` (`bet_his_id` ASC) VISIBLE,
  INDEX `fk_bets_detail_betting_user1_idx` (`bet_beu_id` ASC) VISIBLE,
  CONSTRAINT `fk_detail_history`
    FOREIGN KEY (`bet_his_id`)
    REFERENCES `blazeaposta`.`history` (`his_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_bets_detail_betting_user1`
    FOREIGN KEY (`bet_beu_id`)
    REFERENCES `blazeaposta`.`betting_user` (`beu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`game_type`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`game_type` (
  `gat_id` INT NOT NULL AUTO_INCREMENT,
  `gat_name` VARCHAR(50) NOT NULL,
  `gat_created` DATETIME NOT NULL,
  PRIMARY KEY (`gat_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`statistics_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`statistics_user` (
  `stu_beu_id` INT NOT NULL,
  `stu_gat_id` INT NOT NULL,
  `stu_total_bets` INT NOT NULL,
  `stu_total_bets_won` INT NOT NULL,
  `stu_total_bets_lost` INT NOT NULL,
  `stu_updated` DATETIME NOT NULL,
  PRIMARY KEY (`stu_beu_id`, `stu_gat_id`),
  INDEX `fk_betting_user_has_game_type_game_type1_idx` (`stu_gat_id` ASC) VISIBLE,
  INDEX `fk_betting_user_has_game_type_betting_user1_idx` (`stu_beu_id` ASC) VISIBLE,
  CONSTRAINT `fk_betting_user_has_game_type_betting_user1`
    FOREIGN KEY (`stu_beu_id`)
    REFERENCES `blazeaposta`.`betting_user` (`beu_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_betting_user_has_game_type_game_type1`
    FOREIGN KEY (`stu_gat_id`)
    REFERENCES `blazeaposta`.`game_type` (`gat_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`state`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`state` (
  `sta_id` INT NOT NULL AUTO_INCREMENT,
  `sta_run` TINYINT NOT NULL COMMENT '0 - desligado\n1 - ligado\n',
  PRIMARY KEY (`sta_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`bot`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`bot` (
  `bot_id` INT NOT NULL AUTO_INCREMENT,
  `bot_token` VARCHAR(200) NOT NULL,
  `bot_key` VARCHAR(70) NULL,
  `bot_name` VARCHAR(100) NULL,
  `bot_username` VARCHAR(100) NULL,
  `bot_active` TINYINT NOT NULL COMMENT '1 - active\n0 - inactive',
  PRIMARY KEY (`bot_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`chat_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`chat_user` (
  `cha_id` INT NOT NULL AUTO_INCREMENT,
  `cha_bot_id` INT NOT NULL,
  `cha_key` VARCHAR(70) NOT NULL,
  `cha_firstname` VARCHAR(100) NULL,
  `cha_lastname` VARCHAR(100) NULL,
  `cha_update_id` VARCHAR(45) NOT NULL,
  `cha_type` INT NOT NULL COMMENT '1 - private\n2 - group\n3 - channel',
  `cha_boot` TINYINT NOT NULL COMMENT '1 - is bot\n0 - is not bot',
  `cha_created` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`cha_id`),
  INDEX `fk_chat_bot1_idx` (`cha_bot_id` ASC) VISIBLE,
  CONSTRAINT `fk_chat_bot1`
    FOREIGN KEY (`cha_bot_id`)
    REFERENCES `blazeaposta`.`bot` (`bot_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blazeaposta`.`message`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blazeaposta`.`message` (
  `mes_id` INT NOT NULL AUTO_INCREMENT,
  `mes_cha_id` INT NOT NULL,
  `mes_text` TEXT NULL,
  `mes_created` TIMESTAMP NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`mes_id`),
  INDEX `fk_message_chat1_idx` (`mes_cha_id` ASC) VISIBLE,
  CONSTRAINT `fk_message_chat1`
    FOREIGN KEY (`mes_cha_id`)
    REFERENCES `blazeaposta`.`chat_user` (`cha_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
