<?php
include '../config/koneksi.php';
header('Content-Type: application/json');
$q = mysqli_query($koneksi, "SELECT h.*, p.nama_pelanggan, p.kota
  FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
$data = [];
while($r = mysqli_fetch_assoc($q)) $data[] = $r;
echo json_encode($data);
?>