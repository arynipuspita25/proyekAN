<?php
session_start();
include "service/database.php";

$keyword = $_GET['search'] ?? '';

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

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>

<body>

<?php include "layout/header.html" ?>

<div class="hero">

    <!-- KIRI -->
    <div class="hero-left">
        <img src="img/keriting.jpg">
    </div>

    <div class="hero-right">

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

            <button type="submit">⌕</button>

            <input 
                type="text" 
                name="search" 
                placeholder="Search product..."
                value="<?= $keyword ?>"
            >

        </form>

    </div>

</div>

<div class="product-list">

<?php while($row = mysqli_fetch_assoc($result)) : ?>

    <a href="detailproduk.php?id=<?= $row['id_produk']; ?>" class="product-card">

        <img src="img/<?= $row['gambar']; ?>">

        <h3><?= $row['nama_produk']; ?></h3>

        <div class="price">
            Rp <?= number_format($row['harga_produk'], 0, ',', '.'); ?>,00
        </div>

</a>

<?php endwhile; ?>

</div>

</body>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    background:#F3EFEB;
}

/* HERO */

.hero{
    display:flex;
    width:100%;
}

.hero-left{
    width:66%;
}

.hero-left img{
    width:100%;
    height:450px;
    object-fit:cover;
    display:block;
}

.hero-right{
    width:34%;
    background:#FCF0EE;
    padding:55px 35px;
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.hero-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:10px;
}

.hero-top img{
    width:160px;
    transform:rotate(12deg);
}

.hero-right h1{
    color:#214321;
    font-size:28px;
    line-height:1.5;
    letter-spacing:5px;
    font-weight:400;
}

.hero-right p{
    margin-top:10px;
    margin-bottom:35px;
    color:#214321;
    letter-spacing:5px;
    font-size:14px;
}

.hero-right form{
    display:flex;
    align-items:center;
    border:2px solid #555;
    border-radius:40px;
    overflow:hidden;
    background:white;
    max-width:280px;
}

.hero-right button{
    border:none;
    background:white;
    font-size:24px;
    padding:10px 15px;
    cursor:pointer;
}

.hero-right input{
    border:none;
    outline:none;
    width:100%;
    padding:14px;
    font-size:14px;
}

.product-list{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:35px;
    padding:55px;
}

.product-card{
    background:#173D08;
    padding:18px;
    border-radius:14px;
    text-decoration:none;
    transition:0.35s ease;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    position:relative;
    overflow:hidden;
}

.product-card:hover{
    transform:translateY(-12px) scale(1.03);
    box-shadow:0 20px 35px rgba(0,0,0,0.18);
}

.product-card:active{
    transform:scale(0.96);
}

.product-card::after{
    content:"View Detail";
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.45);
    color:white;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:20px;
    letter-spacing:2px;
    opacity:0;
    transition:0.3s ease;
}

.product-card:hover::after{
    opacity:1;
}

.product-card img{
    width:100%;
    height:320px;
    object-fit:cover;
    border-radius:10px;
    transition:0.35s ease;
}

.product-card:hover img{
    transform:scale(1.05);
}

.product-card h3{
    color:white;
    font-size:16px;
    margin-top:15px;
    margin-bottom:20px;
    font-weight:500;
    position:relative;
    z-index:2;
}

.price{
    color:white;
    text-align:right;
    font-size:16px;
    position:relative;
    z-index:2;
}

@media(max-width:900px){

    .hero{
        flex-direction:column;
    }

    .hero-left,
    .hero-right{
        width:100%;
    }

    .product-list{
        grid-template-columns:1fr 1fr;
    }

}

@media(max-width:600px){

    .product-list{
        grid-template-columns:1fr;
        padding:20px;
    }

}

</style>

</html>