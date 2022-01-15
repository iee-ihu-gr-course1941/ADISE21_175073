<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);


//Generate a random string.
$token = openssl_random_pseudo_bytes(16);

//Convert the binary data into hexadecimal representation.
$token = bin2hex($token);

setcookie("tokenC", $token, time() + (86400 * 30), "/");

//Print it out for example purposes.
// echo $_COOKIE['tokenC'];

if($request[0] == "login"){
    if($method == "POST"){
        print json_encode(login(), JSON_PRETTY_PRINT);
    }   
}
else{
    echo "Not found";
}

function login() {
    global $mysqli;
	$sql = "SELECT id, username, password FROM users WHERE username = ?";
	$st = $mysqli->prepare($sql);
    $st->bind_param('s',$GLOBALS['input']['username']);
	$st->execute();
	$res = $st->get_result();
    return($res->fetch_all(MYSQLI_ASSOC));
}
    
?>