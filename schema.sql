DELIMITER ;;
CREATE OR REPLACE PROCEDURE reset_board()
BEGIN
    DROP TABLE IF EXISTS Board;

    CREATE TABLE `Board`(
        `x` TINYINT(1) NOT NULL,
        `y` TINYINT(1) NOT NULL,
        `pieceID` int(2),
        primary key (`x`,`y`)
    );

    INSERT INTO `Board` VALUES (1,1,NULL),(1,2,NULL),(1,3,NULL),(1,4,NULL),(2,1,NULL),(2,2,NULL),(2,3,NULL),(2,4,NULL),(3,1,NULL),(3,2,NULL),(3,3,NULL),(3,4,NULL),(4,1,NULL),(4,2,NULL),(4,3,NULL),(4,4,NULL);
END ;;


DROP TABLE IF EXISTS `game_status`;
CREATE TABLE `game_status` (
   `status` enum('start game','end game','not active','initalized','abord game')not null default 'not active',
	`turn` int null default null,
    `piece` int(2) null default null,
    `role` enum('pick','place','not active')not null default 'not active',
    `change` timestamp null default null
);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
	`id` int(10) not null auto_increment,
     `username` varchar(20) default null,
     `password` varchar(20),
     `token` varchar(20) default null,
     primary key(`id`)
);



