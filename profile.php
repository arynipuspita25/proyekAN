<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user  = $_SESSION['id_user'];
$username = $_SESSION['username'];

// Ambil data user
$user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id_user = '$id_user'"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile – Skinlab</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --cream:#f8f5f1;
    --white:#ffffff;
    --green:#244336;
    --green2:#355c4d;
    --gold:#d8b36a;
    --text:#444;
}

body{
    font-family:'DM Sans', sans-serif;
    background:
    linear-gradient(rgba(248,245,241,0.92), rgba(248,245,241,0.92)),
    url('img/bg.jpg');
    background-size:cover;
    min-height:100vh;
    overflow-x:hidden;
}

/* ===== WRAPPER ===== */

.page-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:120px 20px 60px;
    position:relative;
}

/* ===== GLOW ===== */

.page-wrapper::before{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:#d9e6d5;
    border-radius:50%;
    filter:blur(120px);
    top:80px;
    left:-100px;
    z-index:-1;
}

.page-wrapper::after{
    content:'';
    position:absolute;
    width:300px;
    height:300px;
    background:#f1dfc7;
    border-radius:50%;
    filter:blur(120px);
    bottom:20px;
    right:-100px;
    z-index:-1;
}

/* ===== CARD ===== */

.profile-card{
    width:100%;
    max-width:470px;
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.4);
    border-radius:35px;
    overflow:hidden;
    box-shadow:
    0 20px 50px rgba(0,0,0,0.12);
    animation:fadeUp 1s ease;
    transition:.4s;
}

.profile-card:hover{
    transform:translateY(-8px);
}

/* ===== HEADER ===== */

.profile-header{
    background:
    linear-gradient(135deg,var(--green),var(--green2));
    padding:45px 35px;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
    position:relative;
}

/* ===== GOLD LINE ===== */

.profile-header::after{
    content:'';
    width:120px;
    height:3px;
    background:var(--gold);
    position:absolute;
    bottom:0;
    left:50%;
    transform:translateX(-50%);
}

/* ===== AVATAR ===== */

.avatar{
    width:110px;
    height:110px;
    background:rgba(255,255,255,0.18);
    border:3px solid rgba(255,255,255,0.3);
    border-radius:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    margin-bottom:18px;
    backdrop-filter:blur(10px);
    box-shadow:0 10px 30px rgba(0,0,0,0.2);
}

.avatar svg{
    width:58px;
    height:58px;
    fill:white;
}

/* ===== NAME ===== */

.profile-header h2{
    font-family:'Playfair Display', serif;
    color:white;
    font-size:33px;
    font-weight:600;
    letter-spacing:1px;
}

.profile-header p{
    color:rgba(255,255,255,0.8);
    margin-top:8px;
    font-size:14px;
    letter-spacing:2px;
}

/* ===== MENU ===== */

.profile-menu{
    list-style:none;
    padding:20px;
}

/* ===== ITEM ===== */

.profile-menu li{
    margin-bottom:16px;
}

.profile-menu li a{
    display:flex;
    align-items:center;
    gap:18px;
    text-decoration:none;
    background:white;
    padding:18px 22px;
    border-radius:18px;
    color:var(--text);
    font-size:16px;
    font-weight:500;
    transition:.35s;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
}

.profile-menu li a:hover{
    transform:translateX(8px);
    background:var(--green);
    color:white;
}

.profile-menu li a:hover svg{
    stroke:white;
}

/* ===== ICON ===== */

.profile-menu li a svg{
    width:22px;
    height:22px;
    stroke:var(--green);
    fill:none;
    stroke-width:2;
    transition:.3s;
}

/* ===== LOGOUT ===== */

.profile-menu li.logout a{
    background:#fff1f3;
    color:#d45b72;
}

.profile-menu li.logout a svg{
    stroke:#d45b72;
}

.profile-menu li.logout a:hover{
    background:#d45b72;
    color:white;
}

.profile-menu li.logout a:hover svg{
    stroke:white;
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

/* ===== MOBILE ===== */

@media(max-width:768px){

    .profile-card{
        max-width:100%;
    }

    .profile-header h2{
        font-size:28px;
    }

}

</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">
    <div class="profile-card">

        <!-- Header -->
        <div class="profile-header">
            <div class="avatar">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
                </svg>
            </div>
            <h2><?= htmlspecialchars($user['username']) ?></h2>
        </div>

        <!-- Menu -->
        <ul class="profile-menu">

            <li>
                <a href="editprofil.php">
                    <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit Profile
                </a>
            </li>

            <li>
                <a href="riwayat.php">
                    <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                    Order History
                </a>
            </li>

            <li class="logout">
                <a href="logout.php">
                    <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Logout
                </a>
            </li>

        </ul>
    </div>
</div>

</body>
</html>
