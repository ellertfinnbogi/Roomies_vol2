CREATE TABLE IF NOT EXISTS `roomies`.`todo` (
  `room` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT 'name for the room',
  `todo` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'todo assignment',
  `isdone` boolean  NOT NULL DEFAULT '0' COMMENT 'user''s password in salted and hashed format',
  `user_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  'date_created' DATETIME2 (7) DEFAULT (getdate()) NOT NULL,
  'date_deadline' DATETIME2 (7) COMMENT 'date when assignment is due',
  'who_responsible' varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT 'user''s name, unique',
  PRIMARY KEY (`room`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='user data';