DELIMITER ;;

CREATE or replace  PROCEDURE reset_board()
BEGIN
-- DELETE FROM `players`;
-- DELETE FROM `game_status`;
-- UPDATE pieces SET available = "TRUE"
-- WHERE available = "FALSE" ;
-- INSERT INTO `game_status` VALUES ('not active',null ,null ,null);

    CREATE TABLE `Board`(
        `x` TINYINT(1) NOT NULL,
        `y` TINYINT(1) NOT NULL,
        `pieceID` int(2),
        primary key (`x`,`y`)

    );

    INSERT INTO `Board` VALUES (1,1,NULL),(1,2,NULL),(1,3,NULL),(1,4,NULL),(2,1,NULL),(2,2,NULL),(2,3,NULL),(2,4,NULL),(3,1,NULL),(3,2,NULL),(3,3,NULL),(3,4,NULL),(4,1,NULL),(4,2,NULL),(4,3,NULL),(4,4,NULL);
END ;;

call reset_board();

drop table if exists `pieces` CASCADE;
CREATE OR REPLACE TABLE `pieces`(
    `pieceID` INT(2) AUTO_INCREMENT,
    `piececolor` enum('black','white')not null,
    `shape` enum('cycle','square')not null,
    `size` enum('long','short')not null,
    `hole` enum('YES','NO'),
    `available` enum('TRUE','FALSE') DEFAULT 'TRUE',
    primary key (`pieceID`)
);

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

select * from pieces;
select * from Board;


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

DELIMITER ;;
CREATE or replace PROCEDURE `placepiece`(x int,y int, piece int)
BEGIN
    update Board b set `pieceID` = piece where b.x = x and b.y = y;
    INSERT INTO `game_status` (turn,state) select turn,'pick' from game_status ORDER BY id DESC LIMIT 1;

END ;;
DELIMITER ;

DELIMITER ;;--PICK
CREATE or replace PROCEDURE pickpiece(piece int)
BEGIN
    update pieces set `available` = 'FALSE' where `pieceID` = piece;

    INSERT INTO game_status (turn,state,piece) select IF(g.turn=1,2,1),'place',piece from game_status g ORDER BY id DESC LIMIT 1;

END ;;
DELIMITER ;

call pickpiece(2);

select * from game_status;