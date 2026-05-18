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

// funação para registrar logs de atividades
function registrarLog($conn, $id_usuario, $acao) {
    $stmt = $conn->prepare("INSERT INTO logs_historico (id_usuario, acao) VALUES (?, ?)");
    if (!$stmt) {
        die("<br>Erro no prepare do banco:</br>" . $conn->error);
    }

    $stmt->bind_param("is", $id_usuario, $acao);

    if (!$stmt->execute()) {
        die("<br>Erro ao executar o comando do log:</br> " . $conn->error);
    }

    $stmt->close();
}

?>