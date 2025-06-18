<?php
if (!isset($_GET['id'])) {
    http_response_code(400);
    exit("ID nÃ£o informado.");
}

$id = preg_replace('/[^A-Z0-9]/', '', $_GET['id']); // sanitiza
$caminho = __DIR__ . "/../storage/{$id}_cert.zip";

if (!file_exists($caminho)) {
    http_response_code(404);
    exit("Arquivo não encontrado.");
}

header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($caminho) . '"');
header('Content-Length: ' . filesize($caminho));
readfile($caminho);
exit;
?>
