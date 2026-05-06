<?php
// ambil qty dari POST (default 0)
$qty = isset($_POST['quantity']) ? $_POST['quantity'] : 0;

// tombol tambah
if (isset($_POST['plus'])) {
    $qty++;
}

// tombol kurang
if (isset($_POST['minus'])) {
    if ($qty > 0) $qty--;
}

// tombol add to cart
if (isset($_POST['add'])) {
    if ($qty > 0) {
        echo "Produk: Sunscreen <br>";
        echo "Harga: 67000 <br>";
        echo "Jumlah: $qty <br><br>";
    } else {
        echo "<script>alert('Quantity harus lebih dari 0!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Product</title>

</head>
<body>


<div class="product-detail">

    <!-- KIRI -->
    <div class="product-image">
        <img src="../img/ss.jpeg" alt="product">
    </div>

    <!-- KANAN -->
    <div class="product-info">
        <h2>
            Natural Glow Organic Sunscreen - SPF 50+ <br>
            PA++++ - Broad Spectrum UVA/UVB Protection
        </h2>

        <h1 class="price">Rp 67.000,00</h1>

        <ul class="benefits">
            <li>✔ Natural Ingredients</li>
            <li>✔ Lightweight & Non-Greasy</li>
            <li>✔ Daily Protection</li>
        </ul>

        <hr>

        <!-- FORM -->
        <form method="POST">
            <p>Quantity</p>

            <div class="qty-box">
                <button name="minus">-</button>
                <span><?php echo $qty; ?></span>
                <button name="plus">+</button>
            </div>

            <input type="hidden" name="quantity" value="<?php echo $qty; ?>">

            <br><br>

            <button type="submit" name="add" class="cart-btn">🛒 Add to Cart</button>
        </form>
    </div>
</div>

<!-- DESKRIPSI -->
<div class="description">
    <p>
        Lindungi kulitmu setiap hari dengan sunscreen dari AN Skin Lab yang
        diformulasikan ringan dan nyaman di kulit. Dengan perlindungan tinggi SPF
        50+ PA++++, produk ini mampu melindungi kulit dari paparan sinar UVA dan
        UVB yang dapat menyebabkan kusam dan penuaan dini.
    </p>

    <p>
        Teksturnya ringan, mudah meresap, dan tidak terasa lengket sehingga
        nyaman digunakan untuk aktivitas sehari-hari.
    </p>
</div>

</body>
</html>

<style>
.product-detail {
    display: flex;
    gap: 40px;
    padding: 40px 80px;
    background: #dcd8cf;
}

.producmaget-image {
    width: 300px;
    border-radius: 10px;
     object-fit: cover;

}

.product-info {
    max-width: 500px;
}

.product-info h2 {
    font-size: 20px;
    color: #2d4d2f;
}

.price {
    color: #e0a94f;
    font-size: 32px;
}

.benefits {
    list-style: none;
    padding: 0;
}

.qty-box {
    display: inline-flex;
    align-items: center;
    background: #e0a94f;
    border-radius: 10px;
    overflow: hidden;
}

.qty-box button {
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    background: none;
}

.qty-box span {
    padding: 0 15px;
}

.cart-btn {
    background: #e0a94f;
    border: none;
    padding: 12px 25px;
    border-radius: 10px;
    color: white;
    cursor: pointer;
}

.description {
    padding: 20px 80px;
}
</style>