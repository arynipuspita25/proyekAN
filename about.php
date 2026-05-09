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
                url('img/produk.png');
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
                AN Skin Lab is a skincare brand focused on natural skin care with lightweight and safe formulas for everyday use. Our products are designed to maintain healthy skin while enhancing a natural glowing appearance.
                We believe that skincare should not only improve beauty, but also build confidence and comfort in every daily activity. Using carefully selected ingredients, AN Skin Lab provides skincare solutions that nourish, hydrate, and protect the skin for all skin types.
                With a modern and elegant concept, AN Skin Lab is committed to delivering high-quality skincare products that support healthy, radiant, and naturally beautiful skin.
            </p>
        </div>
    </div>

    <!-- VISION -->
    <div class="row reverse">
        <img src="img/ABOUT2.jpg">
        <div class="text">
            <h2>Our Vision</h2>
            <p>
                To become a trusted skincare brand that provides natural-based products suitable for all skin types, including teenage skin. 
                we aim to empower individuals to embrace their natural beauty and achieve healthy, glowing skin through safe and affordable skincare solutions.
        
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
                <li>Providing safe and lightweight skincare treatments</li>
                <li>Helping skin stay healthy and naturally glowing</li>
                <li>Suitable for all skin types, including sensitive and teenage skin</li>
                <li>Continuously innovating modern skincare solutions</li>
                <li>Prioritizing customer satisfaction and skin health</li>
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