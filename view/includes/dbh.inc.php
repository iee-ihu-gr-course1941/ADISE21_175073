<?php

$servername = "localhost";
$dbUsername = "root";
$dbpass = "";
$dbname = "login_system";

$conn = mysqli_connect($servername,$dbUsername,$dbpass,$dbname);  

if(!$conn){
    die("Connection failed: " .mysqli_connect_error());
}