<?php
session_start();
require_once "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah parameter ID ada di URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Hapus data berdasarkan kolom 'nis' atau 'id' saja
    $sql = "DELETE FROM siswa WHERE nis = '$id' OR id = '$id'";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_affected_rows($conn) > 0) {
        // Berhasil hapus, kembali ke index.php
        header("Location: index.php?pesan=hapus_sukses");
        exit;
    } else {
        echo "<h3>Gagal Menghapus Data!</h3>";
        echo "<p>Data dengan NIS/ID <b>'$id'</b> tidak ditemukan.</p>";
        echo "<br><a href='index.php'>Kembali ke Halaman Utama</a>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>