<?php
require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $sql = "DELETE FROM medicamentos WHERE id_medicamento = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        header("Location: ../frontend/tela_usuario.php");
    } else {
        echo "Erro ao deletar do estoque: " . $conn->error;
    }
}
?>