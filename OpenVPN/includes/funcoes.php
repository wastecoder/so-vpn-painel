<?php

function gerarIdUnico($tamanho = 7) {
    do {
        $id = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, $tamanho);
        $caminhoZip = __DIR__ . "/../storage/{$id}_cert.zip";
    } while (file_exists($caminhoZip)); // evita colisoes
    return $id;
}

function buscarUsuarioPorEmail($email, $usuarios) {
    foreach ($usuarios as $usuario) {
        if (strtolower(trim($usuario['email'])) === strtolower(trim($email))) {
            return $usuario;
        }
    }
    return null;
}

?>
