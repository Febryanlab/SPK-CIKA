<?php
include '../config/koneksi.php';
$id = intval($_GET['id'] ?? 0);
$d  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM wilayah WHERE id = $id"));
if (!$d) { header("Location: wilayah.php"); exit; }
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title"><i class="fas fa-pen"></i> Edit Wilayah</h2>

    <div class="form-card">
      <form action="../proses/update_wilayah.php" method="POST" class="form-grid">
        <input type="hidden" name="id" value="<?= $d['id'] ?>">
        <input type="text" name="kode_wilayah" value="<?= $d['kode_wilayah'] ?>" required>
        <input type="text" name="nama_wilayah" value="<?= $d['nama_wilayah'] ?>" required>
        <input type="text" name="kota" value="<?= $d['kota'] ?>" required>
        <input type="text" name="provinsi" value="<?= $d['provinsi'] ?>" required>
        <select name="zona" required>
          <option value="Zona A (Prioritas)" <?= $d['zona']=='Zona A (Prioritas)'?'selected':'' ?>>Zona A (Prioritas)</option>
          <option value="Zona B (Menengah)" <?= $d['zona']=='Zona B (Menengah)'?'selected':'' ?>>Zona B (Menengah)</option>
          <option value="Zona C (Reguler)" <?= $d['zona']=='Zona C (Reguler)'?'selected':'' ?>>Zona C (Reguler)</option>
        </select>
        <input type="number" name="estimasi_hari" value="<?= $d['estimasi_hari'] ?>" required>
        <input type="text" name="keterangan" value="<?= $d['keterangan'] ?>">
        <button class="btn-primary" type="submit">
          <i class="fas fa-save"></i> Update Wilayah
        </button>
        <a href="wilayah.php" class="btn-secondary">
          <i class="fas fa-xmark"></i> Batal
        </a>
      </form>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>