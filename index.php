<?php
session_start();
require 'db.php'; // Menghubungkan ke database

// Mengambil semua produk dari database
$query = "SELECT * FROM tb_products";
$stmt = $pdo->query($query);

// Inisialisasi cart jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Fungsi untuk menghitung total item di keranjang
function getCartItemCount() {
    return array_sum($_SESSION['cart']);
}

// Jika ada request POST untuk menambahkan ke keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = 1; // Default quantity

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }

    // Return JSON response instead of redirecting
    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan ke keranjang!',
        'cart_count' => getCartItemCount()
    ]);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Toko Online</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap Icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
        <!-- SimpleLightbox plugin CSS-->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css">

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand d-flex align-items-center" href="#page-top">
                    <img src="assets/logotokoo.png" style="width: 40px" alt="Toko Online Logo" class="navbar-logo me-2" />
                    Toko Online
                </a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="#vision-mission">Visi dan Misi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#products">Produk</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php">
                                <i class="bi bi-cart3"></i>
                                <span class="badge bg-primary rounded-pill" id="cartCount">0</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Masthead-->
        <header class="masthead">
            <div class="container px-4 px-lg-5 h-100">
                <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-8 align-self-end">
                        <h1 class="text-white font-weight-bold">Selamat Datang di Toko Online Kami</h1>
                        <hr class="divider" />
                    </div>
                    <div class="col-lg-8 align-self-baseline">
                        <p class="text-white-75 mb-5">Kami menyediakan berbagai macam produk berkualitas dengan harga terjangkau. Mulai belanja sekarang!</p>
                        <a class="btn btn-primary btn-xl" href="#products">
                            <i class="bi bi-cart-plus" style="font-size: 20px;"></i> Belanja Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- About-->
        <section class="page-section bg-primary" id="about">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="text-white mt-0">Tentang Kami</h2>
                        <hr class="divider divider-light" />
                        <p class="text-white-75 mb-4">Kami adalah toko online yang menyediakan berbagai macam produk berkualitas dengan harga terjangkau. Belanja mudah dan aman bersama kami!</p>
                        <a class="btn btn-light btn-xl" href="#services">Layanan Kami</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- Services-->
        <section class="page-section" id="services">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">Layanan Kami</h2>
                <hr class="divider" />
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-gem fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Produk Terbaik</h3>
                            <p class="text-muted mb-0">Kami hanya menjual produk-produk terbaik dan berkualitas.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Update Terkini</h3>
                            <p class="text-muted mb-0">Produk kami selalu diperbarui untuk memenuhi kebutuhan Anda.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-globe fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Siap Dikirim</h3>
                            <p class="text-muted mb-0">Produk kami siap dikirim ke seluruh Indonesia.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 text-center">
                        <div class="mt-5">
                            <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>
                            <h3 class="h4 mb-2">Layanan Pelanggan</h3>
                            <p class="text-muted mb-0">Kami siap membantu Anda dengan sepenuh hati.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Visi dan Misi -->
        <section class="page-section bg-light" id="vision-mission">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Visi dan Misi</h2>
                        <hr class="divider" />
                        <p class="text-muted mb-4">Kami memiliki visi untuk menjadi toko online terdepan dalam menyediakan produk berkualitas dan layanan terbaik. Misi kami adalah memberikan pengalaman belanja yang memuaskan dan memenuhi kebutuhan pelanggan dengan inovasi dan komitmen.</p>
                        <a class="btn btn-primary btn-xl" href="#contact">Hubungi Kami</a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Products Section -->
        <section class="page-section" id="products">
            <div class="container">
                <h2 class="text-center mt-0">Produk Kami</h2>
                <hr class="divider" />
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2 g-md-3 g-lg-4">
                    <?php
                    // Menampilkan setiap produk
                    while ($product = $stmt->fetch()) {
                        echo '<div class="col">';
                        echo '<div class="card h-100">';
                        echo '<div class="card-img-container">';
                        echo '<img src="uploads/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';
                        echo '</div>';
                        echo '<div class="card-body">';
                        echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
                        echo '<p class="card-text">Rp' . number_format($product['price'], 2, ',', '.') . '</p>';
                        echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
                        echo '<form class="add-to-cart-form">';
                        echo '<input type="hidden" name="product_id" value="' . $product['id'] . '">';
                        echo '<button type="submit" class="btn btn-primary w-100">Tambah ke Keranjang</button>';
                        echo '</form>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <style>
                .card-img-container {
                    width: 100%;
                    padding-top: 75%; 
                    position: relative;
                    overflow: hidden;
                }
                .card-img-top {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .card-body {
                    display: flex;
                    flex-direction: column;
                }
                .card-title {
                    font-size: 1rem;
                }
                .card-text {
                    font-size: 0.875rem;
                    flex-grow: 1;
                }
                @media (max-width: 575.98px) {
                    .card-title {
                        font-size: 0.875rem;
                    }
                    .card-text {
                        font-size: 0.75rem;
                    }
                    .btn {
                        font-size: 0.75rem;
                        padding: 0.25rem 0.5rem;
                    }
                }
            </style>
        </section>

        <!-- Contact -->
        <section class="page-section bg-light" id="contact">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-lg-8 col-xl-6 text-center">
                <h2 class="mt-0">Hubungi Kami Untuk Kerja Sama</h2>
                <hr class="divider" />
                <p class="text-muted mb-5">Siap memulai proyek berikutnya dengan kami? Hubungi kami melalui Instagram, WhatsApp, atau Gmail!</p>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center mb-5">
            <div class="col-lg-6 text-center d-flex justify-content-center">
                <a href="https://www.instagram.com/irziahmd_" class="btn btn-primary btn-xl mx-2" target="_blank">
                    <i class="bi bi-instagram"></i> Instagram
                </a>
                <a href="https://wa.me/6289612990205" class="btn btn-success btn-xl mx-2" target="_blank">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>
                <a href="mailto:irzifahrozi09@gmail.com" class="btn btn-danger btn-xl mx-2" target="_blank">
                    <i class="bi bi-envelope-fill"></i> Gmail
                </a>
            </div>
        </div>
    </div>
</section>




        <script>
            function sendWhatsApp() {
                var name = encodeURIComponent(document.getElementById("name").value);
                var email = encodeURIComponent(document.getElementById("email").value);
                var phone = encodeURIComponent(document.getElementById("phone").value);
                var message = encodeURIComponent(document.getElementById("message").value);

                var whatsappMessage = "Halo, saya " + name + ".%0A%0A" +
                                      "Email: " + email + "%0A" +
                                      "Nomor Telepon: " + phone + "%0A%0A" +
                                      "Pesan:%0A" + message;

                var whatsappURL = "https://wa.me/62895320697402?text=" + whatsappMessage;

                window.open(whatsappURL, "_blank");
            }
        </script>

        <!-- Footer-->
        <footer class="bg-white py-1">
            <div class="container px-4 px-lg-5">
                <div class="small text-center text-secondary">Copyright &copy; 2024 - Toko Online</div>
            </div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
         <!-- Add to Cart JavaScript -->
         <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update cart count in navbar
        function updateCartCount(count) {
            const cartCountElement = document.getElementById('cartCount');
            cartCountElement.textContent = count;
        }

        // Initialize cart count
        updateCartCount(<?php echo getCartItemCount(); ?>);

        // Handle add to cart
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const productId = this.querySelector('input[name="product_id"]').value;
                const formData = new FormData();
                formData.append('add_to_cart', '1');
                formData.append('product_id', productId);

                fetch('index.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update the cart count
                        updateCartCount(data.cart_count);

                        // Show a success message
                        const successMessage = document.createElement('div');
                        successMessage.className = 'alert alert-success mt-2';
                        successMessage.textContent = data.message;
                        this.appendChild(successMessage);

                        // Remove success message after 3 seconds
                        setTimeout(() => {
                            successMessage.remove();
                        }, 3000);
                    } else {
                        alert('Terjadi kesalahan saat menambahkan produk ke keranjang.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan pada jaringan.');
                });
            });
        });
    });
    </script>
        <script>
        // Update cart count in navbar
        function updateCartCount() {
            const cartCountElement = document.getElementById('cartCount');
            cartCountElement.textContent = '<?php echo getCartItemCount(); ?>';
        }

        // Call updateCartCount when the page loads
        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>
    </body>
</html> 