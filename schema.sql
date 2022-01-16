DELIMITER ;;
CREATE OR REPLACE PROCEDURE reset_board()
BEGIN
    DROP TABLE IF EXISTS Board;

    CREATE TABLE `Board`(
        `x` TINYINT(1) NOT NULL,
        `y` TINYINT(1) NOT NULL,
        `pieceID` int(2),
        primary key (`x`,`y`),
        FOREIGN KEY (pieceID) REFERENCES pieces(pieceID)
    );

    INSERT INTO `Board` VALUES (1,1,NULL),(1,2,NULL),(1,3,NULL),(1,4,NULL),(2,1,NULL),(2,2,NULL),(2,3,NULL),(2,4,NULL),(3,1,NULL),(3,2,NULL),(3,3,NULL),(3,4,NULL),(4,1,NULL),(4,2,NULL),(4,3,NULL),(4,4,NULL);
END ;;

DROP TABLE IF EXISTS pieces;
CREATE TABLE `pieces`(
    `pieceID` INT(2) AUTO_INCREMENT,
    `piececolor` enum('black','white')not null,
    `shape` enum('cycle','square')not null,
    `size` enum('long','short')not null,
    `hole` enum('YES','NO'),
    `available` enum('TRUE','FALSE') default 'TRUE',
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
     `username` varchar(20) default null UNIQUE,
     `email` varchar(50) default null UNIQUE,
     `password` varchar(100),
     `token` varchar(100) default null,
     primary key(`id`)
);
select * from users;
Insert into users (username,email,password) VALUES ('thankarezos','thankarezos@gmail.com','pass');

DELIMITER $$;
CREATE OR REPLACE FUNCTION setAccount(firstname text, lastname text, emails text, usernames text, pass text)
 RETURNS int
    BEGIN
    IF NOT EXISTS (SELECT 1 FROM account a WHERE a.email = emails) AND NOT EXISTS (SELECT 1 FROM account a WHERE a.username = usernames)
        THEN
            INSERT INTO account (firstname, lastname , email , username , pass )
            VALUES (firstname, lastname , emails , usernames , pass);
            return 0; -- 0 0
    ELSIF EXISTS (SELECT 1 FROM account a WHERE a.email = emails) AND NOT EXISTS (SELECT 1 FROM account a WHERE a.username = usernames)
        THEN
            return 1; -- 1 0
    ELSIF NOT EXISTS (SELECT 1 FROM account a WHERE a.email = emails) AND EXISTS (SELECT 1 FROM account a WHERE a.username = usernames)
        THEN
            return 2; -- 0 1
    ELSIF EXISTS (SELECT 1 FROM account a WHERE a.email = emails) AND EXISTS (SELECT 1 FROM account a WHERE a.username = usernames)
        THEN
            return 3; -- 1 1
        ELSE
            return 4; --error
    END IF;
END;
DELIMITER ;$$

-- CREATE OR REPLACE PROCEDURE setUsers(usernames text, emails text,  pass text)
--     BEGIN
--     IF NOT EXISTS (SELECT 1 FROM users a WHERE a.email = emails) AND NOT EXISTS (SELECT 1 FROM users a WHERE a.username = usernames)
--         THEN
--             INSERT INTO users (firstname, lastname , email , username , pass )
--             VALUES (firstname, lastname , emails , usernames , pass);
--             return 0; -- 0 0
--     ELSIF EXISTS (SELECT 1 FROM users a WHERE a.email = emails) AND NOT EXISTS (SELECT 1 FROM users a WHERE a.username = usernames)
--         THEN
--             return 1; -- 1 0
--     ELSIF NOT EXISTS (SELECT 1 FROM users a WHERE a.email = emails) AND EXISTS (SELECT 1 FROM users a WHERE a.username = usernames)
--         THEN
--             return 2; -- 0 1
--     ELSIF EXISTS (SELECT 1 FROM users a WHERE a.email = emails) AND EXISTS (SELECT 1 FROM users a WHERE a.username = usernames)
--         THEN
--             return 3; -- 1 1
--         ELSE
--             return 4; --error
--     END IF;
-- END ;;
