<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About - AN Skin Lab</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Poppins', sans-serif;
    background:#f8f6f2;
    overflow-x:hidden;
    color:#333;
}

/* ===== HERO ===== */

.hero-about{
    height:75vh;
    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('img/produk.png');
    background-size:cover;
    background-position:center;
    display:flex;
    justify-content:center;
    align-items:center;
    text-align:center;
    position:relative;
}

.hero-about::after{
    content:'';
    position:absolute;
    width:100%;
    height:120px;
    background:linear-gradient(to top,#f8f6f2,transparent);
    bottom:0;
}

.hero-content{
    position:relative;
    z-index:2;
    animation:fadeUp 1.5s ease;
}

.hero-about h1{
    font-family:'Playfair Display', serif;
    font-size:65px;
    color:white;
    letter-spacing:3px;
    margin-bottom:20px;
}

.hero-about p{
    color:#f5f5f5;
    font-size:18px;
    letter-spacing:2px;
}

/* ===== SECTION ===== */

.section{
    padding:100px 10%;
}

/* ===== ROW ===== */

.row{
    display:flex;
    align-items:center;
    gap:50px;
    margin-bottom:100px;
    position:relative;
}

.row.reverse{
    flex-direction:row-reverse;
}

/* ===== IMAGE ===== */

.row img{
    width:40%;
    border-radius:25px;
    box-shadow:0 20px 40px rgba(0,0,0,0.12);
    transition:0.5s;
}

.row img:hover{
    transform:scale(1.03);
}

/* ===== TEXT ===== */

.text{
    width:60%;
    background:rgba(255,255,255,0.8);
    backdrop-filter:blur(10px);
    padding:40px;
    border-radius:25px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    transition:0.4s;
}

.text:hover{
    transform:translateY(-5px);
}

.text h2{
    font-family:'Playfair Display', serif;
    font-size:38px;
    color:#264d3f;
    margin-bottom:20px;
    position:relative;
}

.text h2::after{
    content:'';
    width:60px;
    height:2px;
    background:#8fa88d;
    position:absolute;
    left:0;
    bottom:-10px;
}

.text p{
    margin-top:30px;
    line-height:1.9;
    color:#555;
    font-size:15px;
}

.text ul{
    margin-top:30px;
    padding-left:20px;
}

.text li{
    margin-bottom:14px;
    line-height:1.8;
    color:#555;
}

/* ===== FLOATING BLUR ===== */

.blur1,
.blur2{
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    z-index:-1;
}

.blur1{
    width:220px;
    height:220px;
    background:#d7e7d3;
    top:-50px;
    left:-80px;
}

.blur2{
    width:220px;
    height:220px;
    background:#efe2d7;
    bottom:-50px;
    right:-80px;
}

/* ===== ANIMATION ===== */

@keyframes fadeUp{
    from{
        opacity:0;
        transform:translateY(40px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ===== RESPONSIVE ===== */

@media(max-width:900px){

    .hero-about h1{
        font-size:50px;
    }

    .row,
    .row.reverse{
        flex-direction:column;
    }

    .row img,
    .text{
        width:100%;
    }

    .text{
        padding:30px;
    }

}

</style>
</head>

<body>

<?php include "layout/header.html" ?>

<!-- HERO -->
<section class="hero-about">
    <div class="hero-content">
        <h1>About Us</h1>
        <p>Luxury skincare for your natural beauty</p>
    </div>
</section>

<!-- SECTION -->
<section class="section">

<div class="blur1"></div>
<div class="blur2"></div>

<!-- WHO WE ARE -->
<div class="row">
    <img src="img/ABOUT1.jpg">

    <div class="text">
        <h2>Who We Are</h2>

        <p>
            AN Skin Lab is a premium skincare brand focused on elegant beauty, natural ingredients, and healthy glowing skin. 
            We create lightweight skincare products designed for everyday comfort while maintaining a luxurious skincare experience.
            Every formula is carefully developed to nourish, protect, and enhance natural beauty for all skin types.
        </p>
    </div>
</div>

<!-- VISION -->
<div class="row reverse">
    <img src="img/ABOUT2.jpg">

    <div class="text">
        <h2>Our Vision</h2>

        <p>
            To become a trusted modern skincare brand that inspires confidence through safe, elegant, and natural skincare solutions.
            We believe every individual deserves healthy and radiant skin with products that feel luxurious yet gentle.
        </p>
    </div>
</div>

<!-- MISSION -->
<div class="row">
    <img src="img/ABOUT3.jpg">

    <div class="text">
        <h2>Our Mission</h2>

        <ul>
            <li>Using high-quality natural ingredients</li>
            <li>Providing safe and lightweight skincare</li>
            <li>Helping skin stay healthy & glowing</li>
            <li>Suitable for all skin types</li>
            <li>Creating elegant modern skincare innovation</li>
            <li>Prioritizing customer satisfaction</li>
        </ul>
    </div>
</div>

<!-- WHY -->
<div class="row reverse">
    <img src="img/ABOUT4.jpg">

    <div class="text">
        <h2>Why Choose Us?</h2>

        <ul>
            <li>Premium Organic Ingredients</li>
            <li>Elegant Lightweight Formula</li>
            <li>Healthy Natural Glow</li>
            <li>Luxury Daily Skincare</li>
        </ul>
    </div>
</div>

</section>

<?php include "layout/footer.html" ?>

</body>
</html>