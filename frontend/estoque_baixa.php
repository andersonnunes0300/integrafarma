<?php
session_start();
require_once '../conexao/conexao.php';
$id = $_GET['id'];
$item = $conn->query("SELECT nome, quantidade FROM medicamentos WHERE id_medicamento = '$id'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Saída de Estoque</title>
    <link rel="stylesheet" href="../css/baixa_estoque.css">
</head>
<body>
    <div class="card">
        <h3>Dar Baixa: <?php echo $item['nome']; ?></h3>
        <p>Estoque atual: <strong><?php echo $item['quantidade']; ?></strong></p>
<form action="../backend/estoque_baixa.php" method="POST">
    <input type="hidden" name="id_medicamento" value="<?php echo $id; ?>">
    <label>Quantidade que vai sair:</label>
    <input type="number" name="quantidade" min="1" max="<?php echo $item['quantidade']; ?>" required>
    <button type="submit">Confirmar Saída</button>
    
    <a href="tela_usuario.php" class="btn-cancelar">Cancelar</a>
    
</form>
    </div>
</body>
</html>