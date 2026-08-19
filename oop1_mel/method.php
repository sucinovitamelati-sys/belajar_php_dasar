<?php

class CushionYSL {

    public $harga = 1500000;

    public function info(){
        echo "Cushion YSL harganya Rp" . number_format($this->harga, 0, ',', '.');
    }

}

$ysl = new CushionYSL();

//var_dump($ysl);
echo "Harga: Rp" . number_format($ysl->harga, 0, ',', '.') . "<br>";
$ysl->info();

?>