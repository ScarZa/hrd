ALTER TABLE `training_out` CHANGE `memberbook` `memberbook` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;
ALTER TABLE `training_out` ADD `approver` INT(7) NULL AFTER `hboss`;
update `training_out` set hboss='Y';
update `training_out` set chek='1';