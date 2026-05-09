<?php
session_start();
require "service/database.php";

// Sementara untuk testing
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// ambil id dari product.php
$id = $_POST['id_produk'] ?? $_GET['id'] ?? 0;

// ambil data produk
$query = "SELECT * FROM produk WHERE id_produk = '$id'";
$result = mysqli_query($db, $query);
$data = mysqli_fetch_assoc($result);

// default qty
$qty = $_POST['quantity'] ?? 1;

// tombol +
if (isset($_POST['plus'])) {
    $qty++;
}

// tombol -
if (isset($_POST['minus'])) {
    if ($qty > 1) $qty--;
}

// pesan
$pesan_sukses = "";
$pesan_error  = "";

// ADD TO CART
if (isset($_POST['add'])) {
    if ($qty > 0 && $id > 0) {

        $cek = mysqli_query($db, "
            SELECT * FROM keranjang 
            WHERE id_user = '$id_user' AND id_produk = '$id'
        ");

        if (mysqli_num_rows($cek) > 0) {
            $row_cek  = mysqli_fetch_assoc($cek);
            $qty_baru = $row_cek['quantity'] + $qty;
            mysqli_query($db, "UPDATE keranjang SET quantity='$qty_baru' WHERE id_user='$id_user' AND id_produk='$id'");
        } else {
            mysqli_query($db, "INSERT INTO keranjang (id_user, id_produk, quantity) VALUES ('$id_user', '$id', '$qty')");
        }

        $pesan_sukses = "✅ Produk berhasil ditambahkan ke keranjang!";

    } else {
        $pesan_error = "Quantity harus lebih dari 0!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Detail Produk</title>
</head>

<body>
<?php include "layout/header.html" ?>

<div class="product-detail">

    <!-- KIRI -->
    <div class="product-image">
        <img src="img/<?= $data['gambar']; ?>">
    </div>

    <!-- KANAN -->
    <div class="product-info">

        <h2><?= $data['nama_produk']; ?></h2>

        <h1 class="price">
            Rp <?= number_format($data['harga_produk'],0,',','.'); ?>
        </h1>

        <ul class="benefits">
            <li>✔ Natural Ingredients</li>
            <li>✔ Lightweight & Non-Greasy</li>
            <li>✔ Daily Protection</li>
        </ul>

        <hr>

        <!-- FORM -->
        <form method="POST">
            <input type="hidden" name="id_produk" value="<?= $id ?>">

            <p>Quantity</p>

            <div class="qty-box">
                <button name="minus">-</button>
                <span><?= $qty ?></span>
                <button name="plus">+</button>
            </div>

            <input type="hidden" name="quantity" value="<?= $qty ?>">

            <br><br>

            <!-- PESAN -->
            <?php if ($pesan_sukses): ?>
                <p class="pesan-sukses"><?= $pesan_sukses ?></p>
            <?php endif; ?>

            <?php if ($pesan_error): ?>
                <p class="pesan-error"><?= $pesan_error ?></p>
            <?php endif; ?>

            <div class="tombol-group">
                <button type="submit" name="add" class="cart-btn">
                    🛒 Add to Cart
                </button>

                <?php if ($pesan_sukses): ?>
                    <a href="cart.php" class="lihat-cart-btn">Lihat Cart →</a>
                <?php endif; ?>
            </div>

        </form>

    </div>
</div>

<!-- DESKRIPSI -->
<div class="description">
    <p><?= nl2br($data['deskripsi']); ?></p>
</div>

</body>

<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f3eee9;
}

.product-detail {
    display: flex;
    gap: 50px;
    padding: 60px 100px;
    align-items: center;
}

.product-image img {
    width: 350px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.product-info {
    max-width: 500px;
}

.product-info h2 {
    font-size: 24px;
    color: #2d4d2c;
}

.price {
    color: #e0a94f;
    font-size: 34px;
    margin: 15px 0;
}

.benefits {
    list-style: none;
    padding: 0;
    color: #333;
}

.benefits li {
    margin: 5px 0;
}

.qty-box {
    display: inline-flex;
    align-items: center;
    background: #e0a94f;
    border-radius: 10px;
    overflow: hidden;
}

.qty-box button {
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    background: none;
    font-size: 18px;
}

.qty-box span {
    padding: 0 20px;
    font-weight: bold;
}

.tombol-group {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.cart-btn {
    background: #ffb6c1;
    border: none;
    padding: 12px 25px;
    border-radius: 25px;
    color: #333;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s;
}

.cart-btn:hover {
    background: #ffa3b0;
}

.lihat-cart-btn {
    background: #2d4d2c;
    color: white;
    padding: 12px 20px;
    border-radius: 25px;
    text-decoration: none;
    font-size: 14px;
    transition: 0.3s;
}

.lihat-cart-btn:hover {
    background: #1e3a1d;
}

.pesan-sukses {
    color: #2d7a2d;
    background: #e6f4ea;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 10px;
    font-weight: bold;
}

.pesan-error {
    color: #a00;
    background: #fdecea;
    padding: 10px 15px;
    border-radius: 8px;
    margin-bottom: 10px;
}

.description {
    padding: 30px 100px;
    line-height: 1.8;
    color: #444;
    max-width: 900px;
}

@media (max-width: 900px) {
    .product-detail {
        flex-direction: column;
        padding: 40px;
    }

    .product-image img {
        width: 100%;
        max-width: 300px;
    }
}
</style>

</html>