<?php
session_start();
require_once "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = "";

// Proses simpan data saat tombol form ditekan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis     = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas   = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jurusan = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $alamat  = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Cek apakah NIS sudah terdaftar
    $cek_nis = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
    if (mysqli_num_rows($cek_nis) > 0) {
        $error = "NIS <b>$nis</b> sudah terdaftar! Gunakan NIS lain.";
    } else {
        $query = "INSERT INTO siswa (nis, nama, kelas, jurusan, alamat) 
                  VALUES ('$nis', '$nama', '$kelas', '$jurusan', '$alamat')";

        if (mysqli_query($conn, $query)) {
            header("Location: index.php?pesan=simpan_sukses");
            exit;
        } else {
            $error = "Gagal menyimpan data: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - MelatiSchool</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background-color: #f4f6f9; color: #333; min-height: 100vh; }
        
        header { 
            background: linear-gradient(135deg, #1e3c72 0%, #1565c0 100%); 
            color: #fff; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .header-brand { display: flex; align-items: center; gap: 10px; font-weight: bold; }
        .header-brand img { width: 35px; height: 35px; border-radius: 50%; border: 2px solid #fff; }

        .container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card h2 { color: #1565c0; margin-bottom: 20px; text-align: center; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; outline: none; }
        .form-group input:focus, .form-group textarea:focus { border-color: #1565c0; }

        .btn-container { display: flex; gap: 10px; margin-top: 20px; }
        .btn { flex: 1; padding: 10px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; text-align: center; text-decoration: none; font-size: 14px; }
        .btn-submit { background-color: #1565c0; color: #fff; }
        .btn-submit:hover { background-color: #0d47a1; }
        .btn-batal { background-color: #888; color: #fff; }
        .btn-batal:hover { background-color: #666; }

        .alert-error { background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 14px; }
    </style>
</head>
<body>

<header>
    <div class="header-brand">
        <img src="logo.png" alt="Logo">
        <span>MELATISCHOOL</span>
    </div>
</header>

<div class="container">
    <div class="card">
        <h2>Tambah Data Siswa</h2>

        <?php if (!empty($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" placeholder="Masukkan NIS..." required>
            </div>

            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama" placeholder="Masukkan Nama..." required>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" placeholder="Contoh: X RPL 1" required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" placeholder="Contoh: PPLG / RPL" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" placeholder="Masukkan Alamat Lengkap..." required></textarea>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-submit">Simpan Data</button>
                <a href="index.php" class="btn btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>