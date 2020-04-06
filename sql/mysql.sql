CREATE TABLE `yogurt_friendship` (
  `friendship_id` INT(11)    NOT NULL AUTO_INCREMENT,
  `friend1_uid`   INT(11)    NOT NULL,
  `friend2_uid`   INT(11)    NOT NULL,
  `level`         INT(11)    NOT NULL,
  `hot`           TINYINT(4) NOT NULL,
  `trust`         TINYINT(4) NOT NULL,
  `cool`          TINYINT(4) NOT NULL,
  `fan`           TINYINT(4) NOT NULL,
  PRIMARY KEY (`friendship_id`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_images` (
  `cod_img`       INT(11)      NOT NULL AUTO_INCREMENT,
  `title`         VARCHAR(255) NOT NULL,
  `data_creation` DATE         NOT NULL,
  `data_update`   DATE         NOT NULL,
  `uid_owner`     VARCHAR(50)  NOT NULL,
  `url`           TEXT         NOT NULL,
  `private`       VARCHAR(1)   NOT NULL,
  PRIMARY KEY (`cod_img`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_visitors` (
  `cod_visit`     INT(11)     NOT NULL AUTO_INCREMENT,
  `uid_owner`     INT(11)     NOT NULL,
  `uid_visitor`   INT(11)     NOT NULL,
  `uname_visitor` VARCHAR(30) NOT NULL,
  `datetime`      TIMESTAMP   NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`cod_visit`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_video` (
  `video_id`     INT(11)     NOT NULL AUTO_INCREMENT,
  `uid_owner`    INT(11)     NOT NULL,
  `video_desc`   TEXT        NOT NULL,
  `youtube_code` VARCHAR(11) NOT NULL,
  `main_video`   VARCHAR(1)  NOT NULL,
  PRIMARY KEY (`video_id`)
)
  ENGINE = MyISAM;
CREATE TABLE `yogurt_friendpetition` (
  `friendpet_id`   INT(11) NOT NULL AUTO_INCREMENT,
  `petitioner_uid` INT(11) NOT NULL,
  `petioned_uid`   INT(11) NOT NULL,
  PRIMARY KEY (`friendpet_id`)
)
  ENGINE = MyISAM;


CREATE TABLE `yogurt_relgroupuser` (
  `rel_id`       INT(11) NOT NULL AUTO_INCREMENT,
  `rel_group_id` INT(11) NOT NULL,
  `rel_user_uid` INT(11) NOT NULL,
  PRIMARY KEY (`rel_id`)
)
  ENGINE = MyISAM;


CREATE TABLE `yogurt_groups` (
  `group_id`    INT(11)      NOT NULL AUTO_INCREMENT,
  `owner_uid`   INT(11)      NOT NULL,
  `group_title` VARCHAR(255) NOT NULL,
  `group_desc`  TINYTEXT     NOT NULL,
  `group_img`   VARCHAR(255) NOT NULL,
  PRIMARY KEY (`group_id`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_notes` (
  `note_id`   INT(11)    NOT NULL AUTO_INCREMENT,
  `note_text` TEXT       NOT NULL,
  `note_from` INT(11)    NOT NULL,
  `note_to`   INT(11)    NOT NULL,
  `private`   TINYINT(1) NOT NULL,
  `date`      TIMESTAMP  NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`note_id`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_configs` (
  `config_id`       INT(11)      NOT NULL AUTO_INCREMENT,
  `config_uid`      INT(11)      NOT NULL,
  `pictures`        TINYINT(1)   NOT NULL,
  `audio`           TINYINT(1)   NOT NULL,
  `videos`          TINYINT(1)   NOT NULL,
  `groups`          TINYINT(1)   NOT NULL,
  `notes`           TINYINT(1)   NOT NULL,
  `friends`         TINYINT(1)   NOT NULL,
  `profile_contact` TINYINT(1)   NOT NULL,
  `profile_general` TINYINT(1)   NOT NULL,
  `profile_stats`   TINYINT(1)   NOT NULL,
  `suspension`      TINYINT(1)   NOT NULL,
  `backup_password` VARCHAR(255) NOT NULL,
  `backup_email`    VARCHAR(255) NOT NULL,
  `end_suspension`  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`config_id`),
  KEY `config_uid` (`config_uid`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_suspensions` (
  `uid` INT (11)     NOT NULL  AUTO_INCREMENT,
  `old_pass`         VARCHAR(255) NOT NULL,
  `old_email`        VARCHAR(100) NOT NULL,
  `old_signature`    TEXT         NOT NULL,
  `suspension_time`  INT(11)      NOT NULL,
  `old_enc_type`     INT(2)       NOT NULL DEFAULT 0,
  `old_pass_expired` INT(1)       NOT NULL DEFAULT 0,
  PRIMARY KEY (`uid`)
)
  ENGINE = MyISAM;

CREATE TABLE `yogurt_audio` (
  `audio_id`      INT(11)      NOT NULL AUTO_INCREMENT,
  `title`         VARCHAR(256) NOT NULL,
  `author`        VARCHAR(256) NOT NULL,
  `url`           VARCHAR(256) NOT NULL,
  `uid_owner`     INT(11)      NOT NULL,
  `data_creation` DATE         NOT NULL,
  `data_update`   DATE         NOT NULL,
  PRIMARY KEY (`audio_id`)
)
  ENGINE = MyISAM;
