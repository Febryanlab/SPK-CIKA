<?php
include '../config/koneksi.php';
$data = mysqli_query($koneksi,"SELECT * FROM kriteria ORDER BY id");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Kriteria & Bobot TOPSIS</h2>
    <p class="page-sub">Total bobot harus = 1.000</p>
    <div class="table-card">
      <table>
        <thead><tr><th>Kode</th><th>Nama Kriteria</th><th>Bobot</th><th>Tipe</th></tr></thead>
        <tbody>
        <?php while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><b><?= $r['kode'] ?></b></td>
            <td><?= $r['nama_kriteria'] ?></td>
            <td><?= $r['bobot'] ?></td>
            <td><span class="badge <?= $r['tipe']=='benefit'?'badge-green':'badge-red' ?>"><?= $r['tipe'] ?></span></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>