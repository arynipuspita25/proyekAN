-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2026 pada 13.39
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skinlab`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `id_user` int(7) NOT NULL,
  `id_produk` int(7) NOT NULL,
  `quantity` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `id_user`, `id_produk`, `quantity`) VALUES
(32, 2, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `id_order_detail` int(7) NOT NULL,
  `id_order` int(7) NOT NULL,
  `id_produk` int(7) NOT NULL,
  `quantity` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`id_order_detail`, `id_order`, `id_produk`, `quantity`) VALUES
(1, 0, 1, 1),
(2, 4, 2, 1),
(3, 5, 2, 1),
(4, 6, 5, 1),
(5, 7, 5, 1),
(6, 7, 2, 1),
(7, 8, 2, 1),
(8, 9, 3, 1),
(9, 10, 3, 1),
(10, 11, 2, 1),
(11, 12, 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_produk`
--

CREATE TABLE `order_produk` (
  `id_order` int(7) NOT NULL,
  `id_user` int(7) NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `surname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `jasa_kirim` varchar(50) DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `ongkir` int(11) DEFAULT 15000,
  `total_harga` double NOT NULL,
  `status_pembayaran` varchar(30) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_produk`
--

INSERT INTO `order_produk` (`id_order`, `id_user`, `first_name`, `surname`, `phone`, `address`, `jasa_kirim`, `payment_method`, `ongkir`, `total_harga`, `status_pembayaran`, `created_at`) VALUES
(1, 2, 'aryn', 'arynipuspita@gmail.com', '085864346887', 'jl.madu', 'J&T Express', 'QRIS', 15000, 131000, 'success', '2026-05-08 11:10:54'),
(2, 5, 'Aryni', 'Puspita', '085864346887', 'jl.m', 'J&T Express', 'QRIS', 15000, 58000, 'pending', '2026-05-08 16:02:52'),
(3, 5, 'Aryni', 'Puspita', '085864346887', 'jl.madu', 'J&T Express', 'QRIS', 15000, 58000, 'pending', '2026-05-08 16:03:25'),
(4, 5, 'Aryni', 'Puspita', '085864346887', 'jl.madu', 'J&T Express', 'QRIS', 15000, 58000, 'pending', '2026-05-08 16:04:25'),
(5, 5, 'Aryni', 'Puspita', '085864346887', 'jl.madu', 'J&T Express', 'QRIS', 15000, 58000, 'pending', '2026-05-08 16:12:21'),
(6, 5, 'sugeng', 'sugengaja', '085864346887', 'jl.madu', 'SPXpress', 'QRIS', 15000, 90000, 'success', '2026-05-08 17:01:13'),
(7, 2, 'Aryni', 'Puspita', '085864346887', 'yyg', 'J&T Express', 'QRIS', 15000, 133000, 'success', '2026-05-08 17:14:13'),
(8, 2, 'Aryni', 'Puspita', '085864346887', 'etrer', 'J&T Express', 'QRIS', 15000, 58000, 'success', '2026-05-08 17:21:05'),
(9, 2, 'ARYN', 'samudraaryni@gmail.com', '08586115728', 'jl.madu', 'J&T Express', 'COD', 15000, 82000, 'success', '2026-05-09 17:56:44'),
(10, 2, 'aryn', 'arynipuspita', '085864346887', 'qs', 'J&T Express', 'QRIS', 15000, 82000, 'pending', '2026-05-09 22:30:07'),
(11, 2, 'aryn', 'sugengaja123@gmail.com', '085864346887', 'jl.batu', 'J&T Express', 'QRIS', 15000, 58000, 'success', '2026-05-10 22:38:16'),
(12, 6, 'dodo', 'dodooaha@gmail.com', '085864346887', 'jl/batu', 'J&T Express', 'QRIS', 15000, 58000, 'success', '2026-05-11 15:27:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `harga_produk` int(70) NOT NULL,
  `stok_produk` int(7) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk`, `stok_produk`, `gambar`, `deskripsi`) VALUES
(1, 'Brightening Serum', 73000, 10, 'serum.jpeg', 'Brightening Serum adalah solusi perawatan kulit yang diformulasikan secara khusus untuk membantu mengatasi berbagai permasalahan kulit seperti kusam, warna kulit tidak merata, serta tanda-tanda kelelahan pada wajah. Dengan kandungan bahan aktif yang bekerja secara optimal hingga ke lapisan kulit terdalam, serum ini membantu memperbaiki tekstur kulit sekaligus memberikan tampilan wajah yang lebih cerah, sehat, dan bercahaya alami.\n\nDiformulasikan dengan tekstur ringan berbasis air, serum ini sangat mudah meresap tanpa meninggalkan rasa lengket atau berat di kulit. Hal ini menjadikannya nyaman digunakan dalam rutinitas skincare harian, baik di pagi hari sebelum aktivitas maupun di malam hari sebelum istirahat. Penggunaan rutin akan membantu menjaga kelembapan kulit serta meningkatkan elastisitas kulit secara bertahap.\n\nKandungan nutrisi di dalamnya juga berperan penting dalam membantu menyamarkan noda hitam, bekas jerawat, serta garis halus yang muncul akibat paparan lingkungan dan faktor usia. Dengan pemakaian yang konsisten, kulit akan terasa lebih halus, lembut, dan tampak lebih segar setiap harinya.\n\nSerum ini cocok digunakan untuk semua jenis kulit, termasuk kulit sensitif, karena diformulasikan dengan bahan yang aman dan lembut di kulit. Tidak hanya memberikan hasil instan, tetapi juga membantu memperbaiki kondisi kulit dalam jangka panjang.\n\nGunakan secara rutin sebagai bagian dari skincare routine untuk mendapatkan hasil maksimal berupa kulit yang lebih cerah, sehat, lembap, dan tampak glowing alami setiap saat.'),
(2, 'Facial Wash', 43000, 15, 'fw.jpeg', 'Facial Wash ini dirancang sebagai langkah awal dalam perawatan kulit untuk membersihkan wajah secara menyeluruh dari kotoran, minyak berlebih, serta sisa makeup yang menempel setelah beraktivitas. Dengan formula yang lembut, produk ini mampu membersihkan hingga ke dalam pori-pori tanpa membuat kulit terasa kering atau tertarik.\n\nTeksturnya ringan dengan busa halus yang memberikan sensasi bersih dan segar setiap kali digunakan. Facial wash ini sangat cocok digunakan dua kali sehari, yaitu di pagi hari untuk menyegarkan kulit sebelum beraktivitas dan di malam hari untuk membersihkan wajah dari kotoran yang menumpuk sepanjang hari.\n\nDiperkaya dengan bahan yang membantu menjaga keseimbangan alami kulit, produk ini tidak hanya membersihkan tetapi juga mempertahankan kelembapan kulit agar tetap sehat. Kulit akan terasa lebih lembut dan tidak kehilangan hidrasi alaminya setelah mencuci wajah.\n\nCocok untuk semua jenis kulit, termasuk kulit sensitif, karena diformulasikan tanpa bahan yang keras di kulit. Penggunaan rutin akan membantu menjaga kulit tetap bersih, segar, dan siap menerima produk skincare berikutnya.\n\nDengan pemakaian yang konsisten, wajah akan terlihat lebih bersih, cerah, dan terasa lebih nyaman sepanjang hari.'),
(3, 'Sunscreen SPF 50+', 67000, 12, 'ss.jpeg', 'Lindungi kulitmu setiap hari dengan sunscreen dari AN Skin Lab yang diformulasikan secara khusus untuk memberikan perlindungan maksimal terhadap paparan sinar matahari. Dengan kandungan SPF 50+ PA++++, produk ini mampu melindungi kulit dari efek buruk sinar UVA dan UVB yang dapat menyebabkan penuaan dini, hiperpigmentasi, serta kerusakan kulit.\n\nSunscreen ini tidak hanya berfungsi sebagai pelindung, tetapi juga membantu merawat kulit dengan kandungan bahan alami yang menutrisi. Formulanya dirancang untuk menjaga kesehatan kulit sekaligus memberikan tampilan yang lebih cerah, segar, dan terawat sepanjang hari.\n\nMemiliki tekstur yang ringan, mudah meresap, serta tidak meninggalkan white cast, produk ini sangat nyaman digunakan bahkan di bawah makeup. Tidak terasa lengket maupun berminyak, sehingga cocok digunakan untuk aktivitas sehari-hari baik di dalam maupun di luar ruangan.\n\nProduk ini cocok untuk semua jenis kulit, termasuk kulit remaja maupun kulit sensitif. Penggunaan rutin akan membantu menjaga kulit tetap terlindungi dari paparan sinar matahari sekaligus mempertahankan kelembapan kulit.\n\nGunakan secara teratur sebelum beraktivitas untuk mendapatkan perlindungan maksimal serta menjaga kulit tetap sehat, glowing, dan terlindungi sepanjang hari.'),
(4, 'Toner', 55000, 20, 'toner.jpeg', 'Toner ini berfungsi sebagai tahap penting dalam rutinitas skincare untuk membantu menyegarkan dan menyeimbangkan kondisi kulit setelah proses pembersihan wajah. Produk ini membantu mengangkat sisa kotoran yang mungkin masih tertinggal sekaligus mempersiapkan kulit untuk menerima perawatan selanjutnya.\n\nDengan formula yang ringan dan cepat meresap, toner ini memberikan sensasi segar tanpa meninggalkan rasa lengket. Penggunaan rutin dapat membantu mengecilkan tampilan pori-pori serta memperbaiki tekstur kulit agar terasa lebih halus dan lembut.\n\nDiperkaya dengan bahan yang menenangkan kulit, toner ini cocok digunakan untuk semua jenis kulit termasuk kulit sensitif. Tidak menyebabkan iritasi dan nyaman digunakan setiap hari baik pagi maupun malam.\n\nSelain itu, toner ini juga membantu meningkatkan efektivitas produk skincare berikutnya karena kulit berada dalam kondisi optimal untuk menyerap nutrisi.\n\nDengan penggunaan rutin, kulit akan terasa lebih bersih, segar, sehat, dan tampak lebih bercahaya secara alami.'),
(5, 'Sheet Mask', 75000, 25, 'masker.jpeg', 'Sheet Mask merupakan solusi praktis untuk memberikan hidrasi dan nutrisi tambahan bagi kulit dalam waktu singkat. Diperkaya dengan essence berkualitas tinggi, masker ini mampu meresap ke dalam kulit untuk memberikan kelembapan intensif serta memperbaiki kondisi kulit yang lelah dan kering.\n\nPenggunaan sheet mask memberikan efek instan berupa kulit yang terasa lebih lembap, kenyal, dan tampak lebih cerah. Sangat cocok digunakan saat kulit membutuhkan perawatan ekstra atau sebagai bagian dari self-care routine.\n\nMaterial masker yang lembut dan nyaman memungkinkan essence terserap dengan maksimal ke dalam kulit. Desainnya yang mengikuti bentuk wajah membuatnya mudah digunakan dan memberikan pengalaman perawatan yang menyenangkan.\n\nCocok digunakan untuk semua jenis kulit, terutama saat kulit terasa kusam atau kurang terhidrasi. Penggunaan rutin dapat membantu meningkatkan kesehatan kulit secara keseluruhan.\n\nGunakan 2-3 kali dalam seminggu untuk mendapatkan hasil kulit yang lebih segar, glowing, dan terawat dengan baik.'),
(6, 'Moisturizer', 45000, 18, 'moist.jpeg', 'Moisturizer ini diformulasikan untuk membantu menjaga dan mengunci kelembapan alami kulit agar tetap terhidrasi sepanjang hari. Dengan kandungan yang menutrisi, produk ini membantu memperbaiki kondisi kulit serta menjaga keseimbangan hidrasi kulit.\n\nTeksturnya ringan dan mudah meresap tanpa meninggalkan rasa berminyak, sehingga nyaman digunakan dalam berbagai aktivitas sehari-hari. Dapat digunakan sebagai langkah terakhir dalam skincare routine untuk menjaga kelembapan kulit secara maksimal.\n\nDiperkaya dengan bahan yang membantu memperkuat skin barrier, moisturizer ini melindungi kulit dari efek buruk lingkungan seperti polusi dan perubahan cuaca yang dapat menyebabkan kulit kering.\n\nCocok untuk semua jenis kulit, termasuk kulit kering dan sensitif. Penggunaan rutin akan membantu menjaga kulit tetap lembut, halus, dan kenyal.\n\nDengan pemakaian yang konsisten, kulit akan terasa lebih sehat, terhidrasi dengan baik, dan tampak lebih glowing alami setiap harinya.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(7) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `created_at`) VALUES
(2, 'aryn', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2026-05-06 11:19:22'),
(3, 'naura', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2026-05-06 11:31:22'),
(4, 'sasa', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2026-05-08 08:13:03'),
(5, 'sugengaja', '03ac674216f3e15c761ee1a5e255f067953623c8b388b4459e13f978d7c846f4', '2026-05-08 12:06:32'),
(6, 'dodo', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '2026-05-11 15:25:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `fk_produk_keranjang` (`id_produk`),
  ADD KEY `fk_user_keranjang` (`id_user`);

--
-- Indeks untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id_order_detail`),
  ADD KEY `fk_order_detail_order` (`id_order`),
  ADD KEY `fk_order_detail_produk` (`id_produk`);

--
-- Indeks untuk tabel `order_produk`
--
ALTER TABLE `order_produk`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `fk_user` (`id_user`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id_order_detail` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `order_produk`
--
ALTER TABLE `order_produk`
  MODIFY `id_order` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `fk_keranjang_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `fk_produk_keranjang` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_keranjang` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_detail_order` FOREIGN KEY (`id_order`) REFERENCES `order_produk` (`id_order`),
  ADD CONSTRAINT `fk_order_detail_produk` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);

--
-- Ketidakleluasaan untuk tabel `order_produk`
--
ALTER TABLE `order_produk`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
