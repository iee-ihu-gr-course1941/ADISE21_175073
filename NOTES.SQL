DELIMITER ;;
CREATE PROCEDURE `reset_pieces`()
BEGIN
UPDATE pieces SET available = "TRUE"
WHERE available = "FALSE" ;
END ;;
DELIMITER ;

DELIMITER ;;
CREATE PROCEDURE `reset_game_status`()
BEGIN
update `game_status` set `status`='not active' ,`turn`=null ,`piece`=null ,`change`=null;
END ;;
DELIMITER ;


DELIMITER ;;
CREATE PROCEDURE `reset_players`()
BEGIN
DELETE FROM `players`;
END ;;
DELIMITER ;