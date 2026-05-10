<?php
session_start();
require_once '../conexao/conexao.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM medicamentos WHERE id_medicamento = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $f = $res->fetch_assoc();

    if (!$f) {
        echo "<script>alert('Produto não encontrado!'); window.location.href='tela_usuario.php';</script>";
        exit;
    }
} else {
    header("Location: tela_usuario.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Medicamento - Integra Farma</title>
    <link rel="stylesheet" href="../css/editar_estoque.css">
</head>
<body>

<div class="card">
    <h2>Editar Medicamento</h2>
    <form action="../backend/estoque_update.php" method="POST">
        <input type="hidden" name="id_medicamento" value="<?php echo $f['id_medicamento']; ?>">

        <label>Nome do Medicamento:</label>
        <input type="text" name="nome" value="<?php echo htmlspecialchars($f['nome']); ?>" required>

        <div class="row">
            <div class="field">
                <label>Tipo:</label>
                <input type="text" name="tipo" value="<?php echo htmlspecialchars($f['tipo']); ?>" placeholder="Ex: Genérico" required>
            </div>
            <div class="field">
                <label>Tarja:</label>
                <input type="text" name="tarja" value="<?php echo htmlspecialchars($f['tarja']); ?>" placeholder="Ex: Vermelha" required>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label>Lote:</label>
                <input type="text" name="lote" value="<?php echo htmlspecialchars($f['lote']); ?>" required>
            </div>
            <div class="field">
                <label>Validade:</label>
                <input type="date" name="validade" value="<?php echo $f['validade']; ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="field">
                <label>Quantidade:</label>
                <input type="number" name="quantidade" value="<?php echo $f['quantidade']; ?>" required>
            </div>
            <div class="field">
                <label>Preço (R$):</label>
                <input type="text" name="preco" value="<?php echo number_format($f['preco'], 2, '.', ''); ?>" required>
            </div>
        </div>

        <label>Fornecedor:</label>
        <select name="id_fornecedor" required>
            <?php
            $forn_query = $conn->query("SELECT id_fornecedor, nome_empresa FROM fornecedores ORDER BY nome_empresa ASC");
            while($forn = $forn_query->fetch_assoc()) {
                $selected = ($forn['id_fornecedor'] == $f['id_fornecedor']) ? "selected" : "";
                echo "<option value='{$forn['id_fornecedor']}' $selected>{$forn['nome_empresa']}</option>";
            }
            ?>
        </select>

        <button type="submit" class="btn-save">Salvar Alterações</button>
        <a href="tela_usuario.php" class="btn-cancel">Cancelar e Voltar</a>
    </form>
</div>

</body>
</html>