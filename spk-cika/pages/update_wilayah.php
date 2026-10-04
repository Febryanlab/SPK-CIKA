<?php
include '../config/koneksi.php';

$id   = intval($_POST['id'] ?? 0);
$kode = mysqli_real_escape_string($koneksi, $_POST['kode_wilayah'] ?? '');
$nama = mysqli_real_escape_string($koneksi, $_POST['nama_wilayah'] ?? '');
$kota = mysqli_real_escape_string($koneksi, $_POST['kota'] ?? '');
$prov = mysqli_real_escape_string($koneksi, $_POST['provinsi'] ?? '');
$zona = mysqli_real_escape_string($koneksi, $_POST['zona'] ?? '');
$est  = intval($_POST['estimasi_hari'] ?? 0);
$ket  = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

mysqli_query($koneksi, "UPDATE wilayah SET 
  kode_wilayah = '$kode',
  nama_wilayah = '$nama',
  kota = '$kota',
  provinsi = '$prov',
  zona = '$zona',
  estimasi_hari = '$est',
  keterangan = '$ket'
  WHERE id = $id");

header("Location: ../pages/wilayah.php");
exit;
?>