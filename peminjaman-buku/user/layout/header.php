<?php
session_start();
if ($_SESSION['level'] != "user") {
    header("location:../auth/login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f7f6;
        }

        .navbar-user {
            background: #2c3e50;
        }

        .content {
            padding: 40px 0;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-user px-4 py-3">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">PERPUS<span class="text-primary">DIGI</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>"
                            href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'pinjam.php' ? 'active' : '' ?>"
                            href="pinjam.php">Pinjam Buku</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kembali.php' ? 'active' : '' ?>"
                            href="kembali.php">Riwayat</a>
                    </li>
                </ul>
                <div class="navbar-nav">
                    <span class="nav-item nav-link text-light me-3">Siswa: <strong>
                            <?= $_SESSION['nama'] ?>
                        </strong></span>
                    <a href="../auth/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
                </div>
            </div>
        </div>
    </nav>
    <div class="container content">