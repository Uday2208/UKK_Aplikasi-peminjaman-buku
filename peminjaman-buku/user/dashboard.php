<?php
include '../config/koneksi.php';
include 'layout/header.php';

// Count user stats (assuming user table exists, but for now just count their transactions)
$username = $_SESSION['username'];
// Since id_user is in session, we use that.
$id_user = $_SESSION['id_user'];
// Note: In a real app, we might link id_user to id_anggota. For UKK simplicity, let's assume one to one or just show global stats for now if not linked.
$pinjam_saya = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tabel_transaksi WHERE status='Dipinjam'"));
?>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="alert alert-info">
            Selamat Datang di Perpustakaan Sekolah Digital, <strong>
                <?= $_SESSION['nama'] ?>
            </strong>. Silakan cari buku yang ingin Anda pinjam.
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 border-start border-primary border-4">
            <div class="card-body">
                <h6 class="text-muted">Buku Dipinjam Saat Ini</h6>
                <h3 class="mb-0">
                    <?= $pinjam_saya ?>
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="mt-5">
    <h3>Pencarian Buku</h3>
    <div class="card shadow-sm border-0 mt-3">
        <div class="card-body">
            <form action="pinjam.php" method="GET" class="row g-3">
                <div class="col-md-10">
                    <input type="text" name="cari" class="form-control"
                        placeholder="Masukkan judul buku atau pengarang...">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Cari Buku</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>