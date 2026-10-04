<?php
include '../config/koneksi.php';
mysqli_query($koneksi,"INSERT INTO voucher
  (kode_voucher,nama_voucher,jenis_voucher,pelanggan_id,kategori_kirim_id,jumlah,berat_total,tanggal_pesan)
  VALUES ('{$_POST['kode_voucher']}','{$_POST['nama_voucher']}','{$_POST['jenis_voucher']}',
          '{$_POST['pelanggan_id']}','{$_POST['kategori_kirim_id']}','{$_POST['jumlah']}',
          '{$_POST['berat_total']}','{$_POST['tanggal_pesan']}')");
header("Location: ../pages/voucher.php");
?>