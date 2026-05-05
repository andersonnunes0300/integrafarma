<?php
require_once '../conexao/conexao.php';

$sql = "SELECT * FROM medicamentos";
$result = $conn->query($sql);

if (!$result) {
    die("Erro ao pegar dados do estoque: " . $conn->error);
}

?>