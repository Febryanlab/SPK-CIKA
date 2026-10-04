<?php
include '../config/koneksi.php';
mysqli_query($koneksi,"INSERT INTO pelanggan (kode_pelanggan,nama_pelanggan,alamat,kota,provinsi,no_telp)
  VALUES ('{$_POST['kode_pelanggan']}','{$_POST['nama_pelanggan']}','{$_POST['alamat']}',
          '{$_POST['kota']}','{$_POST['provinsi']}','{$_POST['no_telp']}')");
header("Location: ../pages/pelanggan.php");
?>