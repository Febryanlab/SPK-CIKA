<?php
include '../config/koneksi.php';
include '../templates/header.php';
$data = mysqli_query($koneksi, "SELECT h.*, p.nama_pelanggan, p.kota, p.provinsi
  FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
$lokasi = [];
while($r = mysqli_fetch_assoc($data)) $lokasi[] = $r;
$koordinat = [
  'Jakarta'=>[-6.2088,106.8456], 'Bandung'=>[-6.9175,107.6191],
  'Surabaya'=>[-7.2575,112.7521], 'Medan'=>[3.5952,98.6722],
  'Semarang'=>[-6.9932,110.4203]
];
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Peta Pengelompokan Wilayah</h2>
    <div class="table-card">
      <div id="map" style="height:500px; border-radius:12px;"></div>
    </div>
  </main>
</div>

<script>
const lokasi = <?= json_encode($lokasi) ?>;
const koordinat = <?= json_encode($koordinat) ?>;

function initMap(){
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 5, center: { lat: -2.5, lng: 118 }
  });
  lokasi.forEach(item => {
    const pos = koordinat[item.kota];
    if (!pos) return;
    const warna = item.zona.includes('A') ? '#10b981' : item.zona.includes('B') ? '#f59e0b' : '#3b82f6';
    const marker = new google.maps.Marker({
      position: { lat: pos[0], lng: pos[1] }, map: map,
      title: item.nama_pelanggan,
      icon: { path: google.maps.SymbolPath.CIRCLE, scale: 12,
        fillColor: warna, fillOpacity: 0.9, strokeColor: '#fff', strokeWeight: 2 }
    });
    const info = new google.maps.InfoWindow({
      content: `<b>${item.nama_pelanggan}</b><br>${item.kota}<br>Skor: ${parseFloat(item.skor_topsis).toFixed(4)}<br><b>${item.zona}</b>`
    });
    marker.addListener('click', () => info.open(map, marker));
  });
}
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap"></script>
<?php include '../templates/footer.php'; ?>