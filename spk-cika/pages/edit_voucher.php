<?php
include '../config/koneksi.php';
$id = intval($_GET['id']);
$d  = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM voucher WHERE id = $id"));
$plg = mysqli_query($koneksi, "SELECT * FROM pelanggan");
$kat = mysqli_query($koneksi, "SELECT * FROM kategori_kirim");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Edit Voucher</h2>
    <div class="form-card">
      <form action="../proses/update_voucher.php" method="POST" class="form-grid">
        <input type="hidden" name="id" value="<?= $d['id'] ?>">
        <input type="text" name="kode_voucher" value="<?= $d['kode_voucher'] ?>" required>
        <input type="text" name="nama_voucher" value="<?= $d['nama_voucher'] ?>" required>
        <input type="text" name="jenis_voucher" value="<?= $d['jenis_voucher'] ?>" required>
        <select name="pelanggan_id" required>
          <?php while($p=mysqli_fetch_assoc($plg)): ?>
            <option value="<?= $p['id'] ?>" <?= $p['id']==$d['pelanggan_id']?'selected':'' ?>><?= $p['nama_pelanggan'] ?></option>
          <?php endwhile; ?>
        </select>
        <select name="kategori_kirim_id" required>
          <?php while($k=mysqli_fetch_assoc($kat)): ?>
            <option value="<?= $k['id'] ?>" <?= $k['id']==$d['kategori_kirim_id']?'selected':'' ?>><?= $k['nama_kategori'] ?></option>
          <?php endwhile; ?>
        </select>
        <input type="number" name="jumlah" value="<?= $d['jumlah'] ?>" required>
        <input type="number" step="0.1" name="berat_total" value="<?= $d['berat_total'] ?>" required>
        <input type="date" name="tanggal_pesan" value="<?= $d['tanggal_pesan'] ?>" required>
        <button class="btn-primary" type="submit">Update</button>
        <a href="voucher.php" class="btn-secondary">Batal</a>
      </form>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>