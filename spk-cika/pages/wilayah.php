<?php
include '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM wilayah ORDER BY id DESC");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title"><i class="fas fa-map-location-dot"></i> Data Wilayah</h2>
    <p class="page-sub">Kelola daftar wilayah pengiriman beserta zona</p>

    <div class="form-card">
      <h3><i class="fas fa-plus-circle"></i> Tambah Wilayah</h3>
      <form action="../proses/simpan_wilayah.php" method="POST" class="form-grid">
        <input type="text" name="kode_wilayah" placeholder="Kode Wilayah (WIL001)" required>
        <input type="text" name="nama_wilayah" placeholder="Nama Wilayah" required>
        <input type="text" name="kota" placeholder="Kota" required>
        <input type="text" name="provinsi" placeholder="Provinsi" required>
        <select name="zona" required>
          <option value="">-- Pilih Zona --</option>
          <option value="Zona A (Prioritas)">Zona A (Prioritas)</option>
          <option value="Zona B (Menengah)">Zona B (Menengah)</option>
          <option value="Zona C (Reguler)">Zona C (Reguler)</option>
        </select>
        <input type="number" name="estimasi_hari" placeholder="Estimasi (hari)" required>
        <input type="text" name="keterangan" placeholder="Keterangan">
        <button class="btn-primary" type="submit">
          <i class="fas fa-save"></i> Simpan Wilayah
        </button>
      </form>
    </div>

    <div class="table-card">
      <h3><i class="fas fa-table"></i> Daftar Wilayah</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama Wilayah</th>
            <th>Kota</th>
            <th>Provinsi</th>
            <th>Zona</th>
            <th>Estimasi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
        <?php $n=1; while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $n++ ?></td>
            <td><b><?= $r['kode_wilayah'] ?></b></td>
            <td><?= $r['nama_wilayah'] ?></td>
            <td><?= $r['kota'] ?></td>
            <td><?= $r['provinsi'] ?></td>
            <td>
              <?php
              $cls = strpos($r['zona'],'A')!==false ? 'badge-green' :
                     (strpos($r['zona'],'B')!==false ? 'badge-yellow' : 'badge-blue');
              ?>
              <span class="badge <?= $cls ?>"><?= $r['zona'] ?></span>
            </td>
            <td><?= $r['estimasi_hari'] ?> hari</td>
            <td>
              <a href="edit_wilayah.php?id=<?= $r['id'] ?>" class="btn-edit">
                <i class="fas fa-pen"></i> Edit
              </a>
              <a href="../proses/hapus.php?t=wilayah&id=<?= $r['id'] ?>&r=wilayah.php"
                 class="btn-del" onclick="return confirm('Hapus wilayah ini?')">
                <i class="fas fa-trash"></i> Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>