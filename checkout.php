<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// ================= AMBIL ITEM YANG DIPILIH DARI CART =================
$pilih = $_POST['pilih'] ?? [];

if (!empty($pilih)) {
    $_SESSION['pilih'] = $pilih;
} else {
    $pilih = $_SESSION['pilih'] ?? [];
}

if (empty($pilih)) {
    header("Location: cart.php");
    exit;
}

// Ambil data produk yang dipilih
$ids    = implode(',', array_map('intval', $pilih));
$query  = "
    SELECT keranjang.*, produk.nama_produk, produk.harga_produk, produk.gambar
    FROM keranjang
    JOIN produk ON keranjang.id_produk = produk.id_produk
    WHERE keranjang.id_keranjang IN ($ids)
    AND keranjang.id_user = '$id_user'
";
$result   = mysqli_query($db, $query);
$items    = [];
$subtotal = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $row['subtotal'] = $row['harga_produk'] * $row['quantity'];
    $subtotal       += $row['subtotal'];
    $items[]         = $row;
}

if (empty($items)) {
    header("Location: cart.php");
    exit;
}

$ongkir = 15000;
$total  = $subtotal + $ongkir;

// ================= PROSES FORM CONFIRM =================
$errors = [];

if (isset($_POST['confirm'])) {
    $first_name     = trim($_POST['first_name'] ?? '');
    $surname        = trim($_POST['surname'] ?? '');
    $phone          = trim($_POST['phone'] ?? '');
    $address        = trim($_POST['address'] ?? '');
    $jasa_kirim     = trim($_POST['jasa_kirim'] ?? '');
    $payment_method = trim($_POST['payment_method'] ?? '');

    if (!$first_name)     $errors[] = "First Name wajib diisi.";
    if (!$surname)        $errors[] = "Surname wajib diisi.";
    if (!$phone)          $errors[] = "Phone Number wajib diisi.";
    if (!$address)        $errors[] = "Address wajib diisi.";
    if (!$jasa_kirim)     $errors[] = "Jasa Kirim wajib dipilih.";
    if (!$payment_method) $errors[] = "Payment Method wajib dipilih.";

    if (empty($errors)) {

        // INSERT ke order_produk
        mysqli_query($db, "
            INSERT INTO order_produk 
                (id_user, first_name, surname, phone, address, jasa_kirim, payment_method, ongkir, total_harga, status_pembayaran, created_at)
            VALUES 
                ('$id_user', '$first_name', '$surname', '$phone', '$address', '$jasa_kirim', '$payment_method', '$ongkir', '$total', 'pending', NOW())
        ");
        $id_order = mysqli_insert_id($db);

        // INSERT ke order_detail
        foreach ($items as $item) {
            mysqli_query($db, "
                INSERT INTO order_detail (id_order, id_produk, quantity)
                VALUES ('$id_order', '{$item['id_produk']}', '{$item['quantity']}')
            ");
        }

        // Hapus item dari keranjang yang sudah di-checkout
        mysqli_query($db, "DELETE FROM keranjang WHERE id_keranjang IN ($ids)");

        // Simpan id_order ke session lalu redirect ke konfirmasi
        $_SESSION['id_order'] = $id_order;
        unset($_SESSION['pilih']);

        header("Location: konfirmasi.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout – Skinlab</title>
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
    --gray:     #888;
    --input-bg: #e8dfd8;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

.page-wrapper {
    max-width: 960px;
    margin: 40px auto;
    padding: 0 20px 80px;
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 30px;
    align-items: start;
}

.form-card {
    background: var(--white);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
}

.form-title {
    font-family: 'Playfair Display', serif;
    font-size: 32px;
    letter-spacing: 4px;
    text-align: center;
    color: var(--green);
    margin-bottom: 32px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    font-size: 13px;
    color: #555;
    margin-bottom: 6px;
    font-weight: 500;
}

.form-group input,
.form-group select,
.form-group textarea {
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

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    box-shadow: 0 0 0 2px var(--green);
}

.form-group textarea {
    resize: vertical;
    min-height: 80px;
}

.radio-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 4px;
}

.radio-option {
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    font-size: 14px;
    color: #333;
}

.radio-option input[type="radio"] {
    width: 18px;
    height: 18px;
    accent-color: var(--green);
    cursor: pointer;
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 4px;
}

.payment-option {
    display: flex;
    align-items: center;
    gap: 10px;
    background: var(--input-bg);
    padding: 12px 16px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    border: 2px solid transparent;
    transition: border-color 0.2s;
}

.payment-option:has(input:checked) {
    border-color: var(--green);
}

.payment-option input[type="radio"] {
    accent-color: var(--green);
}

.error-box {
    background: #fdecea;
    border-left: 4px solid var(--red);
    border-radius: 8px;
    padding: 14px 18px;
    margin-bottom: 20px;
}

.error-box p {
    color: var(--red);
    font-size: 13px;
    margin-bottom: 4px;
}

.error-box p:last-child { margin-bottom: 0; }

.btn-group {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 28px;
}

.btn-confirm {
    width: 100%;
    padding: 14px;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    letter-spacing: 2px;
    cursor: pointer;
    transition: background 0.2s, transform 0.15s;
}

.btn-confirm:hover {
    background: #1e3a1d;
    transform: translateY(-1px);
}

.btn-back {
    width: 100%;
    padding: 13px;
    background: white;
    color: #555;
    border: 1.5px solid #ccc;
    border-radius: 10px;
    font-family: 'DM Sans', sans-serif;
    font-size: 14px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    display: block;
    transition: border-color 0.2s, color 0.2s;
}

.btn-back:hover { border-color: var(--green); color: var(--green); }

.summary-card {
    background: var(--green);
    border-radius: 20px;
    padding: 28px;
    color: white;
    position: sticky;
    top: 20px;
}

.summary-card h3 {
    font-family: 'Playfair Display', serif;
    font-size: 18px;
    margin-bottom: 20px;
    letter-spacing: 1px;
    border-bottom: 1px solid rgba(255,255,255,0.2);
    padding-bottom: 14px;
}

.summary-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 14px;
}

.summary-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
}

.summary-item-info { flex: 1; }

.summary-item-info .nama {
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 3px;
}

.summary-item-info .qty-harga {
    font-size: 12px;
    opacity: 0.75;
}

.summary-divider {
    border: none;
    border-top: 1px dashed rgba(255,255,255,0.25);
    margin: 16px 0;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 8px;
    opacity: 0.85;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 16px;
    font-weight: 600;
    margin-top: 6px;
    color: var(--gold);
}
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">

    <div class="form-card">
        <h2 class="form-title">FORM</h2>

        <?php if (!empty($errors)): ?>
        <div class="error-box">
            <?php foreach ($errors as $e): ?>
                <p>⚠ <?= $e ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <?php foreach ($pilih as $p): ?>
                <input type="hidden" name="pilih[]" value="<?= $p ?>">
            <?php endforeach; ?>

            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="first_name"
                       value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>"
                       placeholder="Masukkan nama depan">
            </div>

            <div class="form-group">
                <label>Surname</label>
                <input type="text" name="surname"
                       value="<?= htmlspecialchars($_POST['surname'] ?? '') ?>"
                       placeholder="Masukkan nama belakang">
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone"
                       value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                       placeholder="08xxxxxxxxxx">
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address"
                          placeholder="Masukkan alamat lengkap"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <label>Jasa Kirim</label>
                <div class="radio-group">
                    <?php
                    $kurir_list = ['J&T Express', 'SPXpress', 'Si Cepat'];
                    foreach ($kurir_list as $k):
                        $checked = (($_POST['jasa_kirim'] ?? '') === $k) ? 'checked' : '';
                    ?>
                    <label class="radio-option">
                        <input type="radio" name="jasa_kirim" value="<?= $k ?>" <?= $checked ?>>
                        <?= $k ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label>Payment Method</label>
                <div class="payment-options">
                    <?php
                    $payments = ['QRIS'];
                    foreach ($payments as $pm):
                        $checked = (($_POST['payment_method'] ?? '') === $pm) ? 'checked' : '';
                    ?>
                    <label class="payment-option">
                        <input type="radio" name="payment_method" value="<?= $pm ?>" <?= $checked ?>>
                        <?= $pm ?>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="btn-group">
                <button type="submit" name="confirm" class="btn-confirm">CONFIRM</button>
                <a href="cart.php" class="btn-back">← Back to Cart</a>
            </div>
        </form>
    </div>

    <div class="summary-card">
        <h3>Order Summary</h3>

        <?php foreach ($items as $item): ?>
        <div class="summary-item">
            <img src="img/<?= $item['gambar'] ?>" alt="<?= $item['nama_produk'] ?>">
            <div class="summary-item-info">
                <div class="nama"><?= $item['nama_produk'] ?></div>
                <div class="qty-harga">
                    <?= $item['quantity'] ?> × Rp <?= number_format($item['harga_produk'], 0, ',', '.') ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>

        <hr class="summary-divider">

        <div class="summary-row">
            <span>Subtotal</span>
            <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
        </div>
        <div class="summary-row">
            <span>Ongkir</span>
            <span>Rp <?= number_format($ongkir, 0, ',', '.') ?></span>
        </div>

        <hr class="summary-divider">

        <div class="summary-total">
            <span>Total</span>
            <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
        </div>
    </div>

</div>
<?php include "layout/footer.html" ?>

</body>
</html>
