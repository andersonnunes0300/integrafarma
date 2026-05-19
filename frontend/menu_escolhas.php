<?php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../frontend/login.php"); 
    exit;
}

$nivel = $_SESSION['usuario_nivel']; 
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel Cimed Farma</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .card { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; width: 450px; }
        h2 { color: #007bff; margin-bottom: 20px; }
        .btn { display: block; padding: 15px; margin: 10px 0; color: white; text-decoration: none; font-weight: bold; border-radius: 8px; transition: 0.3s; text-align: center; }
        
        .btn-blue { background: #007bff; }
        .btn-blue:hover { background: #0056b3; }
        .btn-green { background: #28a745; }
        .btn-green:hover { background: #218838; }
        .btn-orange { background: #f57c00; }
        .btn-orange:hover { background: #e65100; }
        .btn-red { background: #dc3545; }
        .btn-red:hover { background: #c82333; }
        
        .badge { background: #eee; padding: 3px 10px; border-radius: 5px; font-size: 12px; color: #555; margin-left: 5px; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Integra Farma</h2>
        <p>Seja Bem-vindo, <strong><?php echo htmlspecialchars($_SESSION['nome']); ?></strong> <span class="badge"><?php echo htmlspecialchars($nivel); ?></span></p>
        
        <?php if ($nivel === 'admin'): ?>
            <a href="../frontend/tela_admin.php" class="btn btn-blue">📦 Cadastrar Medicamentos (Admin)</a>
        <?php else: ?>
            <a href="../frontend/tela_usuario.php" class="btn-menu btn-blue" style="display: block; padding: 15px; margin: 10px 0; color: white; text-decoration: none; font-weight: bold; border-radius: 8px; transition: 0.3s; text-align: center;">📦 Cadastrar Medicamentos</a>
        <?php endif; ?>
        
        <a href="../pdv_integrafarma/frontend_pdv/tela_pdv.php" class="btn btn-green">📋 Nova Venda (PDV)</a>

        <a href="../frontend/tela_login.php" class="btn btn-red">Sair do Sistema</a>
    </div>
</body>
</html>