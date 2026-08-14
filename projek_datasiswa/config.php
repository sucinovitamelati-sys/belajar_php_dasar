<?php
// Jalankan session jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "projek_datasiswa";

// Koneksi ke Database
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>