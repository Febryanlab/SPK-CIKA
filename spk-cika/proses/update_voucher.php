<?php
include '../config/koneksi.php';
$id = intval($_POST['id']);
mysqli_query($koneksi,"UPDATE voucher SET
  kode_voucher='{$_POST['kode_voucher']}',
  nama_voucher='{$_POST['nama_voucher']}',
  jenis_voucher='{$_POST['jenis_voucher']}',
  pelanggan_id='{$_POST['pelanggan_id']}',
  kategori_kirim_id='{$_POST['kategori_kirim_id']}',
  jumlah='{$_POST['jumlah']}',
  berat_total='{$_POST['berat_total']}',
  tanggal_pesan='{$_POST['tanggal_pesan']}'
  WHERE id=$id");
header("Location: ../pages/voucher.php");
?>