ALTER TABLE `evaluation`
  DROP `replay_admin`,
  DROP `replay_date`,
  DROP `replay_content`;
ALTER TABLE `evaluation` ADD `reply_admin` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL AFTER `email`, ADD `reply_date` DATE NULL DEFAULT NULL AFTER `reply_admin`, ADD `reply_content` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_spanish_ci NULL DEFAULT NULL AFTER `reply_date`;