<?php
session_start();
require_once "config.php";

$error = "";

if (isset($_POST['register'])) {

    $nama    = mysqli_real_escape_string($conn, $_POST['nama']);
    $email   = mysqli_real_escape_string($conn, $_POST['email']);
    $pasword = mysqli_real_escape_string($conn, $_POST['pasword']);

    // Cek apakah email sudah terdaftar
    $cek = mysqli_query($conn, "SELECT * FROM `user` WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {
        $error = "Email sudah terdaftar!";
    } else {
        // Insert data user baru
        $query = mysqli_query(
            $conn,
            "INSERT INTO `user` (nama, email, pasword) VALUES ('$nama', '$email', '$pasword')"
        );

        if ($query) {
            header("Location: login.php");
            exit;
        } else {
            $error = "Registrasi gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MelatiSchool</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: sans-serif; }
        
        /* Background Utama Biru Soft Gradient */
        body { 
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            padding: 20px; 
        }

        /* Container Card */
        .card { 
            background: #fff; 
            width: 100%; 
            max-width: 780px; 
            display: flex; 
            border-radius: 12px; 
            overflow: hidden; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.25); 
        }

        /* Side Brand (Kiri) - Biru Tua */
        .brand { 
            background: linear-gradient(180deg, #1565c0 0%, #0d47a1 100%); 
            color: #fff; 
            width: 42%; 
            padding: 30px 20px; 
            text-align: center; 
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            position: relative;
            overflow: hidden;
        }

        /* Container Logo Animasi */
        .logo-container {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Sinar Latar Belakang Berputar */
        .sunburst {
            position: absolute;
            width: 140px;
            height: 140px;
            background: conic-gradient(from 0deg, rgba(255,255,255,0.2), transparent 20deg, rgba(255,255,255,0.2) 40deg, transparent 60deg);
            border-radius: 50%;
            animation: spinGlow 12s linear infinite;
        }

        /* Tampilan Gambar Logo (IMG) */
        .logo-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #ffffff;
            z-index: 2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            animation: pulseBloom 3s ease-in-out infinite alternate;
        }

        /* Partikel Kilau Melayang */
        .sparkle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: #fff;
            border-radius: 50%;
            box-shadow: 0 0 8px #fff;
            opacity: 0;
            z-index: 3;
            animation: sparkleAnim 2.5s infinite ease-in-out;
        }
        .sparkle-1 { top: 15%; left: 20%; animation-delay: 0s; }
        .sparkle-2 { top: 25%; right: 15%; animation-delay: 0.8s; }
        .sparkle-3 { bottom: 20%; left: 25%; animation-delay: 1.5s; }

        /* KEYFRAMES ANIMASI */
        @keyframes spinGlow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulseBloom {
            0% { transform: scale(0.95); }
            100% { transform: scale(1.05); }
        }

        @keyframes sparkleAnim {
            0% { transform: translateY(0) scale(0); opacity: 0; }
            50% { opacity: 1; transform: translateY(-8px) scale(1.2); }
            100% { transform: translateY(-15px) scale(0); opacity: 0; }
        }

        .brand h1 { 
            font-size: 22px; 
            margin-bottom: 5px; 
            letter-spacing: 1.5px;
            z-index: 2;
        }

        .brand p { 
            font-size: 12px; 
            opacity: 0.85; 
            z-index: 2;
        }

        /* Form Box (Kanan) */
        .form-box { width: 58%; padding: 35px 30px; }
        .form-box h2 { color: #1565c0; margin-bottom: 18px; font-size: 22px; }
        
        .error { 
            background: #ffebee; 
            color: #c62828; 
            padding: 9px 12px; 
            border-radius: 6px; 
            font-size: 13px; 
            margin-bottom: 15px; 
            border-left: 4px solid #c62828;
        }

        label { font-size: 12px; font-weight: bold; color: #444; display: block; margin-bottom: 6px; }
        
        input { 
            width: 100%; 
            padding: 11px 12px; 
            margin-bottom: 16px; 
            border: 1px solid #ccc; 
            border-radius: 6px; 
            outline: none; 
            font-size: 14px;
            transition: 0.3s;
        }

        /* Highlight Focus Warna Biru */
        input:focus { border-color: #1565c0; box-shadow: 0 0 6px rgba(21, 101, 192, 0.3); }

        /* Tombol Register Biru */
        button { 
            width: 100%; 
            padding: 11px; 
            background: #1565c0; 
            color: #fff; 
            border: none; 
            border-radius: 6px; 
            font-weight: bold; 
            font-size: 14px;
            cursor: pointer; 
            transition: 0.3s;
            margin-top: 5px;
        }

        button:hover { background: #0d47a1; }

        .register-link { text-align: center; margin-top: 18px; font-size: 13px; color: #666; }
        .register-link a { color: #1565c0; text-decoration: none; font-weight: bold; }
        .register-link a:hover { text-decoration: underline; }

        @media (max-width: 650px) {
            .card { flex-direction: column; }
            .brand, .form-box { width: 100%; }
            .brand { padding: 25px 15px; }
        }
    </style>
</head>
<body>

<div class="card">
    <!-- Panel Brand dengan Logo Gambar & Animasi Glow -->
    <div class="brand">
        <div class="logo-container">
            <div class="sunburst"></div>
            <div class="sparkle sparkle-1"></div>
            <div class="sparkle sparkle-2"></div>
            <div class="sparkle sparkle-3"></div>
            
            <!-- TAG IMG LOGO SUDAH DIUBAH KE logo.png -->
            <img src="logo.png" alt="Logo MelatiSchool" class="logo-img">
        </div>

        <h1>MELATISCHOOL</h1>
        <p>Sistem Informasi Data Siswa</p>
    </div>

    <!-- Form Register -->
    <div class="form-box">
        <h2>Register</h2>

        <?php if ($error != "") { ?>
            <div class="error"><?= $error ?></div>
        <?php } ?>

        <form method="POST">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan nama" required>

            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan email" required>

            <label>Password</label>
            <input type="password" name="pasword" placeholder="Masukkan password" required>

            <button type="submit" name="register">REGISTER</button>
        </form>

        <p class="register-link">
            Sudah punya akun? <a href="login.php">Login di sini</a>
        </p>
    </div>
</div>

</body>
</html>