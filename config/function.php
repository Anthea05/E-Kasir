<?php
function rupiah($angka){
    if (is_numeric($angka)) {
        $hasil = "Rp " . number_format($angka, '2', ',', '.');
        return $hasil;
    } else {
        // Handle the case where $angka is not a valid number
        return "Belum ada pendapatan.";
    }
}
?>