<?php
session_start();
require 'db.php';

// Initialize cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle removing items from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Handle updating quantities
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = max(1, intval($_POST['quantity'])); // Ensure quantity is at least 1
    $_SESSION['cart'][$product_id] = $new_quantity;
}

// Fetch product details for items in the cart
$cart_items = [];
$total = 0;
foreach ($_SESSION['cart'] as $product_id => $quantity) {
    $stmt = $pdo->prepare("SELECT * FROM tb_products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch();
    
    if ($product) {
        $cart_items[] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'subtotal' => $product['price'] * $quantity
        ];
        $total += $product['price'] * $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Keranjang Belanja - Toko Online</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Lora', serif;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#"><img src="assets/logotokoo.png" style="width: 40px" alt="Toko Online Logo" class="navbar-logo me-2" />Toko Online</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">Keranjang Belanja</h1>
        <?php if (empty($cart_items)) : ?>
            <p>Keranjang belanja Anda kosong.</p>
        <?php else : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['name']); ?></td>
                            <td>Rp<?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                            <td>
                                <form method="post" class="d-flex align-items-center">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control form-control-sm" style="width: 60px;">
                                    <button type="submit" name="update_quantity" class="btn btn-sm btn-secondary ms-2">Update</button>
                                </form>
                            </td>
                            <td>Rp<?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <button type="submit" name="remove_from_cart" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td><strong>Rp<?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="text-end mt-3">
                <a href="pembayaran.php" class="btn btn-primary">Lanjutkan ke Pembayaran</a>
            </div>
        <?php endif; ?>
        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Lanjutkan Belanja</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
