<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/conexao.php'; // Conexão com o banco

$tituloPagina = "Lista de Administradores";
include_once __DIR__ . '/../includes/head.php';
include_once __DIR__ . '/../includes/navbar.php';

$mensagem = '';

// Processamento do POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['acao'], $_POST['selecionados'])) {
        $idsSelecionados = $_POST['selecionados'];

        if ($_POST['acao'] === 'desativar') {
            $stmt = $pdo->prepare("UPDATE usuarios SET ativo = 0 WHERE email = ?");
            foreach ($idsSelecionados as $email) {
                $stmt->execute([$email]);
            }
            $mensagem = '<div class="alert alert-warning">Usuários desativados.</div>';
        }

        if ($_POST['acao'] === 'ativar') {
            $stmt = $pdo->prepare("UPDATE usuarios SET ativo = 1 WHERE email = ?");
            foreach ($idsSelecionados as $email) {
                $stmt->execute([$email]);
            }
            $mensagem = '<div class="alert alert-success">Usuários ativados.</div>';
        }

        if ($_POST['acao'] === 'remover') {
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE email = ?");
            foreach ($idsSelecionados as $email) {
                $stmt->execute([$email]);
            }
            $mensagem = '<div class="alert alert-danger">Usuários removidos.</div>';
        }
    }
}

// Buscar todos os usuÃ¡rios
$stmt = $pdo->query("SELECT email, nome, ativo FROM usuarios ORDER BY nome");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<?php renderHead($tituloPagina); ?>
<body class="d-flex flex-column min-vh-100">
<?php include_once __DIR__ . '/../includes/navbar.php'; ?>

<div class="container mt-4">
    <h2>Lista de Administradores</h2>

    <?= $mensagem ?>

    <form method="POST">
        <div class="mb-3 d-flex gap-2">

            <!-- Botão cadastrar como link -->
            <a href="/views/cadastro.php" class="btn btn-primary">Cadastrar</a>

            <!-- Dropdown de edição -->
            <div class="btn-group">
                <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    Editar
                </button>
                <ul class="dropdown-menu">
                    <li><button type="submit" name="acao" value="desativar" class="dropdown-item text-warning">Desativar acesso</button></li>
                    <li><button type="submit" name="acao" value="ativar" class="dropdown-item text-success">Ativar acesso</button></li>
                    <li><button type="submit" name="acao" value="remover" class="dropdown-item text-danger">Remover usuário</button></li>
                </ul>
            </div>

        </div>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Selecionar</th>
                    <th>Email</th>
                    <th>Nome</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="4">Nenhum administrador cadastrado.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selecionados[]" value="<?= htmlspecialchars($usuario['email']); ?>">
                            </td>
                            <td><?= htmlspecialchars($usuario['email']); ?></td>
                            <td><?= htmlspecialchars($usuario['nome']); ?></td>
                            <td><?= $usuario['ativo'] ? 'Ativo' : 'Inativo'; ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
