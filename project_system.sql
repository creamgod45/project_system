CREATE TABLE `project_system`.`member` ( 
`id` INT(255)  NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`name`         VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
`username`     VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
`password` 	   VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL , 
`created_time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`project` ( 
`id`  INT(255)    NOT NULL AUTO_INCREMENT PRIMARY KEY,
`project_token`   VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`project_title`   VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`project_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`project_member`  LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time`    VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`subject` ( 
`id` INT(255)     NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`project_token`   VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`theme_key`       VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`subject_title`   VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`subject_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`subject_enable`  VARCHAR(5) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time`    VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`opinion` ( 
`id` INT(255)      NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token`    VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`theme_key`       VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`score_key`       VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`opinion_type`    VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`opinion_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time`    VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`score` ( 
`id` INT(255)   NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`score_key`    VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`score`        VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`score_index` ( 
`id` INT(255)    NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token`  VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`score_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time`  VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`files` ( 
`id` INT(255)   NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`file_key`     VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

CREATE TABLE `project_system`.`program` ( 
`id` INT(255)   NOT NULL AUTO_INCREMENT PRIMARY KEY, 
`access_token` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`score_key`    VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`process`      LONGTEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
`created_time` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_bin;

' `id`              ID   	  排序'
' `access_token`    AID  	  識別(會員)'
' `project_token`   PID  	  識別(專案)'
' `theme_key` 	    TKEY 	  識別(面向)'
' `score_key`       SKEY 	  識別(分數)'
' `file_key`        FKEY 	  識別(檔案)'
' `name`            用戶名稱  排序'
' `username`        用戶帳號  帳號'
' `password`        用戶密碼  密碼'
' `project_title`   專案標題  標題'
' `project_content` 專案內容  內容'
' `project_member`  專案組員  會員'
' `subject_title`   面相標題  標題'
' `subject_content` 面相內容  內容'
' `subject_enable`  意見發表  啟用'
' `opinion_type`    意見類型  類型'