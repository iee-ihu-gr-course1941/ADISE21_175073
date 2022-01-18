<?php
define('Access', TRUE);
require_once "lib/dbconnect.php";
require_once "lib/login.php";
require_once "lib/game.php";
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$GLOBALS['input'] = json_decode(file_get_contents('php://input'), true);

//Print it out for example purposes.
// echo $_COOKIE['tokenC'];

switch ($request[0]) {
    case 'login':
        if ($method == 'POST') {
            login();
        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
        break;
    case 'register':
        if ($method == 'POST') {
            if (!isset($GLOBALS['input']['username'],$GLOBALS['input']['email'], $GLOBALS['input']['password'],$GLOBALS['input']['passwordRepeat'])){
                header("HTTP/1.1 400 Bad Request");
                echo "kati";
                exit();
            }
            register();
        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
        break;
    case 'checkstatus':
        if ($method == 'GET') {
            showStatus();

        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
    break;
    case 'showboard':
        if ($method == 'GET') {
            showBoard();

        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
    break;
    case 'showpieces':
        if ($method == 'GET') {
            showpieces();

        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
    break;
    // case 'move':
    //     if ($method == 'PUT') {
    //         if (!isset($GLOBALS['input']['x'],$GLOBALS['input']['y']){
    //             header("HTTP/1.1 400 Bad Request");
    //             echo "kati";
    //             exit();
    //         }
    //         move();

    //     } else {
    //         header("HTTP/1.1 400 Bad Request");
    //         print json_encode(['errormesg' => "Method $method not allowed here."]);
    //     }
    // break;
    case 'joinGame':
        if ($method == 'POST') {
            joingame();

        } else {
            header("HTTP/1.1 400 Bad Request");
            print json_encode(['errormesg' => "Method $method not allowed here."]);
        }
        break;
    default:
        header("HTTP/1.1 404 Not Found");
        print json_encode(['errormesg' => "Not found."]);
        break;
}


