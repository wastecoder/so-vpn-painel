<?php
require_once __DIR__ . '/../includes/auth.php';
require_once '../includes/funcoes.php';
require_once __DIR__ . '/../includes/conexao.php';

// Tratamento do POST para criar ou remover certificados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['executar'])) {
        // Criar certificado
        $id = gerarIdUnico();
        $comando = "sudo /usr/bin/python3 /opt/vpn-cert-generator/gerar_certificado.py $id";
        $output = shell_exec($comando);

        // Verifica se arquivo foi criado no storage
        $origem = "/var/www/html/storage/{$id}_cert.zip";
        $destino = "../storage/{$id}_cert.zip";
        if (file_exists($origem) && !file_exists($destino)) {
            rename($origem, $destino);
        }

        // Registrar no MySQL
        $dataAtual = date("Y-m-d H:i:s");
        $validade = date("Y-m-d", strtotime("+7 days"));
        $sql = "INSERT INTO certificados (id, data, validade) VALUES (:id, :data, :validade)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':data' => $dataAtual,
            ':validade' => $validade
        ]);

        $msgSucesso = "Certificado gerado com ID: <strong>$id</strong>";
    }

    if (isset($_POST['apagar']) && isset($_POST['remover'])) {
        foreach ($_POST['remover'] as $id) {
            $comando = "sudo /usr/bin/python3 /opt/vpn-cert-generator/deletar_certificado.py $id";
            shell_exec($comando);

            $sql = "DELETE FROM certificados WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);
        }
        $msgRemovido = "Certificados selecionados foram removidos.";
    }
}

// Preenche a tabela
$sql = "SELECT * FROM certificados ORDER BY data DESC";
$stmt = $pdo->query($sql);
$lista = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<?php
require_once __DIR__ . '/../includes/head.php';
renderHead('Gerar Certificado VPN');
?>

<body class="bg-light d-flex flex-column min-vh-100">

<!-- NAVBAR -->
<?php include __DIR__ . '/../includes/navbar.php'; ?>

<div class="container py-5">
    <h2 class="mb-4">Gerar novo certificado VPN</h2>

    <?php if (!empty($msgSucesso)): ?>
        <div class="alert alert-success"><?= $msgSucesso ?></div>
    <?php endif; ?>

    <?php if (!empty($msgRemovido)): ?>
        <div class="alert alert-danger"><?= $msgRemovido ?></div>
    <?php endif; ?>

    <form method="POST" class="mb-5">
        <button type="submit" name="executar" value="1" class="btn btn-primary">Criar certificado</button>
    </form>

    <h3>Certificados existentes:</h3>

    <?php if (count($lista) > 0): ?>
        <form method="POST" onsubmit="return confirm('Você realmente deseja excluir os certificados selecionados?')">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Remover</th>
                        <th scope="col">Download</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Data de criação</th>
                        <th scope="col">Validade até</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista as $cert): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="remover[]" value="<?= htmlspecialchars($cert['id']) ?>">
                            </td>
                            <td>
                                <a href="baixar.php?id=<?= urlencode($cert['id']) ?>" class="btn btn-sm btn-success">Baixar</a>
                            </td>
                            <td><?= htmlspecialchars($cert['id']) ?></td>
                            <td>
                                 <?= (new DateTime($cert['data']))->format('d/m/Y - H:i') ?>
                            </td>
                            <td>
                                 <?= (new DateTime($cert['validade']))->format('d/m/Y') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" name="apagar" value="1" class="btn btn-danger">Remover selecionados</button>
        </form>
    <?php else: ?>
        <p>Nenhum certificado foi gerado ainda.</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
</body>
</html>
