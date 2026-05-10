<<<<<<< HEAD
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AN Skin Lab – Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --cream:   #f3eee9;
        --beige:   #e8dfd8;
        --green:   #2d4d2c;
        --green2:  #1e3a1d;
        --gold:    #e0a94f;
        --pink:    #ffb6c1;
        --white:   #ffffff;
        --text:    #2a2a2a;
        --muted:   #888;
    }

    html { scroll-behavior: smooth; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--cream);
        color: var(--text);
        overflow-x: hidden;
    }

    .welcome-bar {
        background: var(--green);
        color: rgba(255,255,255,0.85);
        text-align: center;
        padding: 10px;
        font-size: 13px;
        letter-spacing: 1.5px;
    }

    .welcome-bar span {
        color: var(--gold);
        font-weight: 500;
    }

    .hero {
        min-height: 92vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
        position: relative;
        overflow: hidden;
    }

    .hero-left {
        background: var(--green);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px 70px;
        position: relative;
        z-index: 1;
    }

    .hero-left::after {
        content: '';
        position: absolute;
        right: -60px;
        top: 0;
        bottom: 0;
        width: 120px;
        background: var(--green);
        clip-path: polygon(0 0, 0% 100%, 100% 100%);
        z-index: 2;
    }

    .hero-eyebrow {
        font-size: 11px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeUp 0.7s 0.2s forwards;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(42px, 5vw, 68px);
        font-weight: 300;
        line-height: 1.1;
        color: var(--white);
        margin-bottom: 24px;
        opacity: 0;
        animation: fadeUp 0.7s 0.4s forwards;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold);
    }

    .hero-desc {
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255,255,255,0.65);
        max-width: 380px;
        margin-bottom: 40px;
        opacity: 0;
        animation: fadeUp 0.7s 0.6s forwards;
    }

    .hero-btns {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        opacity: 0;
        animation: fadeUp 0.7s 0.8s forwards;
    }

    .btn-primary {
        display: inline-block;
        padding: 14px 32px;
        background: var(--gold);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: background 0.25s, transform 0.2s;
    }

    .btn-primary:hover {
        background: #c9922e;
        transform: translateY(-2px);
    }

    .btn-outline {
        display: inline-block;
        padding: 14px 32px;
        border: 1.5px solid rgba(255,255,255,0.35);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: border-color 0.25s, background 0.25s;
    }

    .btn-outline:hover {
        border-color: white;
        background: rgba(255,255,255,0.08);
    }

    .hero-deco {
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.08);
        pointer-events: none;
    }

    .hero-deco2 {
        position: absolute;
        top: 40px;
        right: 100px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        pointer-events: none;
    }

    .hero-right {
        background: var(--beige);
        position: relative;
        overflow: hidden;
    }

    .hero-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: fadeIn 1s 0.5s forwards;
    }

    .hero-right-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--beige) 0%, #d4c4b8 100%);
    }

    .hero-right-fallback .brand-big {
        font-family: 'Cormorant Garamond', serif;
        font-size: 80px;
        font-weight: 300;
        color: rgba(45,77,44,0.15);
        text-align: center;
        line-height: 1;
        letter-spacing: -2px;
    }

    .hero-tag {
        position: absolute;
        bottom: 40px;
        left: 40px;
        background: white;
        border-radius: 12px;
        padding: 14px 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        opacity: 0;
        animation: fadeUp 0.7s 1s forwards;
    }

    .hero-tag .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #4caf50;
        flex-shrink: 0;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .hero-tag p { font-size: 12px; color: #555; line-height: 1.4; }
    .hero-tag strong { display: block; font-size: 13px; color: var(--green); }

    .stats-bar {
        background: var(--white);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #eee;
    }

    .stat-item {
        padding: 32px 40px;
        text-align: center;
        border-right: 1px solid #eee;
    }

    .stat-item:last-child { border-right: none; }

    .stat-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 600;
        color: var(--green);
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    .section {
        padding: 80px 60px;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 48px;
    }

    .section-eyebrow {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 38px;
        font-weight: 400;
        color: var(--green);
        line-height: 1.1;
    }

    .section-link {
        font-size: 13px;
        color: var(--green);
        text-decoration: none;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--green);
        padding-bottom: 2px;
        transition: opacity 0.2s;
    }

    .section-link:hover { opacity: 0.6; }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .feature-card {
        background: var(--white);
        border-radius: 16px;
        padding: 32px 28px;
        transition: transform 0.25s, box-shadow 0.25s;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--green), var(--gold));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s;
    }

    .feature-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
    .feature-card:hover::before { transform: scaleX(1); }

    .feature-icon {
        width: 48px;
        height: 48px;
        background: var(--beige);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 22px;
    }

    .feature-card h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 600;
        color: var(--green);
        margin-bottom: 10px;
    }

    .feature-card p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.7;
    }

    .banner-cta {
        margin: 0 60px 80px;
        background: var(--green);
        border-radius: 24px;
        padding: 60px 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        position: relative;
        overflow: hidden;
    }

    .banner-cta::before {
        content: 'AN';
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Cormorant Garamond', serif;
        font-size: 200px;
        font-weight: 300;
        color: rgba(255,255,255,0.04);
        line-height: 1;
        pointer-events: none;
    }

    .banner-cta-text .eyebrow {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 12px;
    }

    .banner-cta-text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 300;
        color: white;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .banner-cta-text p {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        max-width: 400px;
        line-height: 1.7;
    }

    .footer {
        background: var(--green2);
        color: rgba(255,255,255,0.5);
        text-align: center;
        padding: 28px;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .footer span { color: var(--gold); }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    @media (max-width: 900px) {
        .hero { grid-template-columns: 1fr; min-height: auto; }
        .hero-right { height: 300px; }
        .hero-left { padding: 60px 30px; }
        .hero-left::after { display: none; }
        .stats-bar { grid-template-columns: 1fr; }
        .stat-item { border-right: none; border-bottom: 1px solid #eee; }
        .section { padding: 60px 24px; }
        .features-grid { grid-template-columns: 1fr; }
        .banner-cta { margin: 0 24px 60px; padding: 40px 30px; flex-direction: column; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
    </style>
</head>
<body>

<div class="welcome-bar">
    Halo, <span><?= htmlspecialchars($username) ?></span> — Selamat datang kembali di AN Skin Lab ✨
</div>

<?php include "layout/header.html"; ?>

<section class="hero">

    <div class="hero-left">
        <div class="hero-deco"></div>
        <div class="hero-deco2"></div>

        <p class="hero-eyebrow">Natural Skincare · Est. 2026</p>

        <h1 class="hero-title">
            Glow Your<br>
            <em>Natural</em><br>
            Beauty
        </h1>

        <p class="hero-desc">
            Discover skincare formulated with the finest natural ingredients — 
            lightweight, effective, and made for your everyday glow.
        </p>

        <div class="hero-btns">
            <a href="product.php" class="btn-primary">Shop Now</a>
            <a href="riwayat.php" class="btn-outline">My Orders</a>
        </div>
    </div>

    <div class="hero-right">
        <img src="img/face.jpeg" alt="AN Skin Lab"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
        <div class="hero-right-fallback" style="display:none">
            <div class="brand-big">AN<br>SKIN<br>LAB</div>
        </div>

        <div class="hero-tag">
            <div class="dot"></div>
            <div>
                <strong>100% Natural</strong>
                <p>Dermatologist tested</p>
            </div>
        </div>
    </div>

</section>

<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-number">1009+</div>
        <div class="stat-label">Happy Customers</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">1109+</div>
        <div class="stat-label">Products</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">100%</div>
        <div class="stat-label">Natural Ingredients</div>
    </div>
</div>

<section class="section">
    <div class="section-header">
        <div>
            <p class="section-eyebrow">Why Choose Us</p>
            <h2 class="section-title">Skincare You<br>Can Trust</h2>
        </div>
        <a href="product.php" class="section-link">View All Products →</a>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🌿</div>
            <h3>Natural Ingredients</h3>
            <p>Every product is formulated with carefully selected natural ingredients that are gentle yet effective for all skin types.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✨</div>
            <h3>Dermatologist Tested</h3>
            <p>All our formulas are tested and approved by dermatologists to ensure safety and efficacy for your skin.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🚚</div>
            <h3>Fast Delivery</h3>
            <p>We partner with J&T, SPXpress, and Si Cepat to ensure your order arrives quickly and safely.</p>
        </div>
    </div>
</section>

<div class="banner-cta">
    <div class="banner-cta-text">
        <p class="eyebrow">Limited Time Offer</p>
        <h2>Start Your Skincare<br>Journey Today</h2>
        <p>Explore our full range of natural skincare products and find what works best for your skin.</p>
    </div>
    <a href="product.php" class="btn-primary" style="flex-shrink:0; white-space:nowrap;">
        Explore Products
    </a>
</div>

<div class="footer">
    © 2024 <span>AN Skin Lab</span> · Natural Skincare for Your Glow
</div>

</body>
</html>
=======
<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('location: login.php');
    exit;
}

$username = $_SESSION['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AN Skin Lab – Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
        --cream:   #f3eee9;
        --beige:   #e8dfd8;
        --green:   #2d4d2c;
        --green2:  #1e3a1d;
        --gold:    #e0a94f;
        --pink:    #ffb6c1;
        --white:   #ffffff;
        --text:    #2a2a2a;
        --muted:   #888;
    }

    html { scroll-behavior: smooth; }

    body {
        font-family: 'DM Sans', sans-serif;
        background: var(--cream);
        color: var(--text);
        overflow-x: hidden;
    }

    /* ===== WELCOME BANNER ===== */
    .welcome-bar {
        background: var(--green);
        color: rgba(255,255,255,0.85);
        text-align: center;
        padding: 10px;
        font-size: 13px;
        letter-spacing: 1.5px;
    }

    .welcome-bar span {
        color: var(--gold);
        font-weight: 500;
    }

    /* ===== HERO ===== */
    .hero {
        min-height: 92vh;
        display: grid;
        grid-template-columns: 1fr 1fr;
        position: relative;
        overflow: hidden;
    }

    /* Kiri */
    .hero-left {
        background: var(--green);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 80px 70px;
        position: relative;
        z-index: 1;
    }

    .hero-left::after {
        content: '';
        position: absolute;
        right: -60px;
        top: 0;
        bottom: 0;
        width: 120px;
        background: var(--green);
        clip-path: polygon(0 0, 0% 100%, 100% 100%);
        z-index: 2;
    }

    .hero-eyebrow {
        font-size: 11px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 20px;
        opacity: 0;
        animation: fadeUp 0.7s 0.2s forwards;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: clamp(42px, 5vw, 68px);
        font-weight: 300;
        line-height: 1.1;
        color: var(--white);
        margin-bottom: 24px;
        opacity: 0;
        animation: fadeUp 0.7s 0.4s forwards;
    }

    .hero-title em {
        font-style: italic;
        color: var(--gold);
    }

    .hero-desc {
        font-size: 15px;
        line-height: 1.8;
        color: rgba(255,255,255,0.65);
        max-width: 380px;
        margin-bottom: 40px;
        opacity: 0;
        animation: fadeUp 0.7s 0.6s forwards;
    }

    .hero-btns {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        opacity: 0;
        animation: fadeUp 0.7s 0.8s forwards;
    }

    .btn-primary {
        display: inline-block;
        padding: 14px 32px;
        background: var(--gold);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 500;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: background 0.25s, transform 0.2s;
    }

    .btn-primary:hover {
        background: #c9922e;
        transform: translateY(-2px);
    }

    .btn-outline {
        display: inline-block;
        padding: 14px 32px;
        border: 1.5px solid rgba(255,255,255,0.35);
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-size: 13px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        transition: border-color 0.25s, background 0.25s;
    }

    .btn-outline:hover {
        border-color: white;
        background: rgba(255,255,255,0.08);
    }

    /* Dekorasi lingkaran */
    .hero-deco {
        position: absolute;
        bottom: -80px;
        left: -80px;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.08);
        pointer-events: none;
    }

    .hero-deco2 {
        position: absolute;
        top: 40px;
        right: 100px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 1px solid rgba(255,255,255,0.1);
        pointer-events: none;
    }

    /* Kanan */
    .hero-right {
        background: var(--beige);
        position: relative;
        overflow: hidden;
    }

    .hero-right img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        animation: fadeIn 1s 0.5s forwards;
    }

    /* Fallback kalau gambar tidak ada */
    .hero-right-fallback {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--beige) 0%, #d4c4b8 100%);
    }

    .hero-right-fallback .brand-big {
        font-family: 'Cormorant Garamond', serif;
        font-size: 80px;
        font-weight: 300;
        color: rgba(45,77,44,0.15);
        text-align: center;
        line-height: 1;
        letter-spacing: -2px;
    }

    /* Tag label di hero */
    .hero-tag {
        position: absolute;
        bottom: 40px;
        left: 40px;
        background: white;
        border-radius: 12px;
        padding: 14px 20px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        display: flex;
        align-items: center;
        gap: 12px;
        opacity: 0;
        animation: fadeUp 0.7s 1s forwards;
    }

    .hero-tag .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #4caf50;
        flex-shrink: 0;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    .hero-tag p { font-size: 12px; color: #555; line-height: 1.4; }
    .hero-tag strong { display: block; font-size: 13px; color: var(--green); }

    /* ===== STATS BAR ===== */
    .stats-bar {
        background: var(--white);
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        border-bottom: 1px solid #eee;
    }

    .stat-item {
        padding: 32px 40px;
        text-align: center;
        border-right: 1px solid #eee;
    }

    .stat-item:last-child { border-right: none; }

    .stat-number {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 600;
        color: var(--green);
        line-height: 1;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 12px;
        color: var(--muted);
        letter-spacing: 1px;
        text-transform: uppercase;
    }

    /* ===== FEATURED SECTION ===== */
    .section {
        padding: 80px 60px;
    }

    .section-header {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        margin-bottom: 48px;
    }

    .section-eyebrow {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 10px;
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 38px;
        font-weight: 400;
        color: var(--green);
        line-height: 1.1;
    }

    .section-link {
        font-size: 13px;
        color: var(--green);
        text-decoration: none;
        letter-spacing: 1px;
        border-bottom: 1px solid var(--green);
        padding-bottom: 2px;
        transition: opacity 0.2s;
    }

    .section-link:hover { opacity: 0.6; }

    /* Feature cards */
    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 24px;
    }

    .feature-card {
        background: var(--white);
        border-radius: 16px;
        padding: 32px 28px;
        transition: transform 0.25s, box-shadow 0.25s;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--green), var(--gold));
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s;
    }

    .feature-card:hover { transform: translateY(-6px); box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
    .feature-card:hover::before { transform: scaleX(1); }

    .feature-icon {
        width: 48px;
        height: 48px;
        background: var(--beige);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        font-size: 22px;
    }

    .feature-card h3 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 20px;
        font-weight: 600;
        color: var(--green);
        margin-bottom: 10px;
    }

    .feature-card p {
        font-size: 13px;
        color: var(--muted);
        line-height: 1.7;
    }

    /* ===== BANNER CTA ===== */
    .banner-cta {
        margin: 0 60px 80px;
        background: var(--green);
        border-radius: 24px;
        padding: 60px 70px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        position: relative;
        overflow: hidden;
    }

    .banner-cta::before {
        content: 'AN';
        position: absolute;
        right: 60px;
        top: 50%;
        transform: translateY(-50%);
        font-family: 'Cormorant Garamond', serif;
        font-size: 200px;
        font-weight: 300;
        color: rgba(255,255,255,0.04);
        line-height: 1;
        pointer-events: none;
    }

    .banner-cta-text .eyebrow {
        font-size: 11px;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--gold);
        margin-bottom: 12px;
    }

    .banner-cta-text h2 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 300;
        color: white;
        line-height: 1.2;
        margin-bottom: 14px;
    }

    .banner-cta-text p {
        font-size: 14px;
        color: rgba(255,255,255,0.6);
        max-width: 400px;
        line-height: 1.7;
    }

    /* ===== FOOTER ===== */
    .footer {
        background: var(--green2);
        color: rgba(255,255,255,0.5);
        text-align: center;
        padding: 28px;
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    .footer span { color: var(--gold); }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(24px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 900px) {
        .hero { grid-template-columns: 1fr; min-height: auto; }
        .hero-right { height: 300px; }
        .hero-left { padding: 60px 30px; }
        .hero-left::after { display: none; }
        .stats-bar { grid-template-columns: 1fr; }
        .stat-item { border-right: none; border-bottom: 1px solid #eee; }
        .section { padding: 60px 24px; }
        .features-grid { grid-template-columns: 1fr; }
        .banner-cta { margin: 0 24px 60px; padding: 40px 30px; flex-direction: column; }
        .section-header { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
    </style>
</head>
<body>

<!-- Welcome bar -->
<div class="welcome-bar">
    Halo, <span><?= htmlspecialchars($username) ?></span> — Selamat datang kembali di AN Skin Lab ✨
</div>

<?php include "layout/header.html"; ?>

<!-- ===== HERO ===== -->
<section class="hero">

    <div class="hero-left">
        <div class="hero-deco"></div>
        <div class="hero-deco2"></div>

        <p class="hero-eyebrow">Natural Skincare · Est. 2024</p>

        <h1 class="hero-title">
            Glow Your<br>
            <em>Natural</em><br>
            Beauty
        </h1>

        <p class="hero-desc">
            Discover skincare formulated with the finest natural ingredients — 
            lightweight, effective, and made for your everyday glow.
        </p>

        <div class="hero-btns">
            <a href="product.php" class="btn-primary">Shop Now</a>
            <a href="riwayat.php" class="btn-outline">My Orders</a>
        </div>
    </div>

    <div class="hero-right">
        <img src="img/face.jpeg" alt="AN Skin Lab"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
        <div class="hero-right-fallback" style="display:none">
            <div class="brand-big">AN<br>SKIN<br>LAB</div>
        </div>

        <div class="hero-tag">
            <div class="dot"></div>
            <div>
                <strong>100% Natural</strong>
                <p>Dermatologist tested</p>
            </div>
        </div>
    </div>

</section>

<!-- ===== STATS ===== -->
<div class="stats-bar">
    <div class="stat-item">
        <div class="stat-number">500+</div>
        <div class="stat-label">Happy Customers</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">20+</div>
        <div class="stat-label">Products</div>
    </div>
    <div class="stat-item">
        <div class="stat-number">100%</div>
        <div class="stat-label">Natural Ingredients</div>
    </div>
</div>

<!-- ===== FEATURES ===== -->
<section class="section">
    <div class="section-header">
        <div>
            <p class="section-eyebrow">Why Choose Us</p>
            <h2 class="section-title">Skincare You<br>Can Trust</h2>
        </div>
        <a href="product.php" class="section-link">View All Products →</a>
    </div>

    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🌿</div>
            <h3>Natural Ingredients</h3>
            <p>Every product is formulated with carefully selected natural ingredients that are gentle yet effective for all skin types.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">✨</div>
            <h3>Dermatologist Tested</h3>
            <p>All our formulas are tested and approved by dermatologists to ensure safety and efficacy for your skin.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🚚</div>
            <h3>Fast Delivery</h3>
            <p>We partner with J&T, SPXpress, and Si Cepat to ensure your order arrives quickly and safely.</p>
        </div>
    </div>
</section>

<!-- ===== BANNER CTA ===== -->
<div class="banner-cta">
    <div class="banner-cta-text">
        <p class="eyebrow">Limited Time Offer</p>
        <h2>Start Your Skincare<br>Journey Today</h2>
        <p>Explore our full range of natural skincare products and find what works best for your skin.</p>
    </div>
    <a href="product.php" class="btn-primary" style="flex-shrink:0; white-space:nowrap;">
        Explore Products
    </a>
</div>

<!-- ===== FOOTER ===== -->
<div class="footer">
    © 2024 <span>AN Skin Lab</span> · Natural Skincare for Your Glow
</div>

</body>
</html>
>>>>>>> 80bed0ea02da7434457b0522ec8882bb7e38e31e
