<?php
include '../config/koneksi.php';
$id = intval($_GET['id']);
$d  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM pelanggan WHERE id = $id"));
if (!$d) { header("Location: pelanggan.php"); exit; }
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Edit Pelanggan</h2>
    <div class="form-card">
      <form action="../proses/update_pelanggan.php" method="POST" class="form-grid">
        <input type="hidden" name="id" value="<?= $d['id'] ?>">
        <input type="text" name="kode_pelanggan" value="<?= $d['kode_pelanggan'] ?>" required>
        <input type="text" name="nama_pelanggan" value="<?= $d['nama_pelanggan'] ?>" required>
        <input type="text" name="alamat" value="<?= $d['alamat'] ?>" required>
        <input type="text" name="kota" value="<?= $d['kota'] ?>" required>
        <input type="text" name="provinsi" value="<?= $d['provinsi'] ?>" required>
        <input type="text" name="no_telp" value="<?= $d['no_telp'] ?>">
        <button class="btn-primary" type="submit">Update</button>
        <a href="pelanggan.php" class="btn-secondary">Batal</a>
      </form>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>