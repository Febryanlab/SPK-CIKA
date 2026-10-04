<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_user'])) {
    $dir = (strpos($_SERVER['PHP_SELF'], '/pages/') !== false ||
            strpos($_SERVER['PHP_SELF'], '/proses/') !== false) ? '../' : '';
    header("Location: {$dir}index.php"); exit;
}
$current = basename($_SERVER['PHP_SELF']);

// Deteksi base path
$inPages = strpos($_SERVER['PHP_SELF'], '/pages/') !== false;
$base = $inPages ? '../' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SPK Cika — Pengelompokan Wilayah Kirim</title>

<!-- CSS Utama -->
<link rel="stylesheet" href="<?= $base ?>assets/css/style.css">

<!-- Font Awesome (Icon Profesional) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Google Font (Poppins — lebih modern) -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<!-- PWA -->
<link rel="manifest" href="<?= $base ?>assets/manifest.json">
<meta name="theme-color" content="#1e40af">
</head>
<body>
<header class="topbar">
  <button class="hamburger" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </button>
  <div class="brand">
    <span class="brand-logo"><i class="fas fa-boxes-stacked"></i></span>
    <div>
      <h1>SPK Cika Mulia</h1>
      <small>Sistem Pendukung Keputusan Pengiriman Voucher</small>
    </div>
  </div>
  <div class="user-info">
    <span><i class="fas fa-user-circle"></i> <?= $_SESSION['nama'] ?></span>
    <a href="<?= $base ?>logout.php" class="btn-logout">
      <i class="fas fa-sign-out-alt"></i> Logout
    </a>
  </div>
</header>