<?php
include '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM kategori_kirim ORDER BY id DESC");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Kategori Jasa Kirim</h2>

    <div class="form-card">
      <h3>Tambah Kategori</h3>
      <form action="../proses/simpan_kategori.php" method="POST" class="form-grid">
        <input type="text" name="nama_kategori" placeholder="Nama Kategori" required>
        <input type="number" name="estimasi_hari" placeholder="Estimasi (hari)" required>
        <input type="number" step="0.01" name="biaya_per_kg" placeholder="Biaya per Kg" required>
        <input type="text" name="keterangan" placeholder="Keterangan">
        <button class="btn-primary" type="submit">Simpan</button>
      </form>
    </div>

    <div class="cards">
      <?php while($k = mysqli_fetch_assoc($data)): ?>
      <div class="card category-card">
        <div class="cat-icon">🚚</div>
        <h3><?= $k['nama_kategori'] ?></h3>
        <p><b>Estimasi:</b> <?= $k['estimasi_hari'] ?> hari</p>
        <p><b>Biaya/kg:</b> Rp <?= number_format($k['biaya_per_kg'],0,',','.') ?></p>
        <p class="muted"><?= $k['keterangan'] ?></p>
      </div>
      <?php endwhile; ?>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>