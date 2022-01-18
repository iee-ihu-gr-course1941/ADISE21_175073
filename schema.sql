DELIMITER ;;

CREATE PROCEDURE reset_board()
BEGIN
DELETE FROM `players`;
DELETE FROM `game_status`;
UPDATE pieces SET available = "TRUE"
WHERE available = "FALSE" ;
INSERT INTO `game_status` VALUES ('not active',null ,null ,null);

    CREATE TABLE `Board`(
        `x` TINYINT(1) NOT NULL,
        `y` TINYINT(1) NOT NULL,
        `pieceID` int(2) DEFAULT NULL,
        primary key (`x`,`y`)

    );

    INSERT INTO `Board` VALUES (1,1),(1,2),(1,3),(1,4),(2,1),(2,2),(2,3),(2,4),(3,1),(3,2),(3,3),(3,4),(4,1),(4,2),(4,3),(4,4S);
END ;;

call reset_board();

CREATE OR REPLACE TABLE `pieces`(
    `pieceID` INT(2) AUTO_INCREMENT,
    `piececolor` enum('black','white')not null,
    `shape` enum('cycle','square')not null,
    `size` enum('long','short')not null,
    `hole` enum('YES','NO'),
    `available` enum('TRUE','FALSE') DEFAULT 'TRUE',
    primary key (`pieceID`)
);

SELECT state,turn FROM game_status ORDER BY id DESC LIMIT 1;

SELECT 1 FROM Board where `x` = 1 and `y` = 2 and `pieceID` is null
SELECT * FROM Board;
update Board set `pieceID` = 1 where `x` = 1 and `y` = 2;

INSERT INTO `pieces` (piececolor,shape,size,hole)
VALUES 
('black','cycle','long','YES'),
('black','cycle','long','NO'),
('black','cycle','short','YES'),
('black','cycle','short','NO'),
('black','square','long','YES'),
('black','square','long','NO'),
('black','square','short','YES'),
('black','square','short','NO'),

('white','cycle','long','YES'),
('white','cycle','long','NO'),
('white','cycle','short','YES'),
('white','cycle','short','NO'),
('white','square','long','YES'),
('white','square','long','NO'),
('white','square','short','YES'),
('white','square','short','NO');


DROP TABLE IF EXISTS `game_status`;
CREATE TABLE `game_status` (
    `id` int(10) not null auto_increment,
    `status` enum('start_game','end_game','not active','initalized','abord_game')not null DEFAULT 'start_game',
	`turn` TINYINT DEFAULT '1',
    `state`  enum('pick', 'place')not null DEFAULT 'pick',
    `piece` int(2) DEFAULT  null,
    `change` timestamp DEFAULT now(),
    primary key(`id`)
);

INSERT INTO `game_status` VALUES();
INSERT INTO `game_status` (turn,state) VALUES(1,'place');

INSERT INTO `game_status` (turn,state,piece) VALUES(1,'place',1);
select * from game_status;



DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id` int(10) not null auto_increment,
     `username` varchar(20) DEFAULT null UNIQUE,
     `email` varchar(50) DEFAULT null UNIQUE,
     `password` varchar(100),
     `token` varchar(100) DEFAULT null UNIQUE,
     primary key(`id`)
);

DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
    `player` int auto_increment,
    `id` int(10) not null,
    `username` varchar(20) DEFAULT null UNIQUE,
    `token` varchar(100) DEFAULT null UNIQUE,
    primary key(`player`)
);


select * from users;
select * from players;

DELIMITER ;;--PLACE
CREATE or replace PROCEDURE `placepiece`(x int,y int, piece int)
BEGIN
    update Board b set `pieceID` = piece where b.x = x and b.y = y;
    update pieces set `available` = FALSE where `pieceID` = piece;
    
    INSERT INTO `game_status` (turn,state) select turn,'pick' from game_status ORDER BY id DESC LIMIT 1;

END ;;
DELIMITER ;



-- DELIMITER ;;
-- CREATE PROCEDURE `reset_game_status`()
-- BEGIN
-- update `game_status` set `status`='not active' ,`turn`=null ,`piece`=null ,`change`=null;
-- END ;;
-- DELIMITER ;


-- DELIMITER ;;
-- CREATE PROCEDURE `reset_players`()
-- BEGIN
-- DELETE FROM `players`;
-- END ;;
-- DELIMITER ;


DELIMITER ;;--PICK
CREATE or replace PROCEDURE `pickpiece`(x int,y int, piece int)
BEGIN
    update Board b set `pieceID` = piece where b.x = x and b.y = y;
    update pieces set `available` = FALSE where `pieceID` = piece;
    
    INSERT INTO `game_status` (turn,state) select turn,'pick' from game_status ORDER BY id DESC LIMIT 1;

END ;;
DELIMITER ;



