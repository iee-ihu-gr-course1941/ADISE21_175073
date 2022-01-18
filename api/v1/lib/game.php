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


function updateStatus()
{
    global $mysqli;
    $status = read_status();
    $new_status=null;
	$new_turn=null;
    $st3=$mysqli->prepare('select count(*) as abord_game from players WHERE change< (NOW() - INTERVAL 5 MINUTE)');
	$st3->execute();
	$res3 = $st3->get_result();
	$aborted = $res3->fetch_assoc()['abord_game'];
	if($aborted>0) {
		$sql = "UPDATE players SET username=NULL, token=NULL WHERE change< (NOW() - INTERVAL 5 MINUTE)";
		$st2 = $mysqli->prepare($sql);
		$st2->execute();
		if($status['status']=='start_game') {
			$new_status='abord_game';
		}
	}

    $sql = 'select count(*) as c from players where username is not null';
	$st = $mysqli->prepare($sql);
	$st->execute();
	$res2 = $st->get_result();
	$players = $res2->fetch_assoc()['c'];
	
	switch($players) {
		case 0: 
            $new_status='not active'; 
            break;
		case 1: 
            $new_status='initialized';
            break;
		case 2: 
            $new_status='start_game'; 
			if($status['turn']==null) {
				$new_turn='1'; // It was not started before...
			}
			break;
	}

	$sql = 'update game_status set status=?, turn=?';
	$st = $mysqli->prepare($sql);
	$st->bind_param('ss',$new_status,$new_turn);
	$st->execute();

}

function showStatus()
{

    global $mysqli;
    // check_abort();
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

function check_abort()
{
    global $mysqli;

    $sql = "update game_status set status='abord_game', 
    result=if(turn='0','1'),turn=null where turn is not null and
     change<(now()-INTERVAL 5 MINUTE) and status='start_game'";
    $st = $mysqli->prepare($sql);
    $st->execute();
}
