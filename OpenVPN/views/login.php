<?php
session_start();
require_once __DIR__ . '/../includes/funcoes.php';
require_once __DIR__ . '/../includes/conexao.php'; // Importa conexão

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

    // Validação: Email
    if (strlen($email) < 3 || strlen($email) > 30 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Informe o email corretamente.';
    }
    // Validação: Senha
    elseif (empty($senha)) {
        $erro = 'Informe a senha.';
    }
    else {
        // Busca o usuário no banco
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificação de senha e status ativo
        if ($usuario && $usuario['ativo'] && password_verify($senha, $usuario['senha'])) {
            $_SESSION['usuario'] = [
                'email' => $usuario['email'],
                'nome' => $usuario['nome']
            ];
            header('Location: /index.php');
            exit;
        } else {
            $erro = 'Usuário ou senha inválidos.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - VPN Manager</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Login</h2>
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($erro); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email (Username):</label>
                <input type="email" name="email" id="email" class="form-control" maxlength="30" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" name="senha" id="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
    </div>
</body>
</html>
