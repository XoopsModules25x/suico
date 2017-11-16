CREATE TABLE `yogurt_friendpetition` (
  `friendpet_id` int(11) NOT NULL auto_increment,
  `petitioner_uid` int(11) NOT NULL,
  `petioned_uid` int(11) NOT NULL,
  PRIMARY KEY  (`friendpet_id`)
) TYPE=MyISAM;


CREATE TABLE `yogurt_friendship` (
  `friendship_id` int(11) NOT NULL auto_increment,
  `friend1_uid` int(11) NOT NULL,
  `friend2_uid` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `hot` tinyint(4) NOT NULL,
  `trust` tinyint(4) NOT NULL,
  `cool` tinyint(4) NOT NULL,
  `fan` tinyint(4) NOT NULL,
  PRIMARY KEY  (`friendship_id`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_images` (
  `cod_img` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `data_creation` date NOT NULL,
  `data_update` date NOT NULL,
  `uid_owner` varchar(50) NOT NULL,
  `url` text NOT NULL,
  `private` varchar(1) NOT NULL,
  PRIMARY KEY  (`cod_img`)
) TYPE=MyISAM  ;

CREATE TABLE `yogurt_visitors` (
  `cod_visit` int(11) NOT NULL auto_increment,
  `uid_owner` int(11) NOT NULL,
  `uid_visitor` int(11) NOT NULL,
  `uname_visitor` varchar(30) NOT NULL,
`datetime` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`cod_visit`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_seutubo` (
  `video_id` int(11) NOT NULL auto_increment,
  `uid_owner` int(11) NOT NULL,
  `video_desc` text NOT NULL,
  `youtube_code` varchar(11) NOT NULL,
  `main_video` varchar(1) NOT NULL,
  PRIMARY KEY  (`video_id`)
) TYPE=MyISAM;


CREATE TABLE `yogurt_reltribeuser` (
  `rel_id` int(11) NOT NULL auto_increment,
  `rel_tribe_id` int(11) NOT NULL,
  `rel_user_uid` int(11) NOT NULL,
  PRIMARY KEY  (`rel_id`)
) TYPE=MyISAM;


CREATE TABLE `yogurt_tribes` (
  `tribe_id` int(11) NOT NULL auto_increment,
  `owner_uid` int(11) NOT NULL,
  `tribe_title` varchar(255) NOT NULL,
  `tribe_desc` tinytext NOT NULL,
  `tribe_img` varchar(255) NOT NULL,

  PRIMARY KEY  (`tribe_id`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_scraps` (
  `scrap_id` int(11) NOT NULL auto_increment,
  `scrap_text` text NOT NULL,
  `scrap_from` int(11) NOT NULL,
  `scrap_to` int(11) NOT NULL,
  `private` tinyint(1) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`scrap_id`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_configs` (
  `config_id` int(11) NOT NULL auto_increment,
  `config_uid` int(11) NOT NULL,
  `pictures` tinyint(1) NOT NULL,
  `audio` tinyint(1) NOT NULL,
  `videos` tinyint(1) NOT NULL,
  `tribes` tinyint(1) NOT NULL,
  `scraps` tinyint(1) NOT NULL,
  `friends` tinyint(1) NOT NULL,
  `profile_contact` tinyint(1) NOT NULL,
  `profile_general` tinyint(1) NOT NULL,
  `profile_stats` tinyint(1) NOT NULL,
  `suspension` tinyint(1) NOT NULL,
  `backup_password` varchar(255) NOT NULL,
  `backup_email` varchar(255) NOT NULL,
  `end_suspension` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`config_id`),
  KEY `config_uid` (`config_uid`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_suspensions` (
  `uid` int(11) NOT NULL,
  `old_pass` varchar(255) NOT NULL,
  `old_email` varchar(100) NOT NULL,
  `old_signature` text NOT NULL,
  `suspension_time` int(11) NOT NULL,
  `old_enc_type` int(2) NOT NULL,
  `old_pass_expired` int(1) NOT NULL,
  PRIMARY KEY  (`uid`)
) TYPE=MyISAM;

CREATE TABLE `yogurt_audio` (
  `audio_id` int(11) NOT NULL auto_increment,
  `title` varchar(256) NOT NULL,
  `author` varchar(256) NOT NULL,
  `url` varchar(256) NOT NULL,
  `uid_owner` int(11) NOT NULL,
  `data_creation` date NOT NULL,
  `data_update` date NOT NULL,
  PRIMARY KEY  (`audio_id`)
) TYPE=MyISAM;