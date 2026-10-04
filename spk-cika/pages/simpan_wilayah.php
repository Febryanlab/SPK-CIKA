<?php
include '../config/koneksi.php';

$kode = mysqli_real_escape_string($koneksi, $_POST['kode_wilayah'] ?? '');
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_wilayah'] ?? '');
$kota = mysqli_real_escape_string($koneksi, $_POST['kota'] ?? '');
$prov = mysqli_real_escape_string($koneksi, $_POST['provinsi'] ?? '');
$zona = mysqli_real_escape_string($koneksi, $_POST['zona'] ?? '');
$est  = intval($_POST['estimasi_hari'] ?? 0);
$ket  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

mysqli_query($koneksi, "INSERT INTO wilayah 
  (kode_wilayah, nama_wilayah, kota, provinsi, zona, estimasi_hari, keterangan)
  VALUES ('$kode','$nama','$kota','$prov','$zona','$est','$ket')");

header("Location: ../pages/wilayah.php");
exit;
?>