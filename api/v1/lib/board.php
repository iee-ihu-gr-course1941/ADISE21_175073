<?php 

function show_board($input)
{
    header('Content-type: application/json');
    print json_encode(read_board(), JSON_PRETTY_PRINT);
}

function read_board()
{
    global $mysqli;
    $sql = 'select * from Board';
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    return ($res->fetch_all(MYSQLI_ASSOC));
}

function reset_board()
{
    global $mysqli;
    $sql = 'call reset_game()';
    $mysqli->query($sql);
}