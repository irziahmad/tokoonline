<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = 'uploads/' . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $query = "UPDATE tb_products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $description, $price, $image, $id]);
    } else {
        $query = "UPDATE tb_products SET name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$name, $description, $price, $id]);
    }

    header('Location: dashboard.php');
}

$query = "SELECT * FROM tb_products WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$id]);
$product = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 800px;
        }
        .form-control {
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <h1>Edit Produk</h1>
        <a href="dashboard.php" class="btn btn-secondary mb-4">Kembali</a>
        <form action="edit_product.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" required step="0.01">
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk (Opsional)</label>
                <input type="file" id="image" name="image" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Update Produk</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
