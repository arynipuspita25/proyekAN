<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* =========================
   AMBIL ORDER
========================= */

$orders = [];

$result = mysqli_query($db, "
    SELECT * FROM order_produk
    WHERE id_user = '$id_user'
    ORDER BY created_at DESC
");

while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

/* =========================
   DETAIL ORDER
========================= */

foreach ($orders as &$order) {

    $id_order = $order['id_order'];

    $det = mysqli_query($db, "
        SELECT order_detail.*, 
               produk.nama_produk,
               produk.harga_produk,
               produk.gambar
        FROM order_detail
        JOIN produk 
        ON order_detail.id_produk = produk.id_produk
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

<title>Riwayat Pembelian - AN Skin Lab</title>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --cream:#f4efe9;
    --white:#ffffff;
    --green:#163d09;
    --green2:#2f6a34;
    --pink:#e8a8b5;
    --gray:#666;
}

body{
    font-family:'Poppins', sans-serif;
    background:var(--cream);
    min-height:100vh;
}

/* =========================
   PAGE
========================= */

.page-wrapper{
    max-width:1200px;
    margin:40px auto;
    padding:0 20px 80px;
}

.page-title{
    font-family:'Playfair Display', serif;
    font-size:38px;
    color:var(--green);
    margin-bottom:35px;
    font-weight:700;
}

/* =========================
   RECEIPT CARD
========================= */

.receipt-card{

    background:var(--white);

    border-radius:28px;

    overflow:hidden;

    margin-bottom:35px;

    box-shadow:
    0 10px 35px rgba(0,0,0,0.08);

    display:grid;

    grid-template-columns:
    1.1fr 0.9fr;
}

/* =========================
   LEFT
========================= */

.receipt-left{
    padding:45px;
    background:#f4efe8;
}

/* =========================
   BRAND
========================= */

.receipt-brand h3{
    font-family:'Playfair Display', serif;
    font-size:42px;
    color:var(--green2);
    margin-bottom:4px;
}

.receipt-brand p{
    color:var(--pink);
    font-size:15px;
    font-weight:600;
    letter-spacing:1px;
    text-transform:uppercase;
    margin-bottom:35px;
}

/* =========================
   META
========================= */

.receipt-meta{
    display:flex;
    gap:45px;
    margin-bottom:25px;
}

.receipt-meta label{
    display:block;
    font-size:11px;
    color:#999;
    text-transform:uppercase;
    margin-bottom:5px;
    letter-spacing:1px;
}

.receipt-meta strong{
    color:#333;
    font-size:15px;
}

/* =========================
   DIVIDER
========================= */

.divider{
    border:none;
    border-top:1.5px dashed #ddd;
    margin:22px 0;
}

/* =========================
   SECTION
========================= */

.section-title{
    font-size:25px;
    color:var(--green2);
    font-weight:700;
    margin-bottom:12px;
}

/* =========================
   CUSTOMER
========================= */

.customer-details{
    font-size:15px;
    line-height:1.9;
    color:#555;
}

/* =========================
   TABLE
========================= */

.order-table{
    width:100%;
    border-collapse:collapse;
    margin-top:10px;
}

.order-table th{
    text-align:left;
    color:var(--green2);
    padding-bottom:14px;
    font-size:16px;
}

.order-table td{
    padding:11px 0;
    border-bottom:1px solid #eee;
    font-size:14px;
    color:#444;
}

.order-table th:last-child,
.order-table td:last-child{
    text-align:right;
}

/* =========================
   TOTALS
========================= */

.totals{
    margin-top:22px;
}

.totals .row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    color:#555;
    font-size:15px;
}

.total-final{
    margin-top:16px;
    padding-top:18px;
    border-top:2px dashed #ddd;
    font-size:24px !important;
    font-weight:700;
    color:var(--pink);
}

/* =========================
   BOTTOM GRID
========================= */

.bottom-grid{
    display:flex;
    gap:40px;
    margin-top:25px;
}

.info-box label{
    display:block;
    font-size:11px;
    color:#999;
    margin-bottom:7px;
    text-transform:uppercase;
    letter-spacing:1px;
}

.info-box p{
    font-size:15px;
    color:#333;
}

/* =========================
   STATUS
========================= */

.status-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 18px;
    border-radius:30px;
    font-size:13px;
    font-weight:600;
}

.status-success{
    background:#e7f6ea;
    color:#2d7a2d;
}

.status-pending{
    background:#fff4d8;
    color:#b8860b;
}

/* =========================
   FOOTER
========================= */

.receipt-footer{
    margin-top:30px;
    font-size:13px;
    color:#777;
    font-style:italic;
}

/* =========================
   RIGHT IMAGE
========================= */

.receipt-right{
    position:relative;
    min-height:100%;
}

.receipt-right img{
    width:100%;
    height:100%;
    object-fit:cover;
}

/* =========================
   EMPTY
========================= */

.empty-state{
    text-align:center;
    padding:90px 20px;
    color:#777;
}

.empty-state p{
    font-size:17px;
    margin-bottom:22px;
}

.btn-shop{
    display:inline-block;
    background:var(--green);
    color:white;
    text-decoration:none;
    padding:14px 34px;
    border-radius:18px;
    font-weight:600;
}

/* =========================
   MOBILE
========================= */

@media(max-width:950px){

    .receipt-card{
        grid-template-columns:1fr;
    }

    .receipt-right{
        height:420px;
    }

    .receipt-left{
        padding:30px;
    }

    .receipt-brand h3{
        font-size:32px;
    }

    .page-title{
        font-size:30px;
    }

    .bottom-grid{
        flex-direction:column;
        gap:20px;
    }

}

</style>

</head>

<body>

<?php include "layout/header.html"; ?>

<div class="page-wrapper">

    <h2 class="page-title">
        🧾 Purchase History
    </h2>

    <?php if(empty($orders)): ?>

    <div class="empty-state">

        <p>Belum ada riwayat pembelian.</p>

        <a href="product.php" class="btn-shop">
            Mulai Belanja
        </a>

    </div>

    <?php else: ?>

    <?php foreach($orders as $order):

        $receipt_no = 'INV-' . str_pad($order['id_order'],3,'0',STR_PAD_LEFT);

        $tanggal = date('d F Y', strtotime($order['created_at']));

        $subtotal = $order['total_harga'] - $order['ongkir'];

        $is_success = $order['status_pembayaran'] === 'success';

    ?>

    <div class="receipt-card">

        <!-- LEFT -->

        <div class="receipt-left">

            <!-- BRAND -->

            <div class="receipt-brand">

                <h3>AN Skin Lab</h3>

                <p>Luxury Skincare Invoice</p>

            </div>

            <!-- META -->

            <div class="receipt-meta">

                <div>
                    <label>Invoice No</label>
                    <strong><?= $receipt_no ?></strong>
                </div>

                <div>
                    <label>Date</label>
                    <strong><?= $tanggal ?></strong>
                </div>

            </div>

            <hr class="divider">

            <!-- CUSTOMER -->

            <div class="section-title">
                Bill To
            </div>

            <div class="customer-details">

                <?= htmlspecialchars($order['first_name'] . ' ' . $order['surname']) ?><br>

                <?= htmlspecialchars($order['phone']) ?><br>

                <?= htmlspecialchars($order['address']) ?>

            </div>

            <hr class="divider">

            <!-- TABLE -->

            <div class="section-title">
                Order Summary
            </div>

            <table class="order-table">

                <thead>

                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>

                </thead>

                <tbody>

                    <?php foreach($order['details'] as $d): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($d['nama_produk']) ?>
                        </td>

                        <td>
                            <?= $d['quantity'] ?>
                        </td>

                        <td>
                            Rp<?= number_format($d['harga_produk'] * $d['quantity'],0,',','.') ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

            <!-- TOTAL -->

            <div class="totals">

                <div class="row">

                    <span>Subtotal</span>

                    <span>
                        Rp<?= number_format($subtotal,0,',','.') ?>
                    </span>

                </div>

                <div class="row">

                    <span>
                        Shipping Fee
                        (<?= $order['jasa_kirim'] ?>)
                    </span>

                    <span>
                        Rp<?= number_format($order['ongkir'],0,',','.') ?>
                    </span>

                </div>

                <div class="row total-final">

                    <span>Total Payment</span>

                    <span>
                        Rp<?= number_format($order['total_harga'],0,',','.') ?>
                    </span>

                </div>

            </div>

            <hr class="divider">

            <!-- PAYMENT -->

            <div class="bottom-grid">

                <div class="info-box">

                    <label>Payment Method</label>

                    <p>
                        <?= htmlspecialchars($order['payment_method']) ?>
                    </p>

                </div>

                <div class="info-box">

                    <label>Payment Status</label>

                    <span class="status-badge <?= $is_success ? 'status-success' : 'status-pending' ?>">

                        <?= $is_success
                        ? '✓ Payment Successful'
                        : '⏳ Pending Payment' ?>

                    </span>

                </div>

            </div>

            <div class="receipt-footer">

                Thank you for your purchase 🌿
                Your skincare journey starts here.

            </div>

        </div>

        <!-- RIGHT IMAGE -->

        <div class="receipt-right">

            <img src="img/face.jpeg" alt="Skinlab Model">

        </div>

    </div>

    <?php endforeach; ?>

    <?php endif; ?>

</div>

</body>
</html>

