<?php
include '../config/koneksi.php';
$data = mysqli_query($koneksi, "SELECT * FROM pelanggan ORDER BY id DESC");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Data Pelanggan</h2>

    <div class="form-card">
      <h3>Tambah Pelanggan</h3>
      <form action="../proses/simpan_pelanggan.php" method="POST" class="form-grid">
        <input type="text" name="kode_pelanggan" placeholder="Kode Pelanggan" required>
        <input type="text" name="nama_pelanggan" placeholder="Nama Pelanggan" required>
        <input type="text" name="alamat" placeholder="Alamat" required>
        <input type="text" name="kota" placeholder="Kota" required>
        <input type="text" name="provinsi" placeholder="Provinsi" required>
        <input type="text" name="no_telp" placeholder="No Telepon">
        <button class="btn-primary" type="submit">Simpan</button>
      </form>
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr><th>No</th><th>Kode</th><th>Nama</th><th>Kota</th><th>Telp</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $n=1; while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $n++ ?></td>
            <td><?= $r['kode_pelanggan'] ?></td>
            <td><?= $r['nama_pelanggan'] ?></td>
            <td><?= $r['kota'] ?></td>
            <td><?= $r['no_telp'] ?></td>
            <td>
              <a href="edit_pelanggan.php?id=<?= $r['id'] ?>" class="btn-edit">Edit</a>
              <a href="../proses/hapus.php?t=pelanggan&id=<?= $r['id'] ?>&r=pelanggan.php" class="btn-del" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>