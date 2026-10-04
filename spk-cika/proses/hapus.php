<?php
include '../config/koneksi.php';
$tabel = $_GET['t'] ?? '';
$id    = intval($_GET['id'] ?? 0);
$allowed = ['pelanggan','kategori_kirim','voucher','kriteria','penilaian','hasil_pengelompokan'];
if (!in_array($tabel, $allowed) || $id <= 0) die("Akses tidak valid!");
mysqli_query($koneksi, "DELETE FROM $tabel WHERE id = $id");
$redirect = $_GET['r'] ?? 'pelanggan.php';
header("Location: ../pages/$redirect");
?>