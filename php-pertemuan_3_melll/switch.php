<?php

$warna = "merah";

switch ($warna) {
    case "merah":
        echo "Stop!";
        break;

    case "kuning":
        echo "Hati-hati!";
        break;

    case "hijau":
        echo "Jalan!";
        break;

    default:
        echo "Warna tidak dikenali";
}