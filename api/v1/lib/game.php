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
        if (mysqli_num_rows($res2) < 1) {
            $new_role = "pick";
        } else {
            $new_role = "place";
        }
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

    $sql = 'update players set role=?';
    $st = $mysqli->prepare($sql);
    $st->bind_param('s',  $new_role);
    $st->execute();
    echo "TEST";
}
