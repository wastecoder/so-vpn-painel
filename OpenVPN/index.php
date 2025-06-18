<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once __DIR__ . '/includes/head.php';
renderHead('Página Inicial VPN');
?>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <h1 class="mb-3">Painel VPN</h1>
        <p class="mb-4">Escolha uma das opções abaixo para começar:</p>

        <a href="views/certificados.php" class="btn btn-primary m-2">
            <i class="fas fa-certificate"></i> Gerenciar Certificados
        </a>

        <a href="views/adms.php" class="btn btn-success m-2">
            <i class="fas fa-users"></i> Gerenciar Usuários
        </a>

        <a href="views/login.php" class="btn btn-warning m-2">
            <i class="fas fa-sign-in-alt"></i> Fazer Login
        </a>
    </div>

</body>
</html>
