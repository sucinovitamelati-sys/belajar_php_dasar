<?php
function tambah($a, $b) {
    return $a + $b;
}

// Hasilnya bisa digunakan dalam operasi lain
$total = tambah(3, 4) * 2; // (3 + 4) * 2
echo $total; // Output: 14
?>