<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil semua order user ini
$orders = [];
$result = mysqli_query($db, "
    SELECT * FROM order_produk 
    WHERE id_user = '$id_user' 
    ORDER BY created_at DESC
");
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

// Untuk setiap order, ambil detailnya
foreach ($orders as &$order) {
    $id_order = $order['id_order'];
    $det = mysqli_query($db, "
        SELECT order_detail.*, produk.nama_produk, produk.harga_produk, produk.gambar
        FROM order_detail
        JOIN produk ON order_detail.id_produk = produk.id_produk
        WHERE order_detail.id_order = '$id_order'
    ");
    $order['details'] = [];
    while ($d = mysqli_fetch_assoc($det)) {
        $order['details'][] = $d;
    }
}
unset($order);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Pembelian – Skinlab</title>
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
    max-width: 780px;
    margin: 40px auto;
    padding: 0 20px 80px;
}

/* ===== JUDUL ===== */
.page-title {
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    color: var(--green);
    margin-bottom: 28px;
    display: flex;
    align-items: center;
    gap: 12px;
}

/* ===== RECEIPT CARD ===== */
.receipt-card {
    background: var(--white);
    border-radius: 20px;
    padding: 36px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
}

/* Brand */
.receipt-brand h3 {
    font-family: 'Playfair Display', serif;
    font-size: 20px;
    color: var(--green);
}

.receipt-brand p {
    font-size: 11px;
    color: var(--gold);
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-top: 2px;
}

.divider {
    border: none;
    border-top: 1.5px dashed #ddd;
    margin: 18px 0;
}

/* Meta */
.receipt-meta {
    display: flex;
    gap: 28px;
    font-size: 13px;
    color: #555;
    margin: 14px 0;
}

.receipt-meta div { display: flex; flex-direction: column; gap: 2px; }
.receipt-meta label { font-size: 11px; color: var(--gray); text-transform: uppercase; letter-spacing: 0.5px; }
.receipt-meta strong { color: #333; }

/* Customer Details */
.section-title {
    font-size: 13px;
    font-weight: 700;
    color: var(--green);
    margin-bottom: 10px;
    letter-spacing: 0.5px;
}

.customer-details {
    font-size: 13px;
    color: #555;
    line-height: 1.8;
    margin-bottom: 16px;
}

/* Order Table */
.order-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
    margin-bottom: 12px;
}

.order-table th {
    background: var(--green);
    color: white;
    padding: 9px 12px;
    text-align: left;
    font-weight: 500;
}

.order-table th:last-child,
.order-table td:last-child { text-align: right; }

.order-table td {
    padding: 9px 12px;
    border-bottom: 1px solid #f0f0f0;
    color: #444;
}

.order-table tr:last-child td { border-bottom: none; }

/* Totals */
.totals {
    font-size: 13px;
    color: #555;
    margin-top: 10px;
}

.totals .row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 6px;
}

.totals .total-final {
    font-size: 15px;
    font-weight: 700;
    color: var(--green);
    border-top: 1.5px solid #eee;
    padding-top: 10px;
    margin-top: 4px;
}

/* Payment & Status */
.bottom-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-top: 16px;
}

.info-box {
    font-size: 13px;
}

.info-box label {
    font-size: 11px;
    color: var(--gray);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: block;
    margin-bottom: 4px;
}

.info-box p { color: #444; }

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-success {
    background: #e6f4ea;
    color: #2d7a2d;
}

.status-pending {
    background: #fff8e1;
    color: #b8860b;
}

/* Thank you footer */
.receipt-footer {
    text-align: center;
    margin-top: 20px;
    font-size: 12px;
    color: var(--gray);
    font-style: italic;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 80px 20px;
    color: var(--gray);
}

.empty-state p { font-size: 16px; margin-bottom: 20px; }

.btn-shop {
    display: inline-block;
    background: var(--pink);
    color: #333;
    padding: 12px 28px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
}
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">

    <h2 class="page-title">
        🧾 Riwayat Pembelian
    </h2>

    <?php if (empty($orders)): ?>
    <div class="empty-state">
        <p>Belum ada riwayat pembelian.</p>
        <a href="product.php" class="btn-shop">Mulai Belanja</a>
    </div>

    <?php else: ?>

    <?php foreach ($orders as $order):
        $receipt_no = 'RCPT-' . str_pad($order['id_order'], 3, '0', STR_PAD_LEFT);
        $tanggal    = date('d F Y', strtotime($order['created_at']));
        $subtotal   = $order['total_harga'] - $order['ongkir'];
        $is_success = $order['status_pembayaran'] === 'success';
    ?>

    <div class="receipt-card">

        <!-- Brand -->
        <div class="receipt-brand">
            <h3>AN Skin Lab</h3>
            <p>Purchase Receipt</p>
        </div>

        <!-- Meta -->
        <div class="receipt-meta">
            <div>
                <label>Receipt No</label>
                <strong><?= $receipt_no ?></strong>
            </div>
            <div>
                <label>Date</label>
                <strong><?= $tanggal ?></strong>
            </div>
        </div>

        <hr class="divider">

        <!-- Customer -->
        <div class="section-title">Customer Details</div>
        <div class="customer-details">
            Name: <?= htmlspecialchars($order['first_name'] . ' ' . $order['surname']) ?><br>
            Phone: <?= htmlspecialchars($order['phone']) ?><br>
            Address: <?= htmlspecialchars($order['address']) ?>
        </div>

        <hr class="divider">

        <!-- Order Summary -->
        <div class="section-title">Order Summary</div>
        <table class="order-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($order['details'] as $d): ?>
                <tr>
                    <td><?= htmlspecialchars($d['nama_produk']) ?></td>
                    <td><?= $d['quantity'] ?></td>
                    <td>Rp <?= number_format($d['harga_produk'] * $d['quantity'], 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totals">
            <div class="row">
                <span>Subtotal</span>
                <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
            </div>
            <div class="row">
                <span>Shipping Fee (<?= $order['jasa_kirim'] ?>)</span>
                <span>Rp <?= number_format($order['ongkir'], 0, ',', '.') ?></span>
            </div>
            <div class="row total-final">
                <span>Total Paid:</span>
                <span>Rp <?= number_format($order['total_harga'], 0, ',', '.') ?></span>
            </div>
        </div>

        <hr class="divider">

        <!-- Payment & Status -->
        <div class="bottom-grid">
            <div class="info-box">
                <label>Payment Method</label>
                <p><?= htmlspecialchars($order['payment_method']) ?></p>
            </div>
            <div class="info-box">
                <label>Payment Status</label>
                <span class="status-badge <?= $is_success ? 'status-success' : 'status-pending' ?>">
                    <?= $is_success ? '✓ Payment Successful' : '⏳ Pending' ?>
                </span>
            </div>
        </div>

        <div class="receipt-footer">
            Thank you for your purchase! 🌿 Your order is being processed.
        </div>

    </div>

    <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>
</html>
