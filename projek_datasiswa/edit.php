<?php
session_start();
require_once "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Cek apakah ada ID / NIS yang dikirim via URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data siswa berdasarkan NIS atau ID
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$id' OR id = '$id'");
$data = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$data) {
    echo "Data siswa tidak ditemukan! <a href='index.php'>Kembali</a>";
    exit;
}

// Proses Update Data saat Form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis_lama = mysqli_real_escape_string($conn, $_POST['nis_lama']);
    $nis      = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
    $jurusan  = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $alamat   = mysqli_real_escape_string($conn, $_POST['alamat']);

    $update_query = "UPDATE siswa SET 
                        nis = '$nis',
                        nama = '$nama',
                        kelas = '$kelas',
                        jurusan = '$jurusan',
                        alamat = '$alamat'
                     WHERE nis = '$nis_lama' OR id = '$nis_lama'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: index.php?pesan=edit_sukses");
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa - MelatiSchool</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        body { background-color: #f4f6f9; color: #333; min-height: 100vh; }
        header { background: linear-gradient(135deg, #1e3c72 0%, #1565c0 100%); color: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; }
        .header-brand { display: flex; align-items: center; gap: 10px; font-weight: bold; }
        .header-brand img { width: 35px; height: 35px; border-radius: 50%; border: 2px solid #fff; }
        .container { max-width: 600px; margin: 40px auto; padding: 0 20px; }
        .card { background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .card h2 { color: #1565c0; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; font-size: 14px; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font-size: 14px; }
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
        <h2>Edit Data Siswa</h2>

        <?php if (isset($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <!-- Menyimpan ID/NIS Lama untuk WHERE clause -->
            <input type="hidden" name="nis_lama" value="<?= htmlspecialchars($data['nis']) ?>">

            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" value="<?= htmlspecialchars($data['nis']) ?>" required>
            </div>

            <div class="form-group">
                <label>Nama Siswa</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required>
            </div>

            <div class="form-group">
                <label>Jurusan</label>
                <input type="text" name="jurusan" value="<?= htmlspecialchars($data['jurusan']) ?>" required>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-submit">Simpan Perubahan</button>
                <a href="index.php" class="btn btn-batal">Batal</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>