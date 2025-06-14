<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $image = $_FILES['image']['name'];
    $target = 'uploads/' . basename($image);
    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    $query = "INSERT INTO tb_products (name, description, price, image) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$name, $description, $price, $image]);

    header('Location: dashboard.php');
}
?>
