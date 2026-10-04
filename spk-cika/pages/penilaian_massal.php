<?php
include '../config/koneksi.php';
$plg = mysqli_query($koneksi,"SELECT * FROM pelanggan ORDER BY id");
$kri = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY id");

$matrix = [];
$q = mysqli_query($koneksi,"SELECT * FROM penilaian");
while($r=mysqli_fetch_assoc($q)) $matrix[$r['pelanggan_id']][$r['kriteria_id']] = $r['nilai'];

$listK = []; mysqli_data_seek($kri,0); while($k=mysqli_fetch_assoc($kri)) $listK[] = $k;
$listP = []; mysqli_data_seek($plg,0); while($p=mysqli_fetch_assoc($plg)) $listP[] = $p;

include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Penilaian Massal</h2>
    <p class="page-sub">Input nilai semua pelanggan sekaligus</p>

    <form action="../proses/update_penilaian.php" method="POST">
      <div class="table-card">
        <table>
          <thead>
            <tr><th>Pelanggan</th>
            <?php foreach($listK as $k): ?>
              <th><?= $k['kode'] ?><br><small><?= $k['nama_kriteria'] ?></small></th>
            <?php endforeach; ?>
            </tr>
          </thead>
          <tbody>
          <?php foreach($listP as $p): ?>
            <tr>
              <td><b><?= $p['nama_pelanggan'] ?></b></td>
              <?php foreach($listK as $k): ?>
                <td><input type="number" step="0.01"
                  name="nilai[<?= $p['id'] ?>][<?= $k['id'] ?>]"
                  value="<?= $matrix[$p['id']][$k['id']] ?? '' ?>"
                  class="input-cell" required></td>
              <?php endforeach; ?>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <button type="submit" class="btn-primary" style="margin-top:15px;">💾 Simpan Semua</button>
    </form>
  </main>
</div>
<?php include '../templates/footer.php'; ?>