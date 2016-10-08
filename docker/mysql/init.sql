CREATE TABLE `clicks` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `created` DATETIME,
  `trackable_link` VARCHAR(255),
  PRIMARY KEY  (`id`)
);