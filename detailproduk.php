<?php
session_start();
require "service/database.php";

// ambil id dari product.php
$id = $_GET['id'] ?? 0;

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

// ADD TO CART
if (isset($_POST['add'])) {

    if ($qty > 0) {

        // contoh sederhana (nanti kita upgrade ke tabel keranjang)
        echo "<script>alert('Produk berhasil ditambahkan ke keranjang!')</script>";

    } else {
        echo "<script>alert('Quantity harus lebih dari 0!')</script>";
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

            <p>Quantity</p>

            <div class="qty-box">
                <button name="minus">-</button>
                <span><?= $qty ?></span>
                <button name="plus">+</button>
            </div>

            <input type="hidden" name="quantity" value="<?= $qty ?>">

            <br><br>

            <button type="submit" name="add" class="cart-btn">
                🛒 Add to Cart
            </button>

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

/* CONTAINER */
.product-detail {
    display: flex;
    gap: 50px;
    padding: 60px 100px;
    align-items: center;
}

/* IMAGE */
.product-image img {
    width: 350px;
    border-radius: 15px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

/* INFO */
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

/* BENEFITS */
.benefits {
    list-style: none;
    padding: 0;
    color: #333;
}

.benefits li {
    margin: 5px 0;
}

/* QTY */
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

/* BUTTON */
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

/* DESKRIPSI */
.description {
    padding: 30px 100px;
    line-height: 1.8;
    color: #444;
    max-width: 900px;
}

/* RESPONSIVE */
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