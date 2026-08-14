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

// Query untuk menyisipkan data baru
$sql = "INSERT INTO orang (id, nama, kelas, jurusan, alamat) VALUES (null, 'Melati', Xlpplg1, 'pplg', 'sumedang'),
(null, 'suci', Xlpplg1, 'pplg', 'dsn.ciloa'),";

// Menjalankan query
if (mysqli_query($conn, $sql)) {
    echo "Data berhasil ditambahkan<br>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Menutup koneksi
mysqli_close($conn);
?>
