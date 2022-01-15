DROP TABLE IF EXISTS emptyBoard;
CREATE TABLE `emptyBoard` (
    `x` TINYINT(1) NOT NULL,
    `y` TINYINT(1) NOT NULL,
    `pieceID` int(2),
    primary key (`x`,`y`)
);

DROP TABLE IF EXISTS `currentGame`;
CREATE TABLE `currentGame` (
    `x` TINYINT(1) NOT NULL,
    `y` TINYINT(1) NOT NULL,
    `pieceID` int(2),
    primary key (`x`,`y`)
);

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



