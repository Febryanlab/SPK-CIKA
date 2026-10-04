<?php
include '../config/koneksi.php';
include '../templates/header.php';

$kriteria = []; $q = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY id");
while($r=mysqli_fetch_assoc($q)) $kriteria[] = $r;

$pelanggan = []; $q = mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY id");
while($r=mysqli_fetch_assoc($q)) $pelanggan[] = $r;

$matrix = []; $q = mysqli_query($koneksi,"SELECT * FROM penilaian");
while($r=mysqli_fetch_assoc($q)) $matrix[$r['pelanggan_id']][$r['kriteria_id']] = floatval($r['nilai']);

// Normalisasi
$pembagi = [];
foreach($kriteria as $k){
  $sum = 0;
  foreach($pelanggan as $p) $sum += pow($matrix[$p['id']][$k['id']] ?? 0, 2);
  $pembagi[$k['id']] = sqrt($sum);
}
$normal = [];
foreach($pelanggan as $p)
  foreach($kriteria as $k)
    $normal[$p['id']][$k['id']] = $pembagi[$k['id']] > 0 ? ($matrix[$p['id']][$k['id']] ?? 0) / $pembagi[$k['id']] : 0;

// Terbobot
$terbobot = [];
foreach($pelanggan as $p)
  foreach($kriteria as $k)
    $terbobot[$p['id']][$k['id']] = $normal[$p['id']][$k['id']] * $k['bobot'];

// Ideal
$ideal_pos = []; $ideal_neg = [];
foreach($kriteria as $k){
  $col = [];
  foreach($pelanggan as $p) $col[] = $terbobot[$p['id']][$k['id']];
  if($k['tipe'] == 'benefit'){ $ideal_pos[$k['id']] = max($col); $ideal_neg[$k['id']] = min($col); }
  else { $ideal_pos[$k['id']] = min($col); $ideal_neg[$k['id']] = max($col); }
}

// Jarak
$d_pos = []; $d_neg = [];
foreach($pelanggan as $p){
  $sp = 0; $sn = 0;
  foreach($kriteria as $k){
    $sp += pow($terbobot[$p['id']][$k['id']] - $ideal_pos[$k['id']], 2);
    $sn += pow($terbobot[$p['id']][$k['id']] - $ideal_neg[$k['id']], 2);
  }
  $d_pos[$p['id']] = sqrt($sp); $d_neg[$p['id']] = sqrt($sn);
}

// Preferensi
$preferensi = [];
foreach($pelanggan as $p){
  $denom = $d_pos[$p['id']] + $d_neg[$p['id']];
  $preferensi[$p['id']] = $denom > 0 ? $d_neg[$p['id']] / $denom : 0;
}

arsort($preferensi);
$ranking = []; $rank = 1;
foreach($preferensi as $pid => $v) $ranking[$pid] = $rank++;

mysqli_query($koneksi,"TRUNCATE TABLE hasil_pengelompokan");
foreach($preferensi as $pid => $v){
  if($v >= 0.66) $zona = 'Zona A (Prioritas)';
  elseif($v >= 0.33) $zona = 'Zona B (Menengah)';
  else $zona = 'Zona C (Reguler)';
  $rk = $ranking[$pid];
  mysqli_query($koneksi,"INSERT INTO hasil_pengelompokan (pelanggan_id, zona, skor_topsis, ranking, tanggal_proses)
    VALUES ($pid, '$zona', $v, $rk, CURDATE())");
}
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Perhitungan TOPSIS</h2>
    <div class="alert-success">✅ Perhitungan berhasil! Hasil sudah tersimpan.</div>

    <div class="table-card">
      <h3>Hasil Akhir & Ranking</h3>
      <table>
        <thead><tr><th>Ranking</th><th>Pelanggan</th><th>Skor TOPSIS</th><th>Zona</th></tr></thead>
        <tbody>
        <?php 
        $q = mysqli_query($koneksi,"SELECT h.*, p.nama_pelanggan FROM hasil_pengelompokan h
          JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
        while($r=mysqli_fetch_assoc($q)): ?>
          <tr>
            <td><b>#<?= $r['ranking'] ?></b></td>
            <td><?= $r['nama_pelanggan'] ?></td>
            <td><?= number_format($r['skor_topsis'],4) ?></td>
            <td><span class="badge <?= strpos($r['zona'],'A')!==false?'badge-green':(strpos($r['zona'],'B')!==false?'badge-yellow':'badge-blue') ?>"><?= $r['zona'] ?></span></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
      <a href="hasil_topsis.php" class="btn-primary" style="margin-top:15px;display:inline-block;">Lihat Detail →</a>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>