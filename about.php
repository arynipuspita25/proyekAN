<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>About - AN Skin Lab</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

<style>
body { 
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background: #f4f7f2;
}

/* HERO */
.hero-about {
    height: 350px;
    background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)),
                url('img/keriting.jpg');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
}

.hero-about h1 {
    font-family: 'Playfair Display', serif;
    font-size: 50px;
    margin: 0;
}

/* SECTION */
.section {
    padding: 80px 10%;
}

/* FLEX LAYOUT */
.row {
    display: flex;
    align-items: center;
    gap: 40px;
    margin-bottom: 80px;
}

.row.reverse {
    flex-direction: row-reverse;
}

.row img {
    width: 45%;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.text {
    width: 55%;
}

.text h2 {
    font-family: 'Playfair Display', serif;
    color: #2f5d50;
    font-size: 30px;
}

.text p {
    line-height: 1.7;
    color: #444;
}

/* LIST STYLE */
.text ul {
    padding-left: 20px;
}

.text li {
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .row {
        flex-direction: column;
    }
    .row.reverse {
        flex-direction: column;
    }
    .row img,
    .text {
        width: 100%;
    }
}
</style>
</head>

<body>

<?php include "layout/header.html" ?>

<!-- HERO -->
<section class="hero-about">
    <div>
        <h1>About Us</h1>
        <p>Soft care for your natural glow</p>
    </div>
</section>

<!-- ABOUT CONTENT -->
<section class="section">

    <!-- WHO WE ARE -->
    <div class="row">
        <img src="img/ABOUT1.jpg">
        <div class="text">
            <h2>Who We Are</h2>
            <p>
                AN Skin Lab adalah brand skincare yang berfokus pada perawatan kulit alami dengan formula ringan dan aman 
                digunakan sehari-hari. Produk kami membantu menjaga kesehatan kulit sekaligus memberikan tampilan glowing alami.
            </p>
        </div>
    </div>

    <!-- VISION -->
    <div class="row reverse">
        <img src="img/ABOUT2.jpg">
        <div class="text">
            <h2>Our Vision</h2>
            <p>
                Menjadi brand skincare terpercaya dengan produk berbahan alami yang cocok untuk semua jenis kulit, termasuk kulit remaja.
            </p>
        </div>
    </div>

    <!-- MISSION -->
    <div class="row">
        <img src="img/ABOUT3.jpg">
        <div class="text">
            <h2>Our Mission</h2>
            <ul>
                <li>Menggunakan bahan alami berkualitas</li>
                <li>Memberikan perawatan yang aman & ringan</li>
                <li>Membantu kulit tetap sehat dan glowing</li>
                <li>Cocok untuk semua jenis kulit</li>
            </ul>
        </div>
    </div>

    <!-- WHY -->
    <div class="row reverse">
        <img src="img/ABOUT4.jpg">
        <div class="text">
            <h2>Why Choose Us?</h2>
            <ul>
                <li>Organic Ingredients</li>
                <li>Lightweight & Non-Greasy</li>
                <li>Daily Protection</li>
                <li>All Skin Types</li>
            </ul>
        </div>
    </div>

</section>
<!-- ===== FOOTER ===== -->
<?php include "layout/footer.html" ?>

</body>
</html>