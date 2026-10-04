<?php
include '../config/koneksi.php';
mysqli_query($koneksi,"INSERT INTO kategori_kirim (nama_kategori,estimasi_hari,biaya_per_kg,keterangan)
  VALUES ('{$_POST['nama_kategori']}','{$_POST['estimasi_hari']}','{$_POST['biaya_per_kg']}','{$_POST['keterangan']}')");
header("Location: ../pages/kategori_kirim.php");
?>