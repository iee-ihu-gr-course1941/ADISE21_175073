<?php
if (!defined('Access')) {
    die('Direct access not permitted');
}

function joingame()
{

    global $mysqli;

    $sqlcheck = "Select * from players";
    $st = $mysqli->prepare($sqlcheck);
    if (false === $st) {
        print json_encode(['errormesg' => "Prepare Failed"]);
        exit;
    }

    // $rc = $st->bind_param("s", $_COOKIE['tokenC']);
    // if (false === $rc) {
    //     print json_encode(['errormesg' => "Bind Failed"]);
    //     exit;
    // }

    $rc = $st->execute();
    if (false === $rc) {
        print json_encode(['errormesg' => "Execute Failed"]);
        exit;
    }
    $res2 = $st->get_result();
    if (mysqli_num_rows($res2) == 2) {
        print json_encode(['errormesg' => "Max players"]);
        exit;
    }

    $sql = "INSERT INTO players (id,username,token) SELECT id,username,token
    FROM users
    WHERE token = ?;";
    $st = $mysqli->prepare($sql);
    if (false === $st) {
        print json_encode(['errormesg' => "Prepare Failed"]);
        exit;
    }

    $rc = $st->bind_param("s", $_COOKIE['tokenC']);
    if (false === $rc) {
        print json_encode(['errormesg' => "Bind Failed"]);
        exit;
    }

    $rc = $st->execute();
    if (false === $rc) {
        print json_encode(['errormesg' => "Execute Failed"]);
        exit;
    }

    if (mysqli_num_rows($res2) == 1) {
        echo "start Game";
        exit;
    }

    echo "TEST";
}


function updateStatus(){
    global $mysqli;
    $status = read_status();
     




}

function showStatus(){
    
    global $mysqli;
    $sql = "SELECT * FROM game_status";
    $st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);


}

function read_status()
{
	global $mysqli;
	$sql = 'select * from game_status';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res = $st->get_result();
	$status = $res->fetch_assoc();
	return ($status);
}