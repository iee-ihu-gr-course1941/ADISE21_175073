<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);

if($request[0] == "login"){
    if($method == "POST"){
        login();
    }   
}
else{
    header("HTTP/1.1 404 Not Found");
    exit;
}

function login() {
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
    
?>