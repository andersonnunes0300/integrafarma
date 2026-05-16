<?php
session_start();
require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Busca os dados no banco para preencher o formulário
    $stmt = $conn->prepare("SELECT * FROM fornecedores WHERE id_fornecedor = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $fornecedor = $resultado->fetch_assoc();

    if (!$fornecedor) {
        echo "<script>alert('Fornecedor não encontrado!'); window.location.href='tela_admin.php';</script>";
        exit;
    }
} else {
    header("Location: tela_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Fornecedor - Integra Farma</title>
    <link rel="stylesheet" href="../css/fornecedor_editar.css">
</head>

<body>
    <div class="card">
        <h2>Editar Fornecedor</h2>
        <form action="../backend/fornecedor_editar.php" method="POST">

            <input type="hidden" name="id_fornecedor" value="<?php echo $fornecedor['id_fornecedor']; ?>">

            <label>Nome do Fornecedor:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($fornecedor['nome_empresa']); ?>" required>

            <label>CNPJ:</label>
            <input type="text" name="cnpj" value="<?php echo htmlspecialchars($fornecedor['cnpj']); ?>" required>

            <button type="submit" class="btn-save">Salvar Alterações</button>
            <a href="tela_admin.php" class="btn-cancel">Cancelar e Voltar</a>
        </form>
    </div>
</body>

</html>