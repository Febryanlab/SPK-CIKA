<?php
include '../config/koneksi.php';
$plg = mysqli_query($koneksi,"SELECT * FROM pelanggan");
$kat = mysqli_query($koneksi,"SELECT * FROM kategori_kirim");
$data = mysqli_query($koneksi,"
  SELECT v.*, p.nama_pelanggan, k.nama_kategori
  FROM voucher v
  LEFT JOIN pelanggan p ON v.pelanggan_id = p.id
  LEFT JOIN kategori_kirim k ON v.kategori_kirim_id = k.id
  ORDER BY v.id DESC");
include '../templates/header.php';
?>
<div class="layout">
  <?php include '../templates/sidebar.php'; ?>
  <main class="content">
    <h2 class="page-title">Data Voucher Fisik</h2>

    <div class="form-card">
      <h3>Tambah Voucher</h3>
      <form action="../proses/simpan_voucher.php" method="POST" class="form-grid">
        <input type="text" name="kode_voucher" placeholder="Kode Voucher" required>
        <input type="text" name="nama_voucher" placeholder="Nama Voucher" required>
        <input type="text" name="jenis_voucher" placeholder="Jenis Voucher" required>
        <select name="pelanggan_id" required>
          <option value="">-- Pilih Pelanggan --</option>
          <?php while($p=mysqli_fetch_assoc($plg)): ?>
            <option value="<?= $p['id'] ?>"><?= $p['nama_pelanggan'] ?></option>
          <?php endwhile; ?>
        </select>
        <select name="kategori_kirim_id" required>
          <option value="">-- Kategori Kirim --</option>
          <?php while($k=mysqli_fetch_assoc($kat)): ?>
            <option value="<?= $k['id'] ?>"><?= $k['nama_kategori'] ?></option>
          <?php endwhile; ?>
        </select>
        <input type="number" name="jumlah" placeholder="Jumlah" required>
        <input type="number" step="0.1" name="berat_total" placeholder="Berat Total (kg)" required>
        <input type="date" name="tanggal_pesan" required>
        <button class="btn-primary" type="submit">Simpan</button>
      </form>
    </div>

    <div class="table-card">
      <table>
        <thead>
          <tr><th>No</th><th>Kode</th><th>Nama</th><th>Jenis</th><th>Pelanggan</th><th>Kategori</th><th>Jumlah</th><th>Aksi</th></tr>
        </thead>
        <tbody>
        <?php $n=1; while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $n++ ?></td>
            <td><?= $r['kode_voucher'] ?></td>
            <td><?= $r['nama_voucher'] ?></td>
            <td><span class="badge"><?= $r['jenis_voucher'] ?></span></td>
            <td><?= $r['nama_pelanggan'] ?></td>
            <td><?= $r['nama_kategori'] ?></td>
            <td><?= $r['jumlah'] ?></td>
            <td>
              <a href="edit_voucher.php?id=<?= $r['id'] ?>" class="btn-edit">Edit</a>
              <a href="../proses/hapus.php?t=voucher&id=<?= $r['id'] ?>&r=voucher.php" class="btn-del" onclick="return confirm('Hapus?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>
</div>
<?php include '../templates/footer.php'; ?>