<?php
    session_start();
    
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header('location: index.php');
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "layout/header.html" ?>
<main>
    <h3> selamat datang <?= $_SESSION["username"] ?></h3>
    <h1> AN SKIN LAB </h1>
    <p></p>
    <form action="dashboard.php" method="POST">
        <button type="submit" name="logout">logout</button>
    </form>

<main>

    <!-- HERO -->
    <section class="hero">

        <div class="hero-text">
            <h1>Glow Your Natural Beauty</h1>
            <p>Discover skincare that makes your skin healthy and radiant.</p>
            <button>Shop Now</button>
            <a href="product.php" class="btn-shopnow">Shop Now</a>
        </div>

        <div class="hero-image"></div>

    </section>

 

    

</main>
</main>
</body>
</html>