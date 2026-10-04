<?php
include '../config/koneksi.php';
include '../templates/header.php';

$data = mysqli_query($koneksi, "
  SELECT h.*, p.nama_pelanggan, p.kota, p.provinsi, p.no_telp,
         w.nama_wilayah
  FROM hasil_pengelompokan h
  JOIN pelanggan p ON h.pelanggan_id = p.id
  LEFT JOIN wilayah w ON w.kota = p.kota
  ORDER BY h.ranking ASC");

$zonaA = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM hasil_pengelompokan WHERE zona LIKE 'Zona A%'"))['t'];
$zonaB = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM hasil_pengelompokan WHERE zona LIKE 'Zona B%'"))['t'];
$zonaC = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) t FROM hasil_pengelompokan WHERE zona LIKE 'Zona C%'"))['t'];
$total = $zonaA + $zonaB + $zonaC;
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title"><i class="fas fa-ranking-star"></i> Hasil Ranking TOPSIS</h2>
    <p class="page-sub">Peringkat alternatif berdasarkan skor preferensi tertinggi</p>

    <?php if($total == 0): ?>
      <div class="info-box">
        <h3><i class="fas fa-circle-info"></i> Belum Ada Hasil</h3>
        <p>Silakan klik menu <b>Hitung TOPSIS</b> terlebih dahulu untuk menghasilkan ranking.</p>
        <a href="hitung_topsis.php" class="btn-primary" style="display:inline-flex;width:auto;margin-top:10px;">
          <i class="fas fa-gears"></i> Hitung Sekarang
        </a>
      </div>
    <?php else: ?>

    <div class="cards">
      <div class="card stat-blue"><h3><?= $total ?></h3><p><i class="fas fa-list-ol"></i> Total Alternatif</p></div>
      <div class="card stat-cyan"><h3><?= $zonaA ?></h3><p><i class="fas fa-circle-check"></i> Zona A</p></div>
      <div class="card stat-navy"><h3><?= $zonaB ?></h3><p><i class="fas fa-circle-half-stroke"></i> Zona B</p></div>
      <div class="card stat-sky"><h3><?= $zonaC ?></h3><p><i class="fas fa-circle-minus"></i> Zona C</p></div>
    </div>

    <div class="table-card">
      <h3><i class="fas fa-trophy"></i> Peringkat Lengkap</h3>
      <table>
        <thead>
          <tr>
            <th style="width:90px;text-align:center;">Rank</th>
            <th>Pelanggan</th>
            <th>Kota</th>
            <th>Wilayah</th>
            <th>Skor TOPSIS</th>
            <th>Zona</th>
          </tr>
        </thead>
        <tbody>
        <?php while($r = mysqli_fetch_assoc($data)): 
          $rank = $r['ranking'];
          $medal = ''; $rankCls = '';
          if($rank == 1){ $medal = '<i class="fas fa-medal" style="color:#fbbf24;"></i>'; $rankCls='rank-1'; }
          elseif($rank == 2){ $medal = '<i class="fas fa-medal" style="color:#94a3b8;"></i>'; $rankCls='rank-2'; }
          elseif($rank == 3){ $medal = '<i class="fas fa-medal" style="color:#d97706;"></i>'; $rankCls='rank-3'; }
        ?>
          <tr>
            <td style="text-align:center;">
              <span class="rank-badge <?= $rankCls ?>"><?= $medal ?> #<?= $rank ?></span>
            </td>
            <td>
              <b><?= $r['nama_pelanggan'] ?></b><br>
              <small style="color:#94a3b8;"><i class="fas fa-phone"></i> <?= $r['no_telp'] ?></small>
            </td>
            <td><?= $r['kota'] ?></td>
            <td><?= $r['nama_wilayah'] ?: '-' ?></td>
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
    </div>

    <?php endif; ?>
  </main>
</div>
<?php include '../templates/footer.php'; ?>