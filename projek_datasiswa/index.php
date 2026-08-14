<?php
session_start();
require_once "config.php";

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$search = "";

if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);

    $query = mysqli_query(
        $conn,
        "SELECT * FROM siswa
        WHERE nis LIKE '%$search%'
        OR nama LIKE '%$search%'
        OR kelas LIKE '%$search%'
        OR jurusan LIKE '%$search%'
        OR alamat LIKE '%$search%'
        ORDER BY nis DESC"
    );
} else {
    $query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis DESC");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa - MelatiSchool</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        
        body { 
            background-color: #f4f6f9; 
            color: #333; 
            min-height: 100vh;
        }

        /* Header / Navbar */
        header { 
            background: linear-gradient(135deg, #1e3c72 0%, #1565c0 100%); 
            color: #fff; 
            padding: 15px 30px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .header-brand img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        header .logo { 
            font-size: 20px; 
            font-weight: bold; 
            letter-spacing: 1px;
        }

        header .user-nav {
            display: flex;
            align-items: center;
            gap: 15px;
            font-size: 14px;
        }

        header a { 
            color: #fff; 
            text-decoration: none; 
            padding: 8px 14px; 
            border-radius: 6px; 
            font-size: 13px; 
            font-weight: bold;
            transition: 0.3s;
        }

        header a.menu { background-color: rgba(255,255,255,0.2); }
        header a.menu:hover { background-color: rgba(255,255,255,0.3); }

        header a.logout { background-color: #d32f2f; }
        header a.logout:hover { background-color: #b71c1c; }

        /* Main Container */
        .container { 
            max-width: 1100px; 
            margin: 30px auto; 
            padding: 0 20px; 
        }

        /* Top Title & Button */
        .judul { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 25px; 
        }

        .judul h1 { 
            color: #1565c0; 
            font-size: 24px; 
            margin-bottom: 5px;
        }

        .judul p { color: #666; font-size: 14px; }

        .tombol { 
            background-color: #1565c0; 
            color: #fff; 
            padding: 10px 18px; 
            border-radius: 6px; 
            text-decoration: none; 
            font-weight: bold; 
            font-size: 14px; 
            transition: 0.3s;
        }

        .tombol:hover { background-color: #0d47a1; }

        /* Search Form */
        .search-box { 
            margin-bottom: 20px; 
        }

        .search-box form {
            display: flex;
            gap: 10px;
        }

        .search-box input { 
            flex: 1; 
            padding: 10px 14px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            font-size: 14px; 
            outline: none;
        }

        .search-box input:focus { 
            border-color: #1565c0; 
            box-shadow: 0 0 5px rgba(21, 101, 192, 0.3);
        }

        .search-box button { 
            padding: 10px 20px; 
            background-color: #1565c0; 
            color: #fff; 
            border: none; 
            border-radius: 6px; 
            font-weight: bold; 
            cursor: pointer; 
            transition: 0.3s;
        }

        .search-box button:hover { background-color: #0d47a1; }

        /* Table Card */
        .card-table { 
            background: #fff; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
            text-align: left; 
            font-size: 14px; 
        }

        thead { 
            background-color: #1565c0; 
            color: #fff; 
        }

        th, td { 
            padding: 12px 15px; 
            border-bottom: 1px solid #eee; 
            vertical-align: middle;
        }

        tbody tr:hover { 
            background-color: #f1f5f9; 
        }

        /* Style Tombol Aksi */
        .btn-action {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            color: #fff !important;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
            transition: 0.2s;
            text-align: center;
            width: 60px;
            cursor: pointer;
        }

        .btn-edit {
            background-color: #f39c12;
        }

        .btn-edit:hover {
            background-color: #d68910;
        }

        .btn-hapus {
            background-color: #e74c3c;
        }

        .btn-hapus:hover {
            background-color: #c0392b;
        }

        .no-data {
            text-align: center;
            color: #888;
            padding: 20px;
        }

        /* Responsive UI */
        @media (max-width: 768px) {
            header { flex-direction: column; gap: 10px; text-align: center; }
            .judul { flex-direction: column; align-items: flex-start; gap: 15px; }
            .card-table { overflow-x: auto; }
        }
    </style>
</head>
<body>

<!-- Header Navigation -->
<header>
    <div class="header-brand">
        <img src="logo.png" alt="Logo">
        <div class="logo">MELATISCHOOL</div>
    </div>

    <div class="user-nav">
        <span>Halo, <b><?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?></b></span>
        <a href="tambah.php" class="menu">+ Tambah Siswa</a>
        <a href="logout.php" class="logout">Logout</a>
    </div>
</header>

<!-- Main Content -->
<div class="container">

    <div class="judul">
        <div>
            <h1>Data Siswa</h1>
            <p>Kelola data siswa MelatiSchool dengan mudah.</p>
        </div>
        <a href="tambah.php" class="tombol">+ Tambah Siswa</a>
    </div>

    <!-- Search Box -->
    <div class="search-box">
        <form method="GET">
            <input
                type="text"
                name="search"
                placeholder="Cari berdasarkan NIS, nama, kelas, jurusan, atau alamat..."
                value="<?= htmlspecialchars($search) ?>"
            >
            <button type="submit">Cari</button>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="card-table">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Alamat</th>
                    <th style="width: 100px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            if (mysqli_num_rows($query) > 0):
                while ($data = mysqli_fetch_assoc($query)):
                    // Deteksi ID otomatis: cari kolom 'id', 'id_siswa', atau gunakan 'nis'
                    $id_target = $data['id'] ?? $data['id_siswa'] ?? $data['nis'];
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($data['nis']) ?></td>
                    <td><?= htmlspecialchars($data['nama']) ?></td>
                    <td><?= htmlspecialchars($data['kelas']) ?></td>
                    <td><?= htmlspecialchars($data['jurusan']) ?></td>
                    <td><?= htmlspecialchars($data['alamat']) ?></td>
                    <td style="text-align: center;">
                        <a href="edit.php?id=<?= $id_target; ?>" class="btn-action btn-edit">Edit</a>
                        <a href="hapus.php?id=<?= $id_target; ?>" class="btn-action btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">Hapus</a>
                    </td>
                </tr>
            <?php 
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="7" class="no-data">Data siswa tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>