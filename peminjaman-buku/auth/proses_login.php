<?php
session_start();
include '../config/koneksi.php';

$username = mysqli_real_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']);

$login = mysqli_query($koneksi, "SELECT * FROM tabel_users WHERE username='$username' AND password='$password'");
$cek = mysqli_num_rows($login);

if ($cek > 0) {
    $data = mysqli_fetch_assoc($login);

    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['level'] = $data['level'];

    if ($data['level'] == "admin") {
        header("location:../admin/dashboard.php");
    } else if ($data['level'] == "user") {
        header("location:../user/dashboard.php");
    }
} else {
    header("location:login.php?pesan=gagal");
}
?>