<?php
session_start();
require "service/database.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// ================= UPDATE QTY =================
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $quantity) {
        mysqli_query($db, "UPDATE keranjang SET quantity='$quantity' WHERE id_keranjang='$id'");
    }
}

// ================= DELETE =================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($db, "DELETE FROM keranjang WHERE id_keranjang='$id'");
    header("Location: cart.php");
    exit;
}

// ================= AMBIL DATA =================
$query = "
SELECT keranjang.*, produk.nama_produk, produk.harga_produk, produk.gambar
FROM keranjang
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_user = '$id_user'
";
$result = mysqli_query($db, $query);
$jumlah = mysqli_num_rows($result);

// ================= HITUNG SUBTOTAL =================
$items = [];
$subtotal = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $row['subtotal'] = $row['harga_produk'] * $row['quantity'];
    $subtotal += $row['subtotal'];
    $items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cart – Skinlab</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --cream:   #f3eee9;
    --white:   #ffffff;
    --green:   #2d4d2c;
    --gold:    #e0a94f;
    --pink:    #ffb6c1;
    --pink2:   #ffa3b0;
    --gray:    #888;
    --red:     #e05050;
    --shadow:  0 4px 20px rgba(0,0,0,0.08);
}

body {
    font-family: 'DM Sans', sans-serif;
    background: var(--cream);
    min-height: 100vh;
}

/* ===== HEADER CART ===== */
.cart-header {
    background: var(--green);
    color: white;
    padding: 22px 40px;
    display: flex;
    align-items: center;
    gap: 14px;
}

.cart-header svg {
    width: 28px;
    height: 28px;
}

.cart-header h1 {
    font-family: 'Playfair Display', serif;
    font-size: 26px;
    letter-spacing: 0.5px;
}

/* ===== LAYOUT ===== */
.cart-wrapper {
    max-width: 700px;
    margin: 40px auto;
    padding: 0 20px 60px;
}

/* ===== EMPTY STATE ===== */
.cart-kosong {
    text-align: center;
    padding: 80px 20px;
    color: var(--gray);
}

.cart-kosong p {
    font-size: 18px;
    margin-bottom: 20px;
}

.btn-belanja {
    display: inline-block;
    background: var(--pink);
    color: #333;
    padding: 12px 28px;
    border-radius: 25px;
    text-decoration: none;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-belanja:hover { background: var(--pink2); }

/* ===== CART ITEM ===== */
.cart-item {
    background: var(--white);
    border-radius: 18px;
    padding: 18px 20px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: var(--shadow);
    transition: transform 0.15s;
}

.cart-item:hover {
    transform: translateY(-2px);
}

/* Checkbox */
.cart-item input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--green);
    cursor: pointer;
    flex-shrink: 0;
}

/* Gambar */
.cart-item img {
    width: 75px;
    height: 75px;
    object-fit: cover;
    border-radius: 12px;
    flex-shrink: 0;
}

/* Info */
.item-info {
    flex: 1;
    min-width: 0;
}

.item-info h3 {
    font-size: 15px;
    font-weight: 500;
    color: #222;
    margin-bottom: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.item-info .harga {
    color: var(--gold);
    font-weight: 600;
    font-size: 14px;
}

/* QTY */
.qty-control {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}

.qty-control button {
    width: 30px;
    height: 30px;
    border: 1.5px solid #ddd;
    background: white;
    border-radius: 8px;
    font-size: 16px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s;
    color: #333;
}

.qty-control button:hover {
    border-color: var(--green);
    color: var(--green);
}

.qty-control input[type="number"] {
    width: 42px;
    height: 30px;
    text-align: center;
    border: 1.5px solid #ddd;
    border-radius: 8px;
    font-size: 14px;
    font-family: 'DM Sans', sans-serif;
    color: #333;
    -moz-appearance: textfield;
}

.qty-control input::-webkit-outer-spin-button,
.qty-control input::-webkit-inner-spin-button {
    -webkit-appearance: none;
}

/* Hapus */
.btn-hapus {
    background: none;
    border: none;
    cursor: pointer;
    padding: 6px;
    border-radius: 8px;
    transition: background 0.15s;
    flex-shrink: 0;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.btn-hapus:hover {
    background: #fdecea;
}

.btn-hapus svg {
    width: 20px;
    height: 20px;
    stroke: var(--red);
}

/* ===== DIVIDER ===== */
.divider {
    border: none;
    border-top: 1.5px dashed #ccc;
    margin: 24px 0 16px;
}

/* ===== SUBTOTAL ===== */
.subtotal-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 4px;
    margin-bottom: 24px;
}

.subtotal-row .label {
    font-size: 15px;
    color: var(--gray);
    font-weight: 400;
}

.subtotal-row .amount {
    font-family: 'Playfair Display', serif;
    font-size: 22px;
    color: var(--green);
    font-weight: 600;
}

/* ===== CHECKOUT BTN ===== */
.checkout-btn {
    width: 100%;
    padding: 16px;
    background: var(--gold);
    border: none;
    border-radius: 16px;
    font-size: 16px;
    font-family: 'DM Sans', sans-serif;
    font-weight: 500;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: background 0.2s, transform 0.15s;
    letter-spacing: 0.3px;
}

.checkout-btn:hover {
    background: #c9922e;
    transform: translateY(-1px);
}

.checkout-btn svg {
    width: 20px;
    height: 20px;
}
</style>
</head>

<body>

<?php include "layout/header.html"; ?>

<!-- CART HEADER -->
<div class="cart-header">
    <svg fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
        <line x1="3" y1="6" x2="21" y2="6"/>
        <path d="M16 10a4 4 0 01-8 0"/>
    </svg>
    <h1>Cart</h1>
</div>

<div class="cart-wrapper">

<?php if ($jumlah == 0): ?>

    <!-- KOSONG -->
    <div class="cart-kosong">
        <p>🛒 Keranjang kamu masih kosong.</p>
        <a href="product.php" class="btn-belanja">Mulai Belanja</a>
    </div>

<?php else: ?>

    <form method="POST" action="checkout.php" id="formCart">

        <!-- LIST ITEM -->
        <?php foreach ($items as $row): ?>
        <div class="cart-item">

            <!-- CHECKBOX -->
            <input type="checkbox" name="pilih[]" value="<?= $row['id_keranjang'] ?>" checked>

            <!-- GAMBAR -->
            <img src="img/<?= $row['gambar'] ?>" alt="<?= $row['nama_produk'] ?>">

            <!-- INFO -->
            <div class="item-info">
                <h3><?= $row['nama_produk'] ?></h3>
                <div class="harga">Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?></div>
            </div>

            <!-- QTY -->
            <div class="qty-control">
                <button type="button" onclick="kurang(<?= $row['id_keranjang'] ?>)">−</button>

                <input type="number"
                       name="qty[<?= $row['id_keranjang'] ?>]"
                       id="qty<?= $row['id_keranjang'] ?>"
                       value="<?= $row['quantity'] ?>"
                       min="1"
                       onchange="updateSubtotal()">

                <button type="button" onclick="tambah(<?= $row['id_keranjang'] ?>)">+</button>
            </div>

            <!-- HAPUS -->
            <a href="?hapus=<?= $row['id_keranjang'] ?>" class="btn-hapus"
               onclick="return confirm('Hapus produk ini dari keranjang?')">
                <svg fill="none" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14H6L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4h6v2"/>
                </svg>
            </a>

        </div>
        <?php endforeach; ?>

        <!-- DIVIDER -->
        <hr class="divider">

        <!-- SUBTOTAL -->
        <div class="subtotal-row">
            <span class="label">Subtotal</span>
            <span class="amount" id="subtotalText">
                Rp <?= number_format($subtotal, 0, ',', '.') ?>
            </span>
        </div>

        <!-- TOMBOL UPDATE TERSEMBUNYI -->
        <input type="hidden" name="update" value="1">

        <!-- CHECKOUT -->
        <button type="submit" class="checkout-btn" formaction="checkout.php">
            <svg fill="none" stroke="white" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 001.99 1.61H19.4a2 2 0 001.98-1.68L23 6H6"/>
            </svg>
            Checkout
        </button>

    </form>

<?php endif; ?>

</div>

<script>
// Data harga produk untuk kalkulasi subtotal di client
const harga = {
    <?php foreach ($items as $row): ?>
    <?= $row['id_keranjang'] ?>: <?= $row['harga_produk'] ?>,
    <?php endforeach; ?>
};

function tambah(id) {
    let input = document.getElementById("qty" + id);
    input.value = parseInt(input.value) + 1;
    hitungSubtotal();
    simpanQty();
}

function kurang(id) {
    let input = document.getElementById("qty" + id);
    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
        hitungSubtotal();
        simpanQty();
    }
}

function hitungSubtotal() {
    let total = 0;
    for (let id in harga) {
        let input = document.getElementById("qty" + id);
        if (input) {
            total += harga[id] * parseInt(input.value);
        }
    }
    document.getElementById("subtotalText").textContent =
        "Rp " + total.toLocaleString("id-ID");
}

function simpanQty() {
    // Auto-submit update qty ke server dengan fetch
    let form = document.getElementById("formCart");
    let data = new FormData(form);
    data.set("update", "1");

    fetch("cart.php", {
        method: "POST",
        body: data
    });
}
</script>

</body>
</html>