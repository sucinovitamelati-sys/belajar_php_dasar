<?php
$orang = [
    ["Nama" => "Melati", "Umur" => 25],
    ["Nama" => "Suci", "Umur" => 30],
    ["Nama" => "Novita", "Umur" => 35]
];

foreach ($orang as $individu) {
    echo $individu["Nama"] . " berumur " . $individu["Umur"] . " tahun.<br>";
}
?>