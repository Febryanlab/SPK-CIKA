<?php
include '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT h.skor_topsis, p.nama_pelanggan, h.zona
  FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
$labels = []; $values = []; $zonas = [];
while($r = mysqli_fetch_assoc($data)){ $labels[] = $r['nama_pelanggan']; $values[] = round($r['skor_topsis'],4); $zonas[] = $r['zona']; }
$zonaCount = ['A'=>0,'B'=>0,'C'=>0];
foreach($zonas as $z){
  if (strpos($z,'A') !== false) $zonaCount['A']++;
  elseif (strpos($z,'B') !== false) $zonaCount['B']++;
  else $zonaCount['C']++;
}
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Grafik & Visualisasi</h2>

    <div class="cards">
      <div class="card stat-blue"><h3><?= $zonaCount['A'] ?></h3><p>Zona A</p></div>
      <div class="card stat-cyan"><h3><?= $zonaCount['B'] ?></h3><p>Zona B</p></div>
      <div class="card stat-navy"><h3><?= $zonaCount['C'] ?></h3><p>Zona C</p></div>
    </div>

    <div class="chart-grid">
      <div class="table-card"><h3>📊 Skor TOPSIS</h3><canvas id="barChart" height="200"></canvas></div>
      <div class="table-card"><h3>🥧 Distribusi Zona</h3><canvas id="pieChart" height="200"></canvas></div>
    </div>

    <div class="table-card"><h3>📈 Perbandingan Skor</h3><canvas id="lineChart" height="120"></canvas></div>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const labels = <?= json_encode($labels) ?>;
const values = <?= json_encode($values) ?>;
const zonaCount = <?= json_encode(array_values($zonaCount)) ?>;

new Chart(document.getElementById('barChart'), {
  type: 'bar',
  data: { labels: labels, datasets: [{ label:'Skor', data: values,
    backgroundColor:'rgba(56,189,248,0.7)', borderColor:'#1e40af', borderWidth:2, borderRadius:8 }] },
  options: { responsive:true, plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true,max:1}} }
});
new Chart(document.getElementById('pieChart'), {
  type: 'doughnut',
  data: { labels:['Zona A','Zona B','Zona C'], datasets:[{ data: zonaCount,
    backgroundColor:['#10b981','#f59e0b','#3b82f6'] }] },
  options: { responsive:true }
});
new Chart(document.getElementById('lineChart'), {
  type: 'line',
  data: { labels: labels, datasets: [{ label:'Skor', data: values, borderColor:'#1e40af',
    backgroundColor:'rgba(56,189,248,0.2)', tension:0.4, fill:true, pointRadius:6 }] },
  options: { responsive:true, scales:{y:{beginAtZero:true,max:1}} }
});
</script>
<?php include '../templates/footer.php'; ?>