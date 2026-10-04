<?php
include '../config/koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']);

$q = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
if (mysqli_num_rows($q) > 0) {
    $user = mysqli_fetch_assoc($q);
    $_SESSION['id_user']  = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['nama']     = $user['nama_lengkap'];
    $_SESSION['role']     = $user['role'];
    header("Location: ../dashboard.php");
} else {
    header("Location: ../index.php?error=1");
}
?>