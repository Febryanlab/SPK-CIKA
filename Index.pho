<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — SPK Cika Mulia Multimedia</title>
<link rel="stylesheet" href="assets/css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="login-body">
  <div class="login-container">
    <div class="login-card">
      <div class="logo-circle">
        <i class="fas fa-boxes-stacked"></i>
      </div>
      <h2>PT Cika Mulia Multimedia</h2>
      <p class="subtitle">
        Sistem Pendukung Keputusan<br>
        Pengelompokan Wilayah Pengiriman Voucher
      </p>

      <?php if(isset($_GET['error'])): ?>
        <div class="alert-error">
          <i class="fas fa-circle-exclamation"></i>
          Username atau password salah!
        </div>
      <?php endif; ?>

      <form action="proses/proses_login.php" method="POST">
        <div class="form-group">
          <label><i class="fas fa-user"></i> Username</label>
          <input type="text" name="username" required placeholder="Masukkan username">
        </div>
        <div class="form-group">
          <label><i class="fas fa-lock"></i> Password</label>
          <input type="password" name="password" required placeholder="Masukkan password">
        </div>
        <button type="submit" class="btn-primary">
          <i class="fas fa-right-to-bracket"></i>
          Masuk Sistem
        </button>
      </form>
      <p class="hint">
        <i class="fas fa-circle-info"></i>
        Default: <b>admin</b> / <b>admin123</b>
      </p>
    </div>
  </div>
</body>
</html>
