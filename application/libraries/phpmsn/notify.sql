CREATE TABLE `msn_notify` (
  `msn_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `msn_datetime` CHAR(14) NOT NULL,
  `msn_to` VARCHAR(256) NOT NULL,
  `msn_msg` VARCHAR(512) NOT NULL,
  `msn_from` VARCHAR(45) NOT NULL,
  `msn_tm` TIMESTAMP NOT NULL,
  PRIMARY KEY (`msn_id`),
  INDEX `msn_index_1`(`msn_datetime`)
)
ENGINE = MyISAM;
