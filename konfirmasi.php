<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user']) || !isset($_SESSION['id_order'])) {
    header("Location: login.php");
    exit;
}

$id_user  = $_SESSION['id_user'];
$id_order = $_SESSION['id_order'];

$order = mysqli_fetch_assoc(mysqli_query($db, "
    SELECT * FROM order_produk WHERE id_order = '$id_order' AND id_user = '$id_user'
"));

if (!$order) {
    header("Location: cart.php");
    exit;
}

$details = [];
$result = mysqli_query($db, "
    SELECT order_detail.*, produk.nama_produk, produk.harga_produk
    FROM order_detail
    JOIN produk ON order_detail.id_produk = produk.id_produk
    WHERE order_detail.id_order = '$id_order'
");
while ($row = mysqli_fetch_assoc($result)) {
    $details[] = $row;
}

$invoice_no = 'INV-' . str_pad($id_order, 3, '0', STR_PAD_LEFT);
$tanggal    = date('d F Y', strtotime($order['created_at']));

if (isset($_POST['check_payment'])) {
    // Update status jadi success
    mysqli_query($db, "UPDATE order_produk SET status_pembayaran='success' WHERE id_order='$id_order'");
    header("Location: payment_success.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Konfirmasi Pembayaran – Skinlab</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }

:root {
    --cream:  #f3eee9;
    --white:  #ffffff;
    --green:  #2d4d2c;
    --gold:   #e0a94f;
    --pink:   #ffb6c1;
    --gray:   #888;
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

.page-wrapper {
    max-width: 680px;
    margin: 40px auto;
    padding: 0 20px 80px;
}

.invoice-card {
    background: var(--white);
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}

.invoice-brand {
    margin-bottom: 6px;
}

.invoice-brand h2 {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: var(--green);
}

.invoice-brand p {
    font-size: 12px;
    color: var(--gold);
    letter-spacing: 1px;
    text-transform: uppercase;
}

.invoice-meta {
    margin: 18px 0;
    font-size: 13px;
    color: #555;
    line-height: 1.8;
}

.bill-to {
    margin: 18px 0;
}

.bill-to strong {
    font-size: 13px;
    color: var(--green);
    display: block;
    margin-bottom: 4px;
}

.bill-to p {
    font-size: 13px;
    color: #444;
    line-height: 1.7;
}

.invoice-table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    font-size: 13px;
}

.invoice-table th {
    text-align: left;
    color: var(--green);
    font-weight: 600;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.invoice-table td {
    padding: 8px 0;
    color: #444;
    border-bottom: 1px solid #f5f5f5;
}

.invoice-table td:last-child,
.invoice-table th:last-child {
    text-align: right;
}

.invoice-totals {
    font-size: 13px;
    color: #555;
    margin-top: 4px;
}

.invoice-totals .row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.invoice-totals .total-final {
    font-size: 15px;
    font-weight: 700;
    color: var(--green);
    border-top: 1.5px solid #eee;
    padding-top: 10px;
    margin-top: 6px;
}

.payment-section {
    margin-top: 24px;
}

.payment-section p {
    font-size: 13px;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
}

.qr-box {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #f9f9f9;
    border-radius: 12px;
    padding: 20px;
}

.qr-box img {
    width: 120px;
    height: 120px;
    border-radius: 8px;
}

.qr-info {
    font-size: 13px;
    color: #555;
    line-height: 1.7;
}

.qr-info strong {
    display: block;
    color: var(--green);
    font-size: 14px;
    margin-bottom: 4px;
}

.divider {
    border: none;
    border-top: 1.5px dashed #ddd;
    margin: 24px 0;
}

.btn-check {
    display: block;
    width: 100%;
    padding: 14px;
    background: var(--green);
    color: white;
    border: none;
    border-radius: 12px;
    font-family: 'DM Sans', sans-serif;
    font-size: 15px;
    font-weight: 500;
    cursor: pointer;
    text-align: center;
    margin-top: 24px;
    letter-spacing: 0.5px;
    transition: background 0.2s, transform 0.15s;
}

.btn-check:hover {
    background: #1e3a1d;
    transform: translateY(-1px);
}

.note {
    text-align: center;
    font-size: 12px;
    color: var(--gray);
    margin-top: 12px;
}
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">
    <div class="invoice-card">

        <div class="invoice-brand">
            <h2>AN Skin Lab</h2>
            <p>Invoice</p>
        </div>

        <div class="invoice-meta">
            <div>Invoice No: <strong><?= $invoice_no ?></strong></div>
            <div>Date: <?= $tanggal ?></div>
        </div>

        <div class="bill-to">
            <strong>Bill To:</strong>
            <p>
                <?= htmlspecialchars($order['first_name'] . ' ' . $order['surname']) ?><br>
                <?= htmlspecialchars($order['phone']) ?><br>
                <?= htmlspecialchars($order['address']) ?>
            </p>
        </div>

        <hr class="divider">

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($details as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['nama_produk']) ?></td>
                    <td><?= $d['quantity'] ?></td>
                    <td>Rp <?= number_format($d['harga_produk'] * $d['quantity'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="invoice-totals">
            <div class="row">
                <span>Subtotal</span>
                <span>Rp <?= number_format($order['total_harga'] - $order['ongkir'], 0, ',', '.') ?></span>
            </div>
            <div class="row">
                <span>Shipping (<?= $order['jasa_kirim'] ?>)</span>
                <span>Rp <?= number_format($order['ongkir'], 0, ',', '.') ?></span>
            </div>
            <div class="row total-final">
                <span>Total Payment:</span>
                <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
            </div>
        </div>

        <hr class="divider">

        <div class="payment-section">
            <p>Payment Method: <?= htmlspecialchars($order['payment_method']) ?></p>

            <div class="qr-box">
                <!-- QR placeholder — ganti src dengan gambar QRIS asli kamu -->
                <img src="img/qris.png" alt="QRIS"
                     onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=120x120&data=SkinlabPayment<?= $id_order ?>'">
                <div class="qr-info">
                    <strong>Scan untuk Bayar</strong>
                    Scan QR di atas menggunakan<br>
                    aplikasi pembayaran apapun.<br><br>
                    Total: <strong style="color:var(--gold)">Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>

        <form method="POST">
            <button type="submit" name="check_payment" class="btn-check">
                ✓ Check Payment
            </button>
        </form>

        <p class="note">Klik tombol di atas setelah pembayaran selesai dilakukan</p>

    </div>
</div>

</body>
</html>
