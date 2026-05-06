<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About - AN Skin Lab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
 <?php include "layout/header.html" ?>

 <!-- Hero About -->
<section class="hero-about">
    <div class="overlay">
        <h1>About Us</h1>
        <p>Soft care for your natural glow</p>
    </div>
</section>

<!-- About Section -->
<section class="about">
    <div class="container">

        <div class="about-box">
            <h2>Who We Are</h2>
            <p>
                AN Skin Lab adalah brand skincare yang berfokus pada perawatan kulit alami 
                dengan formula ringan dan aman digunakan sehari-hari. Produk kami dirancang 
                untuk membantu menjaga kesehatan kulit sekaligus memberikan tampilan glowing alami.
            </p>
        </div>

        <div class="about-box">
            <h2>Our Vision</h2>
            <p>
                Menjadi brand skincare terpercaya dengan produk berbahan alami yang cocok 
                untuk semua jenis kulit, termasuk kulit remaja.
            </p>
        </div>

        <div class="about-box">
            <h2>Our Mission</h2>
            <ul>
                <li>Menggunakan bahan alami berkualitas</li>
                <li>Memberikan perawatan yang aman & ringan</li>
                <li>Membantu kulit tetap sehat dan glowing</li>
                <li>Cocok untuk semua jenis kulit</li>
            </ul>
        </div>

        <div class="about-box">
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

</body>
</html>

<style> 
body {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    background-color: #d1d1aa;
}



/* About Section */
.about {
    padding: 60px 20px;
    text-align: center;
}

.about h1 {
    font-size: 36px;
    color: #5a7d6a;
}

.tagline {
    color: gray;
    margin-bottom: 40px;
}

.container {
    max-width: 800px;
    margin: auto;
}

.about-box {
    background: white;
    padding: 20px;
    margin: 20px 0;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    text-align: left;
}

.about-box h2 {
    color: #5a7d6a;
}

.about-box ul {
    padding-left: 20px;
}

/* Hero About */
.hero-about {
    height: 300px;
    background: url('img/keriting.jpeg') center/cover no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

/* overlay biar teks kebaca */
.hero-about .overlay {
    background: rgba(0, 0, 0, 0.3);
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
}

.hero-about h1 {
    font-size: 40px;
    margin: 0;
}

.hero-about p {
    font-size: 18px;
}
</style>