<?php
include 'config/koneksi.php';
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM pelanggan"))['t'];
$total_voucher   = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM voucher"))['t'];
$total_kategori  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM kategori_kirim"))['t'];
$total_kriteria  = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM kriteria"))['t'];
include 'templates/header.php';
?>
<div class="layout">
  <?php include 'templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Dashboard</h2>
    <p class="page-sub">Selamat datang di SPK Pengelompokan Wilayah Pengiriman Voucher Fisik</p>

    <div class="cards">
      <div class="card stat-blue">
        <h3><?= $total_pelanggan ?></h3>
        <p><i class="fas fa-users"></i> Total Pelanggan</p>
      </div>
      <div class="card stat-cyan">
        <h3><?= $total_voucher ?></h3>
        <p><i class="fas fa-ticket"></i> Total Voucher</p>
      </div>
      <div class="card stat-navy">
        <h3><?= $total_kategori ?></h3>
        <p><i class="fas fa-truck-fast"></i> Kategori Kirim</p>
      </div>
      <div class="card stat-sky">
        <h3><?= $total_kriteria ?></h3>
        <p><i class="fas fa-sliders"></i> Kriteria TOPSIS</p>
      </div>
    </div>

    <div class="info-box">
      <h3><i class="fas fa-bullseye"></i> Tujuan Sistem</h3>
      <p>
        Membantu PT Cika Mulia Multimedia mengelompokkan wilayah pengiriman voucher fisik
        ke dalam <b>Zona A (Prioritas)</b>, <b>Zona B (Menengah)</b>, dan <b>Zona C (Reguler)</b>
        menggunakan metode <b>TOPSIS</b>.
      </p>
    </div>

    <div class="info-box">
      <h3><i class="fas fa-list-check"></i> Panduan Penggunaan</h3>
      <p><i class="fas fa-1"></i> Isi data <b>Pelanggan</b>, <b>Kategori Kirim</b>, dan <b>Voucher</b>.</p>
      <p><i class="fas fa-2"></i> Sesuaikan <b>Kriteria & Bobot</b>.</p>
      <p><i class="fas fa-3"></i> Isi <b>Penilaian</b> tiap pelanggan.</p>
      <p><i class="fas fa-4"></i> Klik <b>Hitung TOPSIS</b> untuk melihat hasil.</p>
      <p><i class="fas fa-5"></i> Lihat <b>Hasil, Grafik, Peta,</b> dan <b>Export</b>.</p>
    </div>
  </main>
</div>
<?php include 'templates/footer.php'; ?>