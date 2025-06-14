<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$id = $_GET['id'];
$query = "DELETE FROM tb_products WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);

header('Location: dashboard.php');
?>
