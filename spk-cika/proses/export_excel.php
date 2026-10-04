<?php
include '../config/koneksi.php';
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Laporan_TOPSIS_" . date('Ymd') . ".xls");
echo "<table border='1'>";
echo "<tr style='background:#38bdf8; color:#fff;'>
      <th>Ranking</th><th>Pelanggan</th><th>Kota</th><th>Provinsi</th><th>Skor TOPSIS</th><th>Zona</th></tr>";
$q = mysqli_query($koneksi, "SELECT h.*, p.nama_pelanggan, p.kota, p.provinsi
  FROM hasil_pengelompokan h JOIN pelanggan p ON h.pelanggan_id = p.id ORDER BY h.ranking");
while($r = mysqli_fetch_assoc($q)){
    echo "<tr><td>{$r['ranking']}</td><td>{$r['nama_pelanggan']}</td>
      <td>{$r['kota']}</td><td>{$r['provinsi']}</td>
      <td>{$r['skor_topsis']}</td><td>{$r['zona']}</td></tr>";
}
echo "</table>";
?>