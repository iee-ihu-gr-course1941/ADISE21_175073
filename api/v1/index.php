<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);

//Print it out for example purposes.
// echo $_COOKIE['tokenC'];

if ($request[0] == "login") {
    if ($method == "POST") {
        // print json_encode(, JSON_PRETTY_PRINT);
        login();
    }
} else {
    echo "Not found";
}

switch ($request[0]) {
    case 'login':
       if($method == 'POST'){
        // print json_encode(, JSON_PRETTY_PRINT);
        login();
       }else{
        header("HTTP/1.1 400 Bad Request");
        print json_encode(['errormesg' => "Method $method not allowed here."]);
       }
        break;
    case 'register':
        if($method == 'POST'){
                // print json_encode(, JSON_PRETTY_PRINT);
                register();
        }else{
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
        break;
    case 'joinGame':
        if($method == 'POST'){
            // print json_encode(, JSON_PRETTY_PRINT);
            register();
        }else{
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
            break;
}




function login()
{
    global $mysqli;
    $sql = "SELECT id, username FROM users WHERE username = ? OR email = ? AND password = ?";
    $st = $mysqli->prepare($sql);
    if (false === $st) {
        die("Prepare Failed");
    }

    $rc = $st->bind_param("sss", $GLOBALS['input']['username'], $GLOBALS['input']['username'], $GLOBALS['input']['pass']);
    if (false === $rc) {
        die("Bind Failed");
    }

    $rc = $st->execute();
    if (false === $rc) {
        die("Execute Failed");
    }

    $res = $st->get_result();
    if (mysqli_num_rows($res) < 1) {
        echo 'Combination of username and password not found ';
    } else {

        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        setcookie("tokenC", $token, time() + (86400 * 30), "/");
        $_COOKIE['tokenC'] = $token;

        $sql = "UPDATE users set token = ? WHERE username = ? OR email = ?";

        $st = $mysqli->prepare($sql);
        if (false === $st) {
            die("Prepare Failed");
        }

        $rc = $st->bind_param('sss', $token, $GLOBALS['input']['username'], $GLOBALS['input']['username']);
        if (false === $rc) {
            die("Bind Failed");
        }

        $rc = $st->execute();
        if (false === $rc) {
            die("Execute Failed");
        }
        echo "correct ";
    }

    // return($res->fetch_all(MYSQLI_ASSOC));
}

function register()
{
}
