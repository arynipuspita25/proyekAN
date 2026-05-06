<?php
session_start();
require "service/database.php";

// sementara (nanti ambil dari login)
$id_user = 1;

// ================= UPDATE QTY =================
if (isset($_POST['update'])) {
    foreach ($_POST['qty'] as $id => $qty) {
        mysqli_query($db, "UPDATE keranjang SET qty='$qty' WHERE id_keranjang='$id'");
    }
}

// ================= DELETE =================
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($db, "DELETE FROM keranjang WHERE id_keranjang='$id'");
}

// ================= AMBIL DATA =================
$query = "
SELECT keranjang.*, produk.nama_produk, produk.harga_produk, produk.gambar
FROM keranjang
JOIN produk ON keranjang.id_produk = produk.id_produk
WHERE keranjang.id_user = '$id_user'
";

$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Cart</title>
</head>

<body>

<h2>Your Cart</h2>

<form method="POST" action="checkout.php">

<div class="cart-container">

<?php while($row = mysqli_fetch_assoc($result)) : ?>

<div class="cart-item">

    <!-- CHECKBOX -->
    <input type="checkbox" name="pilih[]" value="<?= $row['id_keranjang']; ?>">

    <!-- IMAGE -->
    <img src="img/<?= $row['gambar']; ?>">

    <!-- INFO -->
    <div class="info">
        <h3><?= $row['nama_produk']; ?></h3>
        <p>Rp <?= number_format($row['harga_produk'],0,',','.'); ?></p>
    </div>

    <!-- QTY -->
    <div class="qty">
        <button type="button" onclick="kurang(<?= $row['id_keranjang']; ?>)">-</button>

        <input type="number"
               name="qty[<?= $row['id_keranjang']; ?>]"
               id="qty<?= $row['id_keranjang']; ?>"
               value="<?= $row['qty']; ?>"
               min="1">

        <button type="button" onclick="tambah(<?= $row['id_keranjang']; ?>)">+</button>
    </div>

    <!-- SUBTOTAL -->
    <div class="subtotal">
        Rp <?= number_format($row['harga_produk'] * $row['qty'],0,',','.'); ?>
    </div>

    <!-- DELETE -->
    <a href="?hapus=<?= $row['id_keranjang']; ?>" class="hapus">🗑</a>

</div>

<?php endwhile; ?>

</div>

<br>

<!-- BUTTON -->
<div class="actions">
    <button type="submit" name="update" formaction="cart.php" class="update-btn">
        Update Cart
    </button>

    <button type="submit" class="checkout-btn">
        Checkout
    </button>
</div>

</form>

</body>

<!-- ================= CSS ================= -->
<style>
body {
    font-family: Arial;
    background: #f3eee9;
    margin: 0;
}

h2 {
    text-align: center;
    margin: 30px;
    color: #2d4d2c;
}

.cart-container {
    width: 80%;
    margin: auto;
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: white;
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.cart-item img {
    width: 80px;
    border-radius: 10px;
}

.info {
    flex: 1;
}

.qty {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty button {
    padding: 5px 10px;
    border: none;
    background: #ffb6c1;
    cursor: pointer;
    border-radius: 5px;
}

.qty input {
    width: 50px;
    text-align: center;
}

.subtotal {
    font-weight: bold;
}

.hapus {
    color: red;
    text-decoration: none;
    font-size: 20px;
}

.actions {
    width: 80%;
    margin: auto;
    display: flex;
    justify-content: space-between;
}

.update-btn {
    padding: 10px 20px;
    background: #ccc;
    border: none;
    border-radius: 10px;
}

.checkout-btn {
    padding: 12px 25px;
    background: #ffb6c1;
    border: none;
    border-radius: 20px;
    cursor: pointer;
}
</style>

<!-- ================= JS ================= -->
<script>
function tambah(id) {
    let input = document.getElementById("qty"+id);
    input.value = parseInt(input.value) + 1;
}

function kurang(id) {
    let input = document.getElementById("qty"+id);
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}
</script>

</html>