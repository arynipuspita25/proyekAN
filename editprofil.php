<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$user    = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id_user = '$id_user'"));

$pesan_sukses = "";
$errors       = [];

if (isset($_POST['simpan'])) {
    $username_baru = trim($_POST['username'] ?? '');
    $password_lama = trim($_POST['password_lama'] ?? '');
    $password_baru = trim($_POST['password_baru'] ?? '');
    $konfirmasi    = trim($_POST['konfirmasi'] ?? '');

    // Validasi username
    if (!$username_baru) {
        $errors[] = "Username tidak boleh kosong.";
    }

    // Cek apakah username sudah dipakai user lain
    $cek = mysqli_fetch_assoc(mysqli_query($db, "
        SELECT * FROM users WHERE username = '$username_baru' AND id_user != '$id_user'
    "));
    if ($cek) {
        $errors[] = "Username sudah digunakan akun lain.";
    }

    // Kalau mau ganti password
    $ganti_password = false;
    if ($password_lama || $password_baru || $konfirmasi) {
        $hash_lama = hash('sha256', $password_lama);
        if ($hash_lama !== $user['password']) {
            $errors[] = "Password lama tidak sesuai.";
        } elseif (!$password_baru) {
            $errors[] = "Password baru tidak boleh kosong.";
        } elseif ($password_baru !== $konfirmasi) {
            $errors[] = "Konfirmasi password tidak cocok.";
        } else {
            $ganti_password = true;
        }
    }

    if (empty($errors)) {
        if ($ganti_password) {
            $hash_baru = hash('sha256', $password_baru);
            mysqli_query($db, "
                UPDATE users SET username = '$username_baru', password = '$hash_baru'
                WHERE id_user = '$id_user'
            ");
        } else {
            mysqli_query($db, "
                UPDATE users SET username = '$username_baru'
                WHERE id_user = '$id_user'
            ");
        }

        // Update session
        $_SESSION['username'] = $username_baru;
        $pesan_sukses = "Profil berhasil diperbarui!";

        // Refresh data user
        $user = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM users WHERE id_user = '$id_user'"));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profil – Skinlab</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<<style>

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
    --gold:#d9b26f;
    --pink:#ffd8df;
    --red:#c0392b;
    --input:#f6f1eb;
    --text:#555;
}

body{
    font-family:'DM Sans', sans-serif;
    background:
    linear-gradient(rgba(248,245,241,.9), rgba(248,245,241,.9)),
    url('img/bg.jpg');
    background-size:cover;
    min-height:100vh;
    overflow-x:hidden;
    position:relative;
}

/* ===== BACKGROUND GLOW ===== */

body::before{
    content:'';
    position:fixed;
    width:450px;
    height:450px;
    background:#dfe9da;
    border-radius:50%;
    top:-120px;
    left:-100px;
    filter:blur(120px);
    z-index:-2;
}

body::after{
    content:'';
    position:fixed;
    width:420px;
    height:420px;
    background:#f2dfcb;
    border-radius:50%;
    bottom:-120px;
    right:-100px;
    filter:blur(120px);
    z-index:-2;
}

/* ===== WRAPPER ===== */

.page-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:120px 20px 70px;
    position:relative;
}

/* ===== BACK TEXT ===== */

.bg-text{
    position:absolute;
    top:50%;
    left:50%;
    transform:translate(-50%,-50%);
    font-size:130px;
    font-family:'Playfair Display', serif;
    font-weight:700;
    color:rgba(255,255,255,0.35);
    letter-spacing:15px;
    z-index:-1;
    user-select:none;
}

/* ===== CARD ===== */

.edit-card{
    width:100%;
    max-width:520px;
    background:rgba(255,255,255,0.75);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,.4);
    border-radius:35px;
    padding:45px;
    box-shadow:
    0 20px 50px rgba(0,0,0,.12);
    animation:fadeUp 1s ease;
    transition:.4s;
}

.edit-card:hover{
    transform:translateY(-6px);
}

/* ===== TITLE ===== */

.card-title{
    font-family:'Playfair Display', serif;
    font-size:42px;
    color:var(--green);
    margin-bottom:8px;
    text-align:center;
}

.card-sub{
    text-align:center;
    color:#888;
    font-size:14px;
    margin-bottom:35px;
    letter-spacing:1px;
}

/* ===== SECTION LABEL ===== */

.section-label{
    font-size:12px;
    font-weight:700;
    color:var(--green);
    text-transform:uppercase;
    letter-spacing:2px;
    margin:30px 0 16px;
    padding-bottom:10px;
    border-bottom:1px solid rgba(0,0,0,.08);
}

/* ===== INPUT ===== */

.form-group{
    margin-bottom:18px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:14px;
    color:#555;
    font-weight:500;
}

.form-group input{
    width:100%;
    padding:15px 18px;
    background:var(--input);
    border:none;
    border-radius:14px;
    font-size:14px;
    font-family:'DM Sans', sans-serif;
    outline:none;
    transition:.3s;
    color:#333;
}

.form-group input:focus{
    background:white;
    box-shadow:
    0 0 0 2px rgba(36,67,54,.15),
    0 8px 20px rgba(0,0,0,.05);
}

.form-group small{
    display:block;
    margin-top:6px;
    color:#aaa;
    font-size:11px;
}

/* ===== SUCCESS ===== */

.pesan-sukses{
    background:#ebf8ee;
    color:#2e7d32;
    padding:14px 18px;
    border-radius:14px;
    margin-bottom:22px;
    font-size:13px;
    font-weight:500;
}

/* ===== ERROR ===== */

.error-box{
    background:#fff1f1;
    border-left:4px solid var(--red);
    border-radius:14px;
    padding:14px 18px;
    margin-bottom:22px;
}

.error-box p{
    color:var(--red);
    font-size:13px;
    margin-bottom:5px;
}

/* ===== BUTTON ===== */

.btn-group{
    margin-top:35px;
    display:flex;
    flex-direction:column;
    gap:14px;
}

.btn-simpan{
    width:100%;
    padding:15px;
    border:none;
    border-radius:16px;
    background:
    linear-gradient(135deg,var(--green),var(--green2));
    color:white;
    font-size:15px;
    font-weight:600;
    font-family:'DM Sans', sans-serif;
    cursor:pointer;
    transition:.35s;
    box-shadow:0 10px 25px rgba(36,67,54,.25);
}

.btn-simpan:hover{
    transform:translateY(-3px);
    box-shadow:0 16px 30px rgba(36,67,54,.3);
}

/* ===== BACK BUTTON ===== */

.btn-back{
    width:100%;
    padding:14px;
    border-radius:16px;
    text-align:center;
    text-decoration:none;
    background:white;
    color:#555;
    border:1px solid rgba(0,0,0,.08);
    transition:.3s;
    font-size:14px;
    font-weight:500;
}

.btn-back:hover{
    background:var(--green);
    color:white;
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

    .edit-card{
        padding:35px 25px;
        border-radius:28px;
    }

    .card-title{
        font-size:34px;
    }

    .bg-text{
        font-size:70px;
    }

}

</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">
    <div class="bg-text">SKINLAB</div>

    <div class="edit-card">

        <h2 class="card-title">Edit Profile</h2>
        <p class="card-sub">Perbarui username atau password kamu</p>

        <!-- Pesan -->
        <?php if ($pesan_sukses): ?>
            <div class="pesan-sukses">✅ <?= $pesan_sukses ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <?php foreach ($errors as $e): ?>
                    <p>⚠ <?= $e ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">

            <!-- USERNAME -->
            <div class="section-label">Informasi Akun</div>

            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username"
                       value="<?= htmlspecialchars($user['username']) ?>"
                       placeholder="Masukkan username baru">
            </div>

            <!-- PASSWORD -->
            <div class="section-label">Ganti Password <span style="font-weight:300;text-transform:none;letter-spacing:0">(opsional)</span></div>

            <div class="form-group">
                <label>Password Lama</label>
                <input type="password" name="password_lama" placeholder="Masukkan password lama">
                <small>Isi bagian password hanya jika ingin menggantinya</small>
            </div>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Masukkan password baru">
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="konfirmasi" placeholder="Ulangi password baru">
            </div>

            <div class="btn-group">
                <button type="submit" name="simpan" class="btn-simpan">Simpan Perubahan</button>
                <a href="profile.php" class="btn-back">← Back to Profile</a>
            </div>

        </form>
    </div>
</div>

</body>
</html>
