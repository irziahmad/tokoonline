<?php
session_start();
require 'db.php';

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit();
}

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

$whatsapp_message = "Halo, saya ingin memesan produk berikut:\n\n";
foreach ($cart_items as $item) {
    $whatsapp_message .= "{$item['name']} - {$item['quantity']} x Rp" . number_format($item['price'], 2, ',', '.') . " = Rp" . number_format($item['subtotal'], 2, ',', '.') . "\n";
}
$whatsapp_message .= "\nTotal: Rp" . number_format($total, 2, ',', '.');
$whatsapp_message .= "\n\nMohon diproses. Terima kasih!";

$encoded_message = urlencode($whatsapp_message);
$whatsapp_number = "620895320697402"; 
$whatsapp_link = "https://wa.me/{$whatsapp_number}?text={$encoded_message}";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Checkout - Toko Online</title>
    
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
        .table-responsive {
            overflow-x: auto;
        }
        @media (max-width: 767px) {
            .order-summary {
                margin-bottom: 2rem;
            }
            .whatsapp-button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="assets/logotokoo.png" style="width: 40px" alt="Toko Online Logo" class="navbar-logo me-2" />
                <span>Toko Online</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Keranjang</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 text-center">Checkout</h1>
        <div class="row">
            <div class="col-md-8 order-summary">
                <h2 class="h3 mb-3">Ringkasan Pesanan</h2>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $item) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td>Rp<?php echo number_format($item['price'], 2, ',', '.'); ?></td>
                                    <td>Rp<?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>Rp<?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h2 class="h3 card-title">Lanjutkan Pemesanan</h2>
                        <p class="card-text">Klik tombol di bawah untuk melanjutkan pemesanan melalui WhatsApp:</p>
                        <a href="<?php echo $whatsapp_link; ?>" class="btn btn-success btn-lg whatsapp-button" target="_blank">
                            <i class="bi bi-whatsapp me-2"></i>Pesan via WhatsApp
                        </a>
                        <p class="mt-3 small text-muted">Anda akan diarahkan ke aplikasi WhatsApp dengan pesan yang sudah diisi otomatis.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>