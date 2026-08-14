<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "php_dasar";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
echo "Koneksi berhasil<br>";

$sql = "SELECT * FROM orang";
$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($data as $row) {
    echo $row["nama"] . " ";
    echo $row["kelas"] . " ";
    echo $row["jurusan"] . " ";
    echo $row["alamat"] . " ";
    echo "<br>";
}
?>
