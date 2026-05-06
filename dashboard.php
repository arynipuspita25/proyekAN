```php
<?php
session_start();

if(!isset($_SESSION["username"])) {
    $_SESSION["username"] = "User";
}

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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>AN Skin Lab</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

/* HERO */
.hero {
    height: 420px;
    background: url('ss.jpeg') center/cover no-repeat;
    position: relative;
}

.overlay {
    background: rgba(255,255,255,0.6);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    color: #1f4d1f;
    text-align: center;
}

.overlay h1 {
    font-size: 42px;
    letter-spacing: 2px;
}

.overlay p {
    font-style: italic;
    margin: 10px 0;
}

.btn {
    background: #f3dcd2;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    color: black;
    transition: 0.3s;
}

.btn:hover {
    background: #e8cfc5;
}

/* PRODUK */
.product-section {
    background: #1f4d1f;
    padding: 30px;
    display: flex;
    justify-content: center;
    gap: 20px;
}

.product-section img {
    width: 300px;
    border-radius: 10px;
}

/* ICON */
.icon-section {
    display: flex;
    gap: 20px;
    padding: 20px;
}

.icon {
    font-size: 30px;
    border: 2px solid black;
    padding: 10px;
    border-radius: 50%;
}

/* USER */
.user {
    padding: 20px;
}

/* LOGOUT */
.logout {
    padding: 20px;
}

.logout button {
    padding: 10px 15px;
    background: #1f4d1f;
    color: white;
    border: none;
    border-radius: 5px;
}
</style>

</head>
<body>

<!-- NAVBAR EKSTERNAL -->
<?php include "layout/header.html"; ?>

<main>

<!-- HERO -->
<section class="hero">
    <div class="overlay">
        <h1>WELCOME TO AN SKIN LAB</h1>
        <p>soft care for your natural glow</p>
        <a href="product.php" class="btn">Order Now!</a>
    </div>
</section>

<!-- PRODUK -->
<section class="product-section">
    <img src="ss.jpeg" alt="">
    <img src="ss.jpeg" alt="">
</section>

<!-- ICON -->
<section class="icon-section">
    <div class="icon">📷</div>
    <div class="icon">📞</div>
    <div class="icon">✉️</div>
</section>

<!-- USER -->
<div class="user">
    <h3>Selamat datang, <?= $_SESSION["username"]; ?></h3>
</div>

<!-- LOGOUT -->
<form action="dashboard.php" method="POST" class="logout">
    <button type="submit" name="logout">Logout</button>
</form>

</main>

</body>
</html>
```
