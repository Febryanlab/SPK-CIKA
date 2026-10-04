<?php
include '../config/koneksi.php';
include '../templates/header.php';

$zonaA = mysqli_query($koneksi,"SELECT h.*,p.nama_pelanggan,p.kota FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id=p.id WHERE h.zona LIKE 'Zona A%' ORDER BY h.ranking");
$zonaB = mysqli_query($koneksi,"SELECT h.*,p.nama_pelanggan,p.kota FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id=p.id WHERE h.zona LIKE 'Zona B%' ORDER BY h.ranking");
$zonaC = mysqli_query($koneksi,"SELECT h.*,p.nama_pelanggan,p.kota FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id=p.id WHERE h.zona LIKE 'Zona C%' ORDER BY h.ranking");
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Pengelompokan Wilayah Pengiriman</h2>
    <p class="page-sub">Hasil clustering berdasarkan skor TOPSIS</p>

    <div class="zona-grid">
      <div class="zona zona-a">
        <h3>🟢 Zona A — Prioritas</h3>
        <p class="small">Skor ≥ 0.66</p>
        <ul><?php while($r=mysqli_fetch_assoc($zonaA)): ?>
          <li><b><?= $r['nama_pelanggan'] ?></b> — <?= $r['kota'] ?> <span>(<?= number_format($r['skor_topsis'],3) ?>)</span></li>
        <?php endwhile; ?></ul>
      </div>
      <div class="zona zona-b">
        <h3>🟡 Zona B — Menengah</h3>
        <p class="small">Skor 0.33 – 0.66</p>
        <ul><?php while($r=mysqli_fetch_assoc($zonaB)): ?>
          <li><b><?= $r['nama_pelanggan'] ?></b> — <?= $r['kota'] ?> <span>(<?= number_format($r['skor_topsis'],3) ?>)</span></li>
        <?php endwhile; ?></ul>
      </div>
      <div class="zona zona-c">
        <h3>🔵 Zona C — Reguler</h3>
        <p class="small">Skor &lt; 0.33</p>
        <ul><?php while($r=mysqli_fetch_assoc($zonaC)): ?>
          <li><b><?= $r['nama_pelanggan'] ?></b> — <?= $r['kota'] ?> <span>(<?= number_format($r['skor_topsis'],3) ?>)</span></li>
        <?php endwhile; ?></ul>
      </div>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>