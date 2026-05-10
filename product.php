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

    <div class="hero-left">
        <img src="img/keriting.jpg">
    </div>

    <div class="hero-center">

        <div class="hero-top">
            <h1>
                Natural <br>
                Glow <br>
                Organic <br>
                Skincare
            </h1>

            <img src="img/cream.jpg">
        </div>

        <p>- Special Series -</p>

        <form method="GET">
            <button type="submit">🔍</button>

            <input 
                type="text" 
                name="search" 
                placeholder="Search product..." 
                value="<?= $keyword ?>"
            >

        </form>

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

        <a href="detailproduk.php?id=<?= $row['id_produk']; ?>" class="btn-detail">
            Detail
        </a>

    </div>

<?php endwhile; ?>

</div>

<?php include "layout/footer.html" ?>

</body>

<style>

body{
    margin:0;
    font-family:'Poppins', Arial, sans-serif;
    background:#f5f5f5;
    -webkit-font-smoothing:antialiased;
}

.hero{
    display:flex;
    width:100%;
    background:#FCF0EE;
}

.hero-left{
    width:65%;
}

.hero-left img{
    width:100%;
    height:520px;
    object-fit:cover;
    display:block;
}

.hero-center{
    width:35%;
    padding:60px 35px;
    box-sizing:border-box;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.hero-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
}

.hero-top img{
    width:200px;
    transform:rotate(8deg);
}

.hero-center h1{
    font-size:52px;
    line-height:1.2;
    color:#214321;
    font-weight:500;
    letter-spacing:3px;
    margin:0;
}

.hero-center p{
    font-size:14px;
    letter-spacing:6px;
    color:#214321;
    margin-top:12px;
    margin-bottom:35px;
}

.hero-center form{
    display:flex;
    align-items:center;
    border:2px solid #222;
    border-radius:40px;
    overflow:hidden;
    width:100%;
    max-width:340px;
    background:white;
}

.hero-center button{
    border:none;
    background:white;
    font-size:20px;
    padding:14px 16px;
    cursor:pointer;
}

.hero-center input{
    border:none;
    outline:none;
    width:100%;
    padding:14px;
    font-size:14px;
}

h2{
    text-align:center;
    margin:50px 0 30px;
    color:#214321;
    font-size:28px;
    font-weight:600;
}

.product-list{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:30px;
    padding:20px 60px 60px;
}

.product-card{
    background:#173d08;
    color:white;
    padding:14px;
    border-radius:12px;
    transition:0.3s ease;
    box-shadow:0 4px 15px rgba(0,0,0,0.08);
}

.product-card:hover{
    transform:translateY(-6px);
    box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.product-card img{
    width:100%;
    height:440px;
    object-fit:cover;
    border-radius:8px;
}

.product-card h3{
    font-size:15px;
    margin:12px 0 6px;
    font-weight:600;
}

.product-card p{
    color:#d9d9d9;
    font-size:12px;
    line-height:1.4;
}

.price{
    text-align:right;
    font-size:15px;
    margin-top:12px;
    margin-bottom:10px;
    color:#EDBB5C;
    font-weight:600;
}

.btn-detail{
    display:inline-block;
    padding:10px 18px;
    background:pink;
    color:#333;
    text-decoration:none;
    border-radius:20px;
    font-size:13px;
    transition:0.25s ease;
}

.btn-detail:hover{
    transform:translateY(-2px);
    box-shadow:0 6px 12px rgba(0,0,0,0.2);
}

.btn-detail:active{
    transform:scale(0.95);
    box-shadow:none;
}

@media(max-width:900px){
    .hero{
        flex-direction:column;
    }

    .hero-left,
    .hero-center{
        width:100%;
    }

    .product-list{
        grid-template-columns:1fr 1fr;
        padding:20px;
    }
}

@media(max-width:600px){
    .product-list{
        grid-template-columns:1fr;
    }
}

</style>

</html>