<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);




//Print it out for example purposes.
// echo $_COOKIE['tokenC'];

if($request[0] == "login"){
    if($method == "POST"){
        // print json_encode(, JSON_PRETTY_PRINT);
        login();
    }   
}
else{
    echo "Not found";
}

function login() {
    global $mysqli;
	$sql = "SELECT id, username FROM users WHERE username = ? OR email = ? AND password = ?";
	$st = $mysqli->prepare($sql);
    $st->bind_param("sss",$GLOBALS['input']['username'],$GLOBALS['input']['username'],$GLOBALS['input']['pass']);
	$st->execute();
	$res = $st->get_result();
    if(mysqli_num_rows($res) < 1){
        echo 'Combination of username and password not found ';
    }
    else{

        $token = openssl_random_pseudo_bytes(16);
        $token = bin2hex($token);

        setcookie("tokenC", $token, time() + (86400 * 30), "/");
        $_COOKIE['tokenC'] = $token;

        $sql = "UPDATE users set token = ? WHERE username = ? OR email = ?";
        $st2 = $mysqli->prepare($sql);
        $st2->bind_param('sss',$token,$GLOBALS['input']['username'],$GLOBALS['input']['username']);
        $st2->execute();
        echo "correct ";
    }
    
    // return($res->fetch_all(MYSQLI_ASSOC));
}
    
?>