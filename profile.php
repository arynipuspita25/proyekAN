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
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --cream: #f3eee9;
    --white: #ffffff;
    --green: #2d4d2c;
    --gold:  #e0a94f;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

.page-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80vh;
    padding: 40px 20px;
}

/* ===== CARD ===== */
.profile-card {
    background: var(--green);
    border-radius: 20px;
    width: 100%;
    max-width: 460px;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(0,0,0,0.15);
}

/* Header user */
.profile-header {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 28px 30px;
    border-bottom: 1px solid rgba(255,255,255,0.15);
}

.avatar {
    width: 60px;
    height: 60px;
    background: #c8c8c8;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.avatar svg {
    width: 36px;
    height: 36px;
    fill: #888;
}

.profile-header h2 {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: white;
    font-weight: 600;
}

/* Menu */
.profile-menu {
    list-style: none;
    padding: 10px 0;
}

.profile-menu li a {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 18px 30px;
    color: white;
    text-decoration: none;
    font-size: 17px;
    font-weight: 400;
    transition: background 0.2s;
}

.profile-menu li a:hover {
    background: rgba(255,255,255,0.08);
}

.profile-menu li a svg {
    width: 20px;
    height: 20px;
    stroke: rgba(255,255,255,0.7);
    fill: none;
    stroke-width: 2;
    flex-shrink: 0;
}

.profile-menu li.logout a {
    color: #ffb6c1;
}

.profile-menu li.logout a svg {
    stroke: #ffb6c1;
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
            <h2>$<?= htmlspecialchars($user['username']) ?></h2>
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
