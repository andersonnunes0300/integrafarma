<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>IntegraFarma</title>
</head>
<body>
    <header>
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <img src="../img/integrafarma.png" alt="Logo Integra Farma">
            </div>

            <div class="info-usuario">
                <span class="icon-nome-usuario">👤 <?= htmlspecialchars($_SESSION['nome']) ?></span>
                <a href="historico.php" class="btn-historico">📜 Auditoria</a>
                <a href="auth.php?logout=1">Sair</a>
            </div>
        </div>
    </header>

    
</body>
</html>