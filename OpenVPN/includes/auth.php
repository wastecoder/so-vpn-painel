<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: /views/login.php');
    exit;
}
?>
