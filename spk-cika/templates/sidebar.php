<?php
$inPages = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$link = $inPages ? '' : 'pages/';
$dash = $inPages ? '../' : '';
?>
<aside class="sidebar" id="sidebar">
  <ul>

    <!-- DASHBOARD -->
    <li class="<?= $current=='dashboard.php'?'active':'' ?>">
      <a href="<?= $dash ?>dashboard.php">
        <i class="fas fa-house"></i>
        <span>Dashboard</span>
      </a>
    </li>

    <!-- ==================== MASTER DATA ==================== -->
    <li class="menu-label"><i class="fas fa-database"></i> Master Data</li>

    <li class="<?= $current=='pelanggan.php'?'active':'' ?>">
      <a href="<?= $link ?>pelanggan.php">
        <i class="fas fa-users"></i>
        <span>Data Pelanggan</span>
      </a>
    </li>

    <li class="<?= $current=='wilayah.php'?'active':'' ?>">
      <a href="<?= $link ?>wilayah.php">
        <i class="fas fa-map-location-dot"></i>
        <span>Data Wilayah</span>
      </a>
    </li>

    <li class="<?= $current=='kategori_kirim.php'?'active':'' ?>">
      <a href="<?= $link ?>kategori_kirim.php">
        <i class="fas fa-truck-fast"></i>
        <span>Kategori Jasa Kirim</span>
      </a>
    </li>

    <li class="<?= $current=='voucher.php'?'active':'' ?>">
      <a href="<?= $link ?>voucher.php">
        <i class="fas fa-ticket"></i>
        <span>Data Voucher Fisik</span>
      </a>
    </li>

    <!-- ==================== PROSES TOPSIS ==================== -->
    <li class="menu-label"><i class="fas fa-calculator"></i> Proses TOPSIS</li>

    <li class="<?= $current=='kriteria.php'?'active':'' ?>">
      <a href="<?= $link ?>kriteria.php">
        <i class="fas fa-sliders"></i>
        <span>Kriteria & Bobot</span>
      </a>
    </li>

    <li class="<?= $current=='penilaian.php'?'active':'' ?>">
      <a href="<?= $link ?>penilaian.php">
        <i class="fas fa-clipboard-list"></i>
        <span>Penilaian Alternatif</span>
      </a>
    </li>

    <li class="<?= $current=='hitung_topsis.php'?'active':'' ?>">
      <a href="<?= $link ?>hitung_topsis.php">
        <i class="fas fa-gears"></i>
        <span>Hitung TOPSIS</span>
      </a>
    </li>

    <!-- ==================== HASIL & LAPORAN ==================== -->
    <li class="menu-label"><i class="fas fa-chart-line"></i> Hasil & Laporan</li>

    <li class="<?= $current=='hasil_ranking.php'?'active':'' ?>">
      <a href="<?= $link ?>hasil_ranking.php">
        <i class="fas fa-ranking-star"></i>
        <span>Hasil Ranking</span>
      </a>
    </li>

    <li class="<?= $current=='detail_hasil.php'?'active':'' ?>">
      <a href="<?= $link ?>detail_hasil.php">
        <i class="fas fa-magnifying-glass-chart"></i>
        <span>Detail Perhitungan</span>
      </a>
    </li>

    <li class="<?= $current=='pengelompokan.php'?'active':'' ?>">
      <a href="<?= $link ?>pengelompokan.php">
        <i class="fas fa-layer-group"></i>
        <span>Pengelompokan Wilayah</span>
      </a>
    </li>

    <li class="<?= $current=='grafik.php'?'active':'' ?>">
      <a href="<?= $link ?>grafik.php">
        <i class="fas fa-chart-pie"></i>
        <span>Grafik Visualisasi</span>
      </a>
    </li>

    <li class="<?= $current=='peta_zona.php'?'active':'' ?>">
      <a href="<?= $link ?>peta_zona.php">
        <i class="fas fa-map-pin"></i>
        <span>Peta Zona</span>
      </a>
    </li>

  </ul>

  <div class="sidebar-footer">
    <p><i class="fas fa-code"></i> SPK TOPSIS v1.1</p>
  </div>
</aside>