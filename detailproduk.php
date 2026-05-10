<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

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

    <div class="product-image">
        <img src="img/<?= $data['gambar']; ?>">
    </div>

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
    gap: 80px;
    padding: 80px 8vw;
    align-items: center;
    justify-content: space-between;
    min-height: 85vh; /* biar full layar laptop */
    box-sizing: border-box;
}

.product-image {
    flex: 1;
    display: flex;
    justify-content: center;
}

.product-image img {
    width: 100%;
    max-width: 420px;
    border-radius: 18px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.18);
    transition: 0.3s ease;
}

.product-image img:hover {
    transform: scale(1.03);
}

.product-info {
    flex: 1.2;
    max-width: 600px;
}

.product-info h2 {
    font-size: 28px;
    color: #2d4d2c;
    font-weight: 600;
}

.price {
    color: #e0a94f;
    font-size: 38px;
    margin: 18px 0;
    font-weight: bold;
}

.benefits {
    list-style: none;
    padding: 0;
    color: #333;
    margin: 15px 0;
}

.benefits li {
    margin: 7px 0;
    font-size: 14px;
}

hr {
    border: none;
    height: 1px;
    background: #ddd;
    margin: 25px 0;
}

.qty-box {
    display: inline-flex;
    align-items: center;
    background: #e0a94f;
    border-radius: 12px;
    overflow: hidden;
}

.qty-box button {
    border: none;
    padding: 12px 16px;
    cursor: pointer;
    background: none;
    font-size: 18px;
    transition: 0.2s;
}

.qty-box button:hover {
    background: rgba(0,0,0,0.1);
}

.qty-box span {
    padding: 0 22px;
    font-weight: bold;
}

.tombol-group {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-top: 20px;
}

.cart-btn {
    background: #2d4d2c;
    border: none;
    padding: 14px 30px;
    border-radius: 30px;
    color: #eae8e8;
    font-size: 14px;
    cursor: pointer;
    transition: 0.3s ease;
}

.cart-btn:hover {
    background: #ffa3b0;
    transform: translateY(-2px);
}

.lihat-cart-btn {
    background: #2d4d2c;
    color: white;
    padding: 14px 22px;
    border-radius: 30px;
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
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 12px;
    font-weight: bold;
}

.pesan-error {
    color: #a00;
    background: #fdecea;
    padding: 12px 15px;
    border-radius: 10px;
    margin-bottom: 12px;
}

.description {
    width: 90%;
    padding-inline: 5vw;
    padding-block: 20px;

    line-height: 1.3;
    text-align: justify;

    color: #444;
    font-size: 18px;
}

@media (max-width: 900px) {
    .product-detail {
        flex-direction: column;
        padding: 50px 20px;
        gap: 40px;
        text-align: center;
    }

    .product-info {
        max-width: 100%;
    }

    .product-image img {
        max-width: 320px;
    }

    .tombol-group {
        justify-content: center;
    }
}
</style>

</html>