<?php
include '../config/koneksi.php';
include 'layout/header.php';

// Count stats
$buku = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tabel_buku"));
$anggota = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tabel_anggota"));
$pinjam = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tabel_transaksi WHERE status='Dipinjam'"));
?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-primary text-white p-3 rounded-circle me-3">
                    <i class="bi bi-book fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Buku</h6>
                    <h3 class="mb-0">
                        <?= $buku ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-success text-white p-3 rounded-circle me-3">
                    <i class="bi bi-people fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Total Anggota</h6>
                    <h3 class="mb-0">
                        <?= $anggota ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <div class="bg-warning text-white p-3 rounded-circle me-3">
                    <i class="bi bi-arrow-repeat fs-3"></i>
                </div>
                <div>
                    <h6 class="text-muted mb-0">Buku Dipinjam</h6>
                    <h3 class="mb-0">
                        <?= $pinjam ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h4>Pelayanan Cepat</h4>
    <div class="row mt-3">
        <div class="col-md-3">
            <a href="buku.php" class="btn btn-outline-primary w-100 py-3">
                <i class="bi bi-plus-circle d-block fs-3 mb-2"></i> Tambah Buku
            </a>
        </div>
        <div class="col-md-3">
            <a href="transaksi.php" class="btn btn-outline-success w-100 py-3">
                <i class="bi bi-plus-circle d-block fs-3 mb-2"></i> Peminjaman Baru
            </a>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>