CREATE TABLE `yogurt_images` (
    `cod_img`       INT(11)      NOT NULL AUTO_INCREMENT,
    `title`         VARCHAR(255) NOT NULL,
    `caption`       VARCHAR(255) NOT NULL,
    `date_created` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `date_updated` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `uid_owner`     VARCHAR(50)  NOT NULL,
    `url`          VARCHAR(50)      NOT NULL,
    `private`       TINYINT(1)   NOT NULL,
    PRIMARY KEY (`cod_img`)
)
    ENGINE = MyISAM;
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

CREATE TABLE `yogurt_visitors` (
    `cod_visit`     INT(11)     NOT NULL AUTO_INCREMENT,
    `uid_owner`     INT(11)     NOT NULL,
    `uid_visitor`   INT(11)     NOT NULL,
    `uname_visitor` VARCHAR(30) NOT NULL,
    `date_visited`  INT(11) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`cod_visit`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_video` (
    `video_id`     INT(11)     NOT NULL AUTO_INCREMENT,
    `uid_owner`    INT(11)     NOT NULL,
    `video_desc`   TEXT        NOT NULL,
    `youtube_code` VARCHAR(11) NOT NULL,
    `main_video`   TINYINT(1)       NOT NULL DEFAULT 0,
    `date_created` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    `date_updated` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`video_id`)
)
    ENGINE = MyISAM;
CREATE TABLE `yogurt_friendrequest` (
    `friendpet_id`   INT(11) NOT NULL AUTO_INCREMENT,
    `friendrequester_uid` INT(11) NOT NULL,
    `friendrequestto_uid` INT(11) NOT NULL,
    `date_created`        INT(11) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`friendpet_id`)
)
    ENGINE = MyISAM;



CREATE TABLE `yogurt_groups` (
    `group_id`    INT(11)      NOT NULL AUTO_INCREMENT,
    `owner_uid`   INT(11)      NOT NULL,
    `group_title` VARCHAR(255) NOT NULL,
    `group_desc`  TINYTEXT     NOT NULL,
    `group_img`   VARCHAR(255) NOT NULL,
    `date_created` INT(11)      NOT NULL,
    `date_updated` INT(11)      NOT NULL,
    PRIMARY KEY (`group_id`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_relgroupuser` (
    `rel_id`       INT(11) NOT NULL AUTO_INCREMENT,
    `rel_group_id` INT(11) NOT NULL,
    `rel_user_uid` INT(11) NOT NULL,
    PRIMARY KEY (`rel_id`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_notes` (
    `note_id`   INT(11)    NOT NULL AUTO_INCREMENT,
    `note_text` TEXT       NOT NULL,
    `note_from` INT(11)    NOT NULL,
    `note_to`   INT(11)    NOT NULL,
    `private`   TINYINT(1) NOT NULL,
    `date_created` INT(11) UNSIGNED NOT NULL DEFAULT 0,
    PRIMARY KEY (`note_id`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_configs` (
    `config_id`       INT(11)      NOT NULL AUTO_INCREMENT,
    `config_uid`      INT(11)      NOT NULL,
    `pictures`        INT(8)       NOT NULL DEFAULT 0,
    `audio`           INT(8)       NOT NULL DEFAULT 0,
    `videos`          INT(8)       NOT NULL DEFAULT 0,
    `groups`          INT(8)       NOT NULL DEFAULT 0,
    `notes`           INT(8)       NOT NULL DEFAULT 0,
    `friends`         INT(8)       NOT NULL DEFAULT 0,
    `profile_contact` INT(8)       NOT NULL DEFAULT 0,
    `profile_general` INT(8)       NOT NULL DEFAULT 0,
    `profile_stats`   INT(8)       NOT NULL DEFAULT 0,
    `suspension`      TINYINT(1)   NOT NULL,
    `backup_password` VARCHAR(255) NOT NULL,
    `backup_email`    VARCHAR(255) NOT NULL,
    `end_suspension`  INT(11)      NOT NULL DEFAULT 0,
    PRIMARY KEY (`config_id`),
    KEY `config_uid` (`config_uid`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_suspensions` (
    `uid`              INT(11)      NOT NULL AUTO_INCREMENT,
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
    `title`         VARCHAR(100) NOT NULL,
    `author`        VARCHAR(100) NOT NULL,
    `description`  TEXT             NOT NULL,
    `url`           VARCHAR(50) NOT NULL,
    `uid_owner`     INT(11)      NOT NULL,
    `date_created` INT(11)      NOT NULL DEFAULT 0,
    `date_updated`   INT(11)      NOT NULL DEFAULT 0,
    PRIMARY KEY (`audio_id`)
)
    ENGINE = MyISAM;


CREATE TABLE `yogurt_privacy` (
    `id`          INT(8)      NOT NULL AUTO_INCREMENT,
    `level`       INT(8)      NOT NULL,
    `name`        VARCHAR(20) NOT NULL,
    `description` TEXT        NOT NULL,
    PRIMARY KEY (`id`)
)
    ENGINE = MyISAM;

CREATE TABLE `yogurt_profile_category` (
  `cat_id`          smallint(5) unsigned    NOT NULL auto_increment,
  `cat_title`       varchar(255)            NOT NULL default '',
  `cat_description` text,
  `cat_weight`      smallint(5) unsigned    NOT NULL default '0',
  
  PRIMARY KEY  (`cat_id`)
) ENGINE=MyISAM;

CREATE TABLE `yogurt_profile_field` (
  `field_id`            int(12) unsigned        NOT NULL auto_increment,
  `cat_id`              smallint(5) unsigned    NOT NULL default '0',
  `field_type`          varchar(30)             NOT NULL default '',
  `field_valuetype`     tinyint(2) unsigned     NOT NULL default '0',
  `field_name`          varchar(255)            NOT NULL default '',
  `field_title`         varchar(255)            NOT NULL default '',
  `field_description`   text,
  `field_required`      tinyint(1) unsigned     NOT NULL default '0',
  `field_maxlength`     smallint(6) unsigned    NOT NULL default '0',
  `field_weight`        smallint(6) unsigned    NOT NULL default '0',
  `field_default`       text,
  `field_notnull`       tinyint(1) unsigned     NOT NULL default '0',
  `field_edit`          tinyint(1) unsigned     NOT NULL default '0',
  `field_show`          tinyint(1) unsigned     NOT NULL default '0',
  `field_config`        tinyint(1) unsigned     NOT NULL default '0',
  `field_options`       text,
  `step_id`             smallint(3) unsigned    NOT NULL default '0',
  
  PRIMARY KEY  (`field_id`),
  UNIQUE KEY `field_name` (`field_name`),
  KEY `step` (`step_id`, `field_weight`)
) ENGINE=MyISAM;

CREATE TABLE `yogurt_profile_visibility` (
  `field_id`        int(12) unsigned        NOT NULL default '0',
  `user_group`      smallint(5) unsigned    NOT NULL default '0',
  `profile_group`   smallint(5) unsigned    NOT NULL default '0',
  
  PRIMARY KEY (`field_id`, `user_group`, `profile_group`),
  KEY `visible` (`user_group`, `profile_group`)
) ENGINE=MyISAM;

CREATE TABLE `yogurt_profile_regstep` (
  `step_id`         smallint(3) unsigned    NOT NULL auto_increment,
  `step_name`       varchar(255)            NOT NULL DEFAULT '',
  `step_desc`       text,
  `step_order`      smallint(3) unsigned    NOT NULL default '0',
  `step_save`       tinyint(1) unsigned     NOT NULL default '0',
  
  PRIMARY KEY (`step_id`),
  KEY `sort` (`step_order`, `step_name`)
) ENGINE=MyISAM;

CREATE TABLE `yogurt_profile` (
  `profile_id`      int(12) unsigned        NOT NULL default '0',
  
  PRIMARY KEY  (`profile_id`)
) ENGINE=MyISAM;