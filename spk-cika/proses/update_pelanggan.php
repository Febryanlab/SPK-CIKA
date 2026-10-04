<?php
include '../config/koneksi.php';
$id = intval($_POST['id']);
mysqli_query($koneksi,"UPDATE pelanggan SET
  kode_pelanggan='{$_POST['kode_pelanggan']}',
  nama_pelanggan='{$_POST['nama_pelanggan']}',
  alamat='{$_POST['alamat']}',
  kota='{$_POST['kota']}',
  provinsi='{$_POST['provinsi']}',
  no_telp='{$_POST['no_telp']}'
  WHERE id=$id");
header("Location: ../pages/pelanggan.php");
?>