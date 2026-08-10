<?php
// Mendefinisikan array multidimensi menggunakan []
$orang = [
    ["Nama" => "Melati", "Umur" => 25],
    ["Nama" => "Suci", "Umur" => 30],
    ["Nama" => "Novita", "Umur" => 35]
];

// Mengakses elemen array multidimensi
echo $orang[0]["Nama"] . " berumur " . $orang[0]["Umur"] . " tahun.<br>"; // Output: agus berumur 25 tahun.
echo $orang[1]["Nama"] . " berumur " . $orang[1]["Umur"] . " tahun.<br>"; // Output: budi berumur 30 tahun.
?>