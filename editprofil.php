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
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --cream:    #f3eee9;
    --white:    #ffffff;
    --green:    #2d4d2c;
    --gold:     #e0a94f;
    --pink:     #ffb6c1;
    --red:      #c0392b;
    --input-bg: #e8dfd8;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

.page-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 50px 20px 80px;
}

/* ===== CARD ===== */
.edit-card {
    background: var(--white);
    border-radius: 20px;
    width: 100%;
    max-width: 480px;
    padding: 40px;
    box-shadow: 0 6px 28px rgba(0,0,0,0.08);
}

.card-title {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    color: var(--green);
    margin-bottom: 6px;
}

.card-sub {
    font-size: 13px;
    color: #888;
    margin-bottom: 30px;
}

/* Section label */
.section-label {
    font-size: 12px;
    font-weight: 600;
    color: var(--green);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 24px 0 14px;
    padding-bottom: 6px;
    border-bottom: 1.5px solid #eee;
}

/* Form group */
.form-group {
    margin-bottom: 16px;
}

.form-group label {
    display: block;
    font-size: 13px;
    color: #555;
    margin-bottom: 6px;
    font-weight: 500;
}

.form-group input {
    width: 100%;
    padding: 12px 16px;
    background: var(--input-bg);
    border: none;
    border-radius: 8px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: box-shadow 0.2s;
}

.form-group input:focus {
    box-shadow: 0 0 0 2px var(--green);
}

.form-group small {
    display: block;
    font-size: 11px;
    color: #aaa;
    margin-top: 4px;
}

/* Pesan */
.pesan-sukses {
    background: #e6f4ea;
    color: #2d7a2d;
    padding: 12px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
}

.error-box {
    background: #fdecea;
    border-left: 4px solid var(--red);
    border-radius: 8px;
    padding: 12px 16px;
    margin-bottom: 20px;
}

.error-box p {
    color: var(--red);
    font-size: 13px;
    margin-bottom: 3px;
}

.error-box p:last-child { margin-bottom: 0; }

/* Buttons */
.btn-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 28px;
}

.btn-simpan {
    width: 100%;
    padding: 13px;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
}

.btn-simpan:hover {
    background: #1e3a1d;
    transform: translateY(-1px);
}

.btn-back {
    display: block;
    width: 100%;
    padding: 12px;
    background: white;
    color: #555;
    border: 1.5px solid #ccc;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    text-align: center;
    text-decoration: none;
    transition: border-color 0.2s, color 0.2s;
}

.btn-back:hover {
    border-color: var(--green);
    color: var(--green);
}
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">
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
