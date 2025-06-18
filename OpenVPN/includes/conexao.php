<?php
// includes/conexao.php

// $host = '10.0.0.20' // Usa o DB da VM Database
// $host = '127.0.0.1' // Usa o DB da VM OpenVPN (essa)

$host = '10.0.0.20';
$dbname = 'vpn_db';
$user = 'vpn_user'; // coloque seu usuário do banco aqui
$pass = '123456';   // coloque a senha do seu usuário do banco aqui

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco: " . $e->getMessage());
}
