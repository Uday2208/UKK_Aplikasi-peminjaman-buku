<?php
session_start();
if ($_SESSION['level'] != "admin") {
    header("location:../auth/login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f4f7f6;
        }

        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            color: white;
        }

        .sidebar a {
            color: #bdc3c7;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background: #34495e;
            color: white;
        }

        .active-link {
            background: #34495e;
            color: white !important;
            border-left: 4px solid #3498db;
        }

        .content {
            padding: 20px;
        }

        .navbar-custom {
            background: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 d-none d-md-block sidebar p-0">
                <div class="text-center py-4">
                    <h4>PERPUS<span class="text-primary">DIGI</span></h4>
                    <hr>
                </div>
                <a href="dashboard.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active-link' : '' ?>">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="buku.php" class="<?= basename($_SERVER['PHP_SELF']) == 'buku.php' ? 'active-link' : '' ?>">
                    <i class="bi bi-book me-2"></i> Data Buku
                </a>
                <a href="anggota.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'anggota.php' ? 'active-link' : '' ?>">
                    <i class="bi bi-people me-2"></i> Data Anggota
                </a>
                <a href="transaksi.php"
                    class="<?= basename($_SERVER['PHP_SELF']) == 'transaksi.php' ? 'active-link' : '' ?>">
                    <i class="bi bi-arrow-left-right me-2"></i> Transaksi
                </a>
                <hr>
                <a href="../auth/logout.php" class="text-danger">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </a>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 content p-0">
                <nav class="navbar navbar-expand-lg navbar-custom px-4 py-3">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">Panel Admin</span>
                        <div class="ms-auto">
                            <span class="me-3">Halo, <strong>
                                    <?= $_SESSION['nama'] ?>
                                </strong></span>
                        </div>
                    </div>
                </nav>
                <div class="p-4">