<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "integra_farma";

$conn = new mysqli($host, $user, $pass, $db);

if($conn->connect_error){
    die("Falha na conexão com o banco: ". $conn->connect_error);
}

$conn->set_charset("utf8");

?>