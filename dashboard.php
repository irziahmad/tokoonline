<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

require 'db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            display: flex;
            flex-direction: column;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            overflow: hidden;
            height: 100%;
            text-align: center;
            transition: transform 0.2s ease;
        }

        .product-card:hover {
            transform: scale(1.05);
        }

        .product-image {
            width: 100%;
            height: 0;
            padding-top: 75%; /* 4:3 aspect ratio */
            background-size: cover;
            background-position: center;
        }

        .product-info {
            padding: 1rem;
            flex: 1;
        }

        .product-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .container {
            max-width: 1200px;
        }

        .header-logo {
            max-height: 50px; /* Adjust as needed */
            margin-right: 1px;
        }

        .header-title {
            display: flex;
            align-items: center;
            gap: 15px; /* Space between logo and title */
        }
    </style>
</head>
<body>
    <div class="container my-4">
        <div class="header-title mb-4">
            <img src="assets/logotokoo.png" alt="Logo" class="header-logo">
            <h1>Dashboard Admin</h1>
        </div>
        <a href="login.php" class="btn btn-danger mb-4">Logout</a>

        <h2>Tambah Produk</h2>
        <form action="add_product.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Nama Produk" required>
            </div>
            <div class="mb-3">
                <textarea name="description" class="form-control" placeholder="Deskripsi"></textarea>
            </div>
            <div class="mb-3">
                <input type="number" name="price" class="form-control" placeholder="Harga" required step="0.01">
            </div>
            <div class="mb-3">
                <input type="file" name="image" class="form-control" required>
            </div>
            <input type="submit" class="btn btn-primary" value="Tambah Produk">
        </form>

        <h2>Daftar Produk</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
            <?php
            $query = "SELECT * FROM tb_products";
            $stmt = $pdo->query($query);
            while ($product = $stmt->fetch()) {
                $formattedPrice = number_format($product['price'], 2, ',', '.');
                echo '<div class="col">';
                echo '<div class="product-card">';
                echo '<div class="product-image" style="background-image: url(\'uploads/' . htmlspecialchars($product['image']) . '\');"></div>';
                echo '<div class="product-info">';
                echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                echo '<p class="card-text">Rp' . $formattedPrice . '</p>';
                echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
                echo '<a href="edit_product.php?id=' . $product['id'] . '" class="btn btn-warning">Edit</a> ';
                echo '<a href="delete_product.php?id=' . $product['id'] . '" class="btn btn-danger">Hapus</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
