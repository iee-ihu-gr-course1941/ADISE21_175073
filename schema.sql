DROP TABLE IF EXISTS emptyBoard;
CREATE TABLE emptyBoard (
    x TINYINT(1) NOT NULL,
    y TINYINT(1) NOT NULL,
    pieceID TINYINT(2),
    primary key (x,y)
);
DROP TABLE IF EXISTS currentGame;
CREATE TABLE currentGame (
    x TINYINT(1) NOT NULL,
    y TINYINT(1) NOT NULL,
    pieceID TINYINT(2),
    primary key (x,y)
);

CREATE TABLE Game_status (
   'status' enum('started','ended','not active',) 
);

