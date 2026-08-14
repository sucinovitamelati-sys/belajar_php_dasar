<?php
session_start();
require_once "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah form disubmit via method POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dan amankan dari SQL Injection
    $nis     = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas   = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Simpan data ke database
    $query = mysqli_query(
        $conn,
        "INSERT INTO siswa (nis, nama, kelas, jurusan, alamat) 
         VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$alamat')"
    );

    if ($query) {
        // Berhasil simpan, redirect ke index.php dengan notifikasi
        header("Location: index.php?pesan=simpan_sukses");
        exit;
    } else {
        // Gagal simpan
        die("Data gagal disimpan: " . mysqli_error($conn));
    }

} else {
    // Jika diakses langsung tanpa POST, kembalikan ke tambah.php
    header("Location: tambah.php");
    exit;
}
?>