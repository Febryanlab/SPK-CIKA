<?php
include '../config/koneksi.php';
$plg = mysqli_query($koneksi,"SELECT * FROM pelanggan");
$kri = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY id");
$matrix = [];
$q = mysqli_query($koneksi,"SELECT * FROM penilaian");
while($r=mysqli_fetch_assoc($q)) $matrix[$r['pelanggan_id']][$r['kriteria_id']] = $r['nilai'];
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Penilaian Alternatif</h2>
    <div class="table-card">
      <table>
        <thead>
          <tr><th>Pelanggan</th>
          <?php mysqli_data_seek($kri,0); while($k=mysqli_fetch_assoc($kri)): ?>
            <th><?= $k['kode'] ?><br><small><?= $k['nama_kriteria'] ?></small></th>
          <?php endwhile; ?>
          </tr>
        </thead>
        <tbody>
        <?php mysqli_data_seek($plg,0); while($p=mysqli_fetch_assoc($plg)): ?>
          <tr>
            <td><b><?= $p['nama_pelanggan'] ?></b></td>
            <?php mysqli_data_seek($kri,0); while($k=mysqli_fetch_assoc($kri)): ?>
              <td><?= $matrix[$p['id']][$k['id']] ?? '-' ?></td>
            <?php endwhile; ?>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>