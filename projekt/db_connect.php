<?php
ini_set('display_errors' ,1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);


//ECHO $mysqli->connect_errno;

if($mysqli->connect_error){
    die("błąd połączenia:" .$mysqli->connect_error);
}