<?php
include '../config/koneksi.php';
include '../templates/header.php';

$kriteria = []; $q = mysqli_query($koneksi, "SELECT * FROM kriteria ORDER BY id");
while($r = mysqli_fetch_assoc($q)) $kriteria[] = $r;
$pelanggan = []; $q = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id");
while($r = mysqli_fetch_assoc($q)) $pelanggan[] = $r;
$matrix = []; $q = mysqli_query($koneksi, "SELECT * FROM penilaian");
while($r = mysqli_fetch_assoc($q)) $matrix[$r['pelanggan_id']][$r['kriteria_id']] = floatval($r['nilai']);

$pembagi = [];
foreach($kriteria as $k){
  $sum = 0; foreach($pelanggan as $p) $sum += pow($matrix[$p['id']][$k['id']] ?? 0, 2);
  $pembagi[$k['id']] = sqrt($sum);
}
$normal = [];
foreach($pelanggan as $p) foreach($kriteria as $k)
  $normal[$p['id']][$k['id']] = $pembagi[$k['id']] > 0 ? ($matrix[$p['id']][$k['id']] ?? 0) / $pembagi[$k['id']] : 0;
$terbobot = [];
foreach($pelanggan as $p) foreach($kriteria as $k)
  $terbobot[$p['id']][$k['id']] = $normal[$p['id']][$k['id']] * $k['bobot'];

$ideal_pos = []; $ideal_neg = [];
foreach($kriteria as $k){
  $col = []; foreach($pelanggan as $p) $col[] = $terbobot[$p['id']][$k['id']];
  if($k['tipe'] == 'benefit'){ $ideal_pos[$k['id']] = max($col); $ideal_neg[$k['id']] = min($col); }
  else { $ideal_pos[$k['id']] = min($col); $ideal_neg[$k['id']] = max($col); }
}
$d_pos = []; $d_neg = [];
foreach($pelanggan as $p){
  $sp = 0; $sn = 0;
  foreach($kriteria as $k){
    $sp += pow($terbobot[$p['id']][$k['id']] - $ideal_pos[$k['id']], 2);
    $sn += pow($terbobot[$p['id']][$k['id']] - $ideal_neg[$k['id']], 2);
  }
  $d_pos[$p['id']] = sqrt($sp); $d_neg[$p['id']] = sqrt($sn);
}
$preferensi = [];
foreach($pelanggan as $p){
  $denom = $d_pos[$p['id']] + $d_neg[$p['id']];
  $preferensi[$p['id']] = $denom > 0 ? $d_neg[$p['id']] / $denom : 0;
}
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Detail Perhitungan TOPSIS</h2>
    <p class="page-sub">Menampilkan setiap tahapan perhitungan</p>

    <div class="table-card"><h3>📋 1. Matriks Keputusan (X)</h3>
      <table><thead><tr><th>Alternatif</th>
        <?php foreach($kriteria as $k): ?><th><?= $k['kode'] ?></th><?php endforeach; ?>
      </tr></thead><tbody>
      <?php foreach($pelanggan as $p): ?>
        <tr><td><b><?= $p['nama_pelanggan'] ?></b></td>
          <?php foreach($kriteria as $k): ?><td><?= $matrix[$p['id']][$k['id']] ?? 0 ?></td><?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>

    <div class="table-card"><h3>📐 2. Nilai Pembagi</h3>
      <table><thead><tr><?php foreach($kriteria as $k): ?><th><?= $k['kode'] ?></th><?php endforeach; ?></tr></thead>
      <tbody><tr><?php foreach($kriteria as $k): ?><td><?= number_format($pembagi[$k['id']],4) ?></td><?php endforeach; ?></tr></tbody></table>
    </div>

    <div class="table-card"><h3>🔢 3. Matriks Ternormalisasi (R)</h3>
      <table><thead><tr><th>Alternatif</th>
        <?php foreach($kriteria as $k): ?><th><?= $k['kode'] ?></th><?php endforeach; ?>
      </tr></thead><tbody>
      <?php foreach($pelanggan as $p): ?>
        <tr><td><?= $p['nama_pelanggan'] ?></td>
          <?php foreach($kriteria as $k): ?><td><?= number_format($normal[$p['id']][$k['id']],4) ?></td><?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>

    <div class="table-card"><h3>⚖️ 4. Matriks Terbobot (Y = R × W)</h3>
      <table><thead><tr><th>Alternatif</th>
        <?php foreach($kriteria as $k): ?><th><?= $k['kode'] ?> (w=<?= $k['bobot'] ?>)</th><?php endforeach; ?>
      </tr></thead><tbody>
      <?php foreach($pelanggan as $p): ?>
        <tr><td><?= $p['nama_pelanggan'] ?></td>
          <?php foreach($kriteria as $k): ?><td><?= number_format($terbobot[$p['id']][$k['id']],5) ?></td><?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>

    <div class="table-card"><h3>🎯 5. Solusi Ideal Positif (A+) & Negatif (A-)</h3>
      <table><thead><tr><th>Kriteria</th><th>Tipe</th><th>A+</th><th>A-</th></tr></thead><tbody>
      <?php foreach($kriteria as $k): ?>
        <tr><td><?= $k['kode'] ?> — <?= $k['nama_kriteria'] ?></td>
          <td><span class="badge <?= $k['tipe']=='benefit'?'badge-green':'badge-red' ?>"><?= $k['tipe'] ?></span></td>
          <td><?= number_format($ideal_pos[$k['id']],5) ?></td>
          <td><?= number_format($ideal_neg[$k['id']],5) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>

    <div class="table-card"><h3>📊 6. Jarak D+, D- & Nilai Preferensi (V)</h3>
      <table><thead><tr><th>Alternatif</th><th>D+</th><th>D-</th><th>V</th></tr></thead><tbody>
      <?php foreach($pelanggan as $p): ?>
        <tr><td><?= $p['nama_pelanggan'] ?></td>
          <td><?= number_format($d_pos[$p['id']],5) ?></td>
          <td><?= number_format($d_neg[$p['id']],5) ?></td>
          <td><b><?= number_format($preferensi[$p['id']],5) ?></b></td>
        </tr>
      <?php endforeach; ?>
      </tbody></table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>