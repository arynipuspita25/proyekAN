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
        <img src="img/produk.png">
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
<?php include "layout/footer.html" ?>

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
/* HERO */
.hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 60px 80px;
    background: #f7dfe3;
    position: relative;
    overflow: hidden;
    min-height: 320px;
    gap: 40px;
}


/* Gambar kiri */
.hero-left img {
    width: 320px;
    height: 400px;
    object-fit: cover;
    border-radius: 160px 160px 12px 12px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.12);
    position: relative;
    z-index: 1;
}
/* Tengah */
.hero-center {
    text-align: center;
    flex: 1;
    position: relative;
    z-index: 1;
}

.hero-center h1 {
    font-family: Georgia, serif;
    font-size: 32px;
    font-weight: 400;
    color: #2d4d2c;
    line-height: 1.3;
    margin-bottom: 6px;
}

.hero-center p {
    font-size: 13px;
    letter-spacing: 3px;
    color: #e0a94f;
    margin-bottom: 28px;
    text-transform: uppercase;
}

/* Search bar */
.hero-center form {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    flex-wrap: wrap;
}

.hero-center input {
    padding: 12px 22px;
    border-radius: 30px;
    border: 1.5px solid #e0b8bf;
    background: white;
    color: #333;
    font-size: 14px;
    width: 260px;
    outline: none;
    transition: box-shadow 0.2s;
}

.hero-center input::placeholder {
    color: #bbb;
}

.hero-center input:focus {
    box-shadow: 0 0 0 2px rgba(224,169,79,0.4);
    border-color: #e0a94f;
}

.btn-reset {
    padding: 11px 18px;
    border-radius: 30px;
    background: white;
    color: #888;
    text-decoration: none;
    font-size: 13px;
    border: 1.5px solid #ddd;
    transition: border-color 0.2s, color 0.2s;
}

.btn-reset:hover {
    border-color: #2d4d2c;
    color: #2d4d2c;
}

.btn-reset {
    padding: 11px 18px;
    border-radius: 30px;
    background: rgb(238, 115, 187);
    color: rgba(255,255,255,0.7);
    text-decoration: none;
    font-size: 13px;
    border: 1px solid rgba(255,255,255,0.2);
    transition: background 0.2s;
}

.btn-reset:hover {
    background: rgba(230, 117, 173, 0.61);
    color: white;
}

/* Gambar kanan */
.hero-right img {
    width: 180px;
    height: 220px;
    object-fit: cover;
    border-radius: 12px 12px 90px 90px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    transform: rotate(6deg);
    position: relative;
    z-index: 1;
    transition: transform 0.3s;
}

.hero-right img:hover {
    transform: rotate(0deg) scale(1.03);
}

/* Responsive hero */
@media (max-width: 900px) {
    .hero {
        flex-direction: column;
        padding: 50px 30px;
        text-align: center;
    }

    .hero-left, .hero-right {
        display: none;
    }

    .hero-center input {
        width: 200px;
    }
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