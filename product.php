<?php
session_start();
include "service/database.php";

$keyword = $_GET['search'] ?? '';

// QUERY DATABASE
if ($keyword != '') {
    $query = "SELECT * FROM produk 
              WHERE nama_produk LIKE '%$keyword%'";
} else {
    $query = "SELECT * FROM produk";
}

$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Our Products</title>
</head>

<body>

<?php include "layout/header.html" ?>

<div class="hero">

    <!-- kiri -->
    <div class="hero-left">
        <img src="img/keriting.jpeg">
    </div>

    <!-- tengah -->
    <div class="hero-center">
        <h1>Natural Glow Organic Skincare</h1>
        <p>- Special Series -</p>

        <form method="GET">
            <input type="text" name="search" placeholder="Search product..." value="<?= $keyword ?>">
            <button type="submit">🔍</button>
            <a href="product.php" class="btn-reset">Reset</a>
        </form>
    </div>

    <!-- kanan -->
    <div class="hero-right">
        <img src="img/cream.jpg">
    </div>

</div>

<h2>Our Products</h2>

<div class="product-list">

<?php while($row = mysqli_fetch_assoc($result)) : ?>

    <div class="product-card">
        <img src="img/<?= $row['gambar']; ?>">

        <h3><?= $row['nama_produk']; ?></h3>

        <p><?= substr($row['deskripsi'], 0, 40); ?>...</p>

        <div class="price">
            Rp <?= number_format($row['harga_produk'], 0, ',', '.'); ?>
        </div>

        <!-- 🔥 INI YANG PALING PENTING -->
        <a href="detailproduk.php?id=<?= $row['id_produk']; ?>" class="btn-detail">
            Detail
        </a>
    </div>

<?php endwhile; ?>

</div>

</body>

<style>
body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
}

h2 {
    text-align: center;
    margin: 30px 0;
    color: #2d4d2c;
}

.product-list {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    padding: 20px 60px;
    justify-items: center;
}

.product-card {
    background-color: #1f3d1f;
    border-radius: 12px;
    overflow: hidden;
    text-align: center;
    color: white;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    width: 100%;
    max-width: 260px;
}

.product-card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 12px 25px rgba(0,0,0,0.25);
    border: 1px solid #ffb6c1;
}

.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-card:hover img {
    transform: scale(1.05);
}

.product-card h3 {
    margin: 10px 0 5px;
}

.product-card p {
    font-size: 14px;
    color: #dcdcdc;
}

.price {
    font-weight: bold;
    margin: 10px 0;
}

.btn-detail {
    display: inline-block;
    margin-bottom: 15px;
    padding: 8px 15px;
    border-radius: 20px;
    background-color: #ffb6c1;
    color: #333;
    text-decoration: none;
}

.btn-detail:hover {
    background-color: #ffa3b0;
}

/* HERO */
.hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 50px 80px;
    background: #f3eee9;
}

.hero-left img {
    max-width: 400px;
    border-radius: 12px;
}

.hero-center {
    text-align: center;
}

.hero-center input {
    padding: 10px;
    border-radius: 20px;
}

.hero-right img {
    width: 180px;
    transform: rotate(-15deg);
}

.btn-reset {
    margin-left: 10px;
    padding: 8px 12px;
    background: #ccc;
    border-radius: 15px;
    text-decoration: none;
}

/* RESPONSIVE */
@media (max-width: 900px) {
    .product-list {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .product-list {
        grid-template-columns: 1fr;
    }
}
</style>

</html>