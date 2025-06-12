<?php
$user='root';
$password = '';
$database='Login';
$host='localhost';

$mysqli = new mysqli($host,$user,$password,$database);

if ($mysqli->error) {
    die('Falha de conexão'. $mysqli->error);
    }
?>