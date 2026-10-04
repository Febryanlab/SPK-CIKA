<?php
include '../config/koneksi.php';
include '../templates/header.php';

$data = mysqli_query($koneksi,"
  SELECT h.*, p.nama_pelanggan, p.kota, p.provinsi
  FROM hasil_pengelompokan h
  JOIN pelanggan p ON h.pelanggan_id = p.id
  ORDER BY h.ranking ASC");

$total = mysqli_num_rows($data);
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title"><i class="fas fa-list-ol"></i> Hasil TOPSIS</h2>
    <p class="page-sub">Ringkasan hasil perhitungan metode TOPSIS</p>

    <?php if($total == 0): ?>
      <div class="info-box">
        <h3><i class="fas fa-circle-info"></i> Belum Ada Hasil</h3>
        <p>Silakan klik menu <b>Hitung TOPSIS</b> terlebih dahulu.</p>
        <a href="hitung_topsis.php" class="btn-primary" style="display:inline-flex;width:auto;margin-top:10px;">
          <i class="fas fa-gears"></i> Hitung Sekarang
        </a>
      </div>
    <?php else: ?>

    <div class="table-card">
      <h3><i class="fas fa-table-list"></i> Tabel Hasil Perhitungan</h3>
      <table>
        <thead>
          <tr>
            <th>Rank</th>
            <th>Pelanggan</th>
            <th>Kota</th>
            <th>Provinsi</th>
            <th>Skor TOPSIS</th>
            <th>Zona</th>
          </tr>
        </thead>
        <tbody>
        <?php mysqli_data_seek($data, 0); while($r = mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><b>#<?= $r['ranking'] ?></b></td>
            <td><?= $r['nama_pelanggan'] ?></td>
            <td><?= $r['kota'] ?></td>
            <td><?= $r['provinsi'] ?></td>
            <td><b style="color:#1e40af;"><?= number_format($r['skor_topsis'],4) ?></b></td>
            <td>
              <?php
              $cls = strpos($r['zona'],'A')!==false ? 'badge-green' :
                     (strpos($r['zona'],'B')!==false ? 'badge-yellow' : 'badge-blue');
              ?>
              <span class="badge <?= $cls ?>"><?= $r['zona'] ?></span>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>

      <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
        <a href="hasil_ranking.php" class="btn-primary" style="width:auto;">
          <i class="fas fa-ranking-star"></i> Lihat Ranking Visual
        </a>
        <a href="detail_hasil.php" class="btn-primary" style="width:auto;background:linear-gradient(135deg,#8b5cf6,#6d28d9);">
          <i class="fas fa-magnifying-glass-chart"></i> Detail Perhitungan
        </a>
      </div>
    </div>

    <?php endif; ?>
  </main>
</div>
<?php include '../templates/footer.php'; ?>