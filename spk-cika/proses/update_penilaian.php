<?php
include '../config/koneksi.php';
$data = $_POST['nilai'] ?? [];
foreach ($data as $pelanggan_id => $kriteriaArr) {
    foreach ($kriteriaArr as $kriteria_id => $nilai) {
        $pid = intval($pelanggan_id);
        $kid = intval($kriteria_id);
        $val = floatval($nilai);
        $cek = mysqli_query($koneksi, "SELECT id FROM penilaian WHERE pelanggan_id=$pid AND kriteria_id=$kid");
        if (mysqli_num_rows($cek) > 0) {
            mysqli_query($koneksi, "UPDATE penilaian SET nilai=$val WHERE pelanggan_id=$pid AND kriteria_id=$kid");
        } else {
            mysqli_query($koneksi, "INSERT INTO penilaian (pelanggan_id, kriteria_id, nilai) VALUES ($pid, $kid, $val)");
        }
    }
}
header("Location: ../pages/penilaian_massal.php?ok=1");
?>