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

<title>Payment Successful - Skinlab</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --green:#63b95b;
    --green-hover:#4fa148;
    --dark:#163d14;
}

body{
    font-family:'Poppins', sans-serif;
    min-height:100vh;

    /* BACKGROUND */
    background-image:
    linear-gradient(rgba(255,255,255,0.60), rgba(255,255,255,0.60)),
    url("asset/img/ABOUT4.jpg");

    background-size:cover;
    background-position:center;
    background-repeat:no-repeat;
    background-attachment:fixed;
}

/* ===== CONTENT ===== */

.success-container{
    min-height:calc(100vh - 90px);

    display:flex;
    justify-content:center;
    align-items:center;

    padding:40px 20px;
}

/* ===== CARD ===== */

.success-card{

    width:620px;

    background:rgba(255,255,255,0.75);

    border-radius:28px;

    padding:55px 45px;

    text-align:center;

    backdrop-filter:blur(12px);

    box-shadow:
    0 10px 40px rgba(0,0,0,0.15);

    animation:fadeIn .6s ease;
}

/* ===== CHECK ICON ===== */

.check-wrapper{

    width:150px;
    height:150px;

    margin:auto;
    margin-bottom:28px;

    position:relative;

    display:flex;
    justify-content:center;
    align-items:center;
}

.check-wrapper::before{

    content:"";

    position:absolute;

    width:150px;
    height:150px;

    border-radius:50%;

    border:18px solid var(--green);

    border-right-color:transparent;

    transform:rotate(40deg);
}

.check-icon{

    width:78px;
    height:78px;

    border-radius:50%;

    background:var(--green);

    display:flex;
    justify-content:center;
    align-items:center;
}

.check-icon svg{

    width:42px;
    height:42px;

    stroke:white;
    stroke-width:4;

    fill:none;

    stroke-linecap:round;
    stroke-linejoin:round;
}

/* ===== TEXT ===== */

.success-title{

    font-size:56px;

    line-height:1.1;

    color:var(--dark);

    font-weight:700;

    margin-bottom:14px;
}

.success-subtitle{

    font-size:22px;

    color:#222;

    margin-bottom:42px;
}

/* ===== BUTTON ===== */

.btn-shopping{

    display:inline-flex;

    justify-content:center;
    align-items:center;

    width:360px;
    height:82px;

    border-radius:18px;

    background:var(--green);

    color:white;

    text-decoration:none;

    font-size:28px;
    font-weight:500;

    transition:.25s ease;

    box-shadow:0 8px 18px rgba(99,185,91,0.35);
}

.btn-shopping:hover{

    background:var(--green-hover);

    transform:translateY(-3px);
}

/* ===== HISTORY LINK ===== */

.history-link{

    display:inline-block;

    margin-top:22px;

    text-decoration:none;

    color:var(--dark);

    font-size:16px;
    font-weight:500;
}

.history-link:hover{
    text-decoration:underline;
}

/* ===== ANIMATION ===== */

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(25px) scale(.95);
    }

    to{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

/* ===== RESPONSIVE ===== */

@media(max-width:768px){

    .success-card{
        width:100%;
        padding:40px 24px;
    }

    .success-title{
        font-size:38px;
    }

    .success-subtitle{
        font-size:18px;
    }

    .btn-shopping{
        width:100%;
        height:68px;
        font-size:22px;
    }

    .check-wrapper{
        width:120px;
        height:120px;
    }

    .check-wrapper::before{
        width:120px;
        height:120px;
    }
}

</style>
</head>

<body>

<!-- NAVBAR -->
<?php include "layout/header.html"; ?>

<!-- CONTENT -->
<div class="success-container">

    <div class="success-card">

        <!-- CHECK ICON -->
        <div class="check-wrapper">

            <div class="check-icon">

                <svg viewBox="0 0 24 24">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>

            </div>

        </div>

        <!-- TITLE -->
        <h1 class="success-title">
            Payment Successful
        </h1>

        <!-- SUBTITLE -->
        <p class="success-subtitle">
            Thank you for your purchase! Your payment was successful.
        </p>

        <!-- BUTTON -->
        <a href="product.php" class="btn-shopping">
            Continue Shopping
        </a>

        <br>

        <!-- HISTORY -->
        <a href="riwayat.php" class="history-link">
            Lihat Riwayat Pembelian →
        </a>

    </div>

</div>

</body>
</html>