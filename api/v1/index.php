<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);

//Print it out for example purposes.
// echo $_COOKIE['tokenC'];

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
            if($method == 'GET'){
                // print json_encode(, JSON_PRETTY_PRINT);
                
            }else{
                header("HTTP/1.1 400 Bad Request");
                print json_encode(['errormesg' => "Method $method not allowed here."]);
            }
            break;
    default:
            header("HTTP/1.1 404 Not Found");
            print json_encode(['errormesg' => "Player request not found."]);
            break;
}




function login()
{
    global $mysqli;
	$sql = "SELECT id, username FROM users WHERE username = ? OR email = ? AND password = ?";
	$st = $mysqli->prepare($sql);
    if ( false===$st ) {
        print json_encode(['errormesg'=>"Prepare Failed"]);
        exit;
    }

    $rc = $st->bind_param("sss",$GLOBALS['input']['username'],$GLOBALS['input']['username'],$GLOBALS['input']['pass']);
    if ( false===$rc ) {
        print json_encode(['errormesg'=>"Bind Failed"]);
        exit;
    }

	$rc = $st->execute();
    if ( false===$rc ) {
        print json_encode(['errormesg'=>"Execute Failed"]);
        exit;
    }

	$res = $st->get_result();
    if(mysqli_num_rows($res) < 1){
        print json_encode(['errormesg'=>"Combination of username and password not found"]);
        exit;
    }
    $token = openssl_random_pseudo_bytes(16);
    $token = bin2hex($token);

    setcookie("tokenC", $token, time() + (86400 * 30), "/");
    $_COOKIE['tokenC'] = $token;

    $sql = "UPDATE users set token = ? WHERE username = ? OR email = ?";

    $st = $mysqli->prepare($sql);
    if ( false===$st ) {
        print json_encode(['errormesg'=>"Prepare Failed"]);
        exit;
    }

    $rc = $st->bind_param('sss',$token,$GLOBALS['input']['username'],$GLOBALS['input']['username']);
    if ( false===$rc ) {
        print json_encode(['errormesg'=>"Bind Failed"]);
        exit;
    }

    $rc = $st->execute();
    if ( false===$rc ) {
        print json_encode(['errormesg'=>"Execute Failed"]);
        exit;
    }
}

function register()
{

    
}
