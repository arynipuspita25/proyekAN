<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database_name = "skinlab";

$db = mysqli_connect($hostname, $username, $password, $database_name);

// cek koneksi (BENAR)
if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>