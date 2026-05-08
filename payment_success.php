<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Successful – Skinlab</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --cream:  #f3eee9;
    --white:  #ffffff;
    --green:  #2d4d2c;
    --gold:   #e0a94f;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

.success-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 70vh;
    text-align: center;
    padding: 40px 20px;
}

/* Animated checkmark */
.check-circle {
    width: 80px;
    height: 80px;
    background: var(--green);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 28px;
    animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes popIn {
    0%   { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

.check-circle svg {
    width: 40px;
    height: 40px;
    stroke: white;
    stroke-width: 3;
    fill: none;
    stroke-dasharray: 60;
    stroke-dashoffset: 60;
    animation: drawCheck 0.4s 0.4s ease forwards;
}

@keyframes drawCheck {
    to { stroke-dashoffset: 0; }
}

.success-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    color: var(--green);
    margin-bottom: 12px;
    animation: fadeUp 0.5s 0.3s both;
}

.success-sub {
    font-size: 15px;
    color: #666;
    margin-bottom: 36px;
    animation: fadeUp 0.5s 0.5s both;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
}

.btn-shopping {
    display: inline-block;
    padding: 14px 36px;
    background: var(--gold);
    color: white;
    border-radius: 30px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: background 0.2s, transform 0.15s;
    animation: fadeUp 0.5s 0.7s both;
}

.btn-shopping:hover {
    background: #c9922e;
    transform: translateY(-2px);
}

.btn-riwayat {
    display: inline-block;
    margin-top: 14px;
    font-size: 13px;
    color: var(--green);
    text-decoration: underline;
    cursor: pointer;
    animation: fadeUp 0.5s 0.9s both;
}

.btn-riwayat:hover { opacity: 0.7; }
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="success-wrapper">

    <!-- Animated Check -->
    <div class="check-circle">
        <svg viewBox="0 0 24 24">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>

    <h1 class="success-title">Payment Successful</h1>
    <p class="success-sub">Thank you for your purchase! Your payment was successful.</p>

    <a href="product.php" class="btn-shopping">Continue Shopping</a>
    <br>
    <a href="riwayat.php" class="btn-riwayat">Lihat Riwayat Pembelian →</a>

</div>

</body>
</html>
