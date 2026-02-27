<?php
include '../config/koneksi.php';
include 'layout/header.php';

// For UKK, we simplify: we need an id_anggota to create a transaction.
// Let's assume the user's name matches an entry in tabel_anggota, or we just use a default for this demo.
// Ideally, we'd link tabel_users with tabel_anggota.
// Let's find or create a dummy member for this user.
$nama_user = $_SESSION['nama'];
$cek_anggota = mysqli_query($koneksi, "SELECT id_anggota FROM tabel_anggota WHERE nama_anggota='$nama_user'");
if (mysqli_num_rows($cek_anggota) > 0) {
    $d_agt = mysqli_fetch_array($cek_anggota);
    $id_anggota = $d_agt['id_anggota'];
} else {
    // Create dummy if doesn't exist (for UX in UKK)
    mysqli_query($koneksi, "INSERT INTO tabel_anggota (nama_anggota, kelas, alamat, no_hp) VALUES ('$nama_user', 'Siswa', '-', '-')");
    $id_anggota = mysqli_insert_id($koneksi);
}

if (isset($_GET['pinjam_buku'])) {
    $id_buku = $_GET['pinjam_buku'];
    $tgl_pinjam = date('Y-m-d');

    // Cek stok
    $buku = mysqli_query($koneksi, "SELECT stok FROM tabel_buku WHERE id_buku='$id_buku'");
    $dbuku = mysqli_fetch_array($buku);

    if ($dbuku['stok'] > 0) {
        mysqli_query($koneksi, "INSERT INTO tabel_transaksi (id_buku, id_anggota, tanggal_pinjam, status) VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', 'Dipinjam')");
        mysqli_query($koneksi, "UPDATE tabel_buku SET stok=stok-1 WHERE id_buku='$id_buku'");
        echo "<script>alert('Buku berhasil dipinjam!'); window.location='kembali.php';</script>";
    } else {
        echo "<script>alert('Stok buku habis!'); window.location='pinjam.php';</script>";
    }
}
?>

<div class="mb-4">
    <h4>Daftar Buku Tersedia</h4>
    <p class="text-muted">Silakan pilih buku yang ingin Anda baca.</p>
</div>

<form action="" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="cari" class="form-control" placeholder="Cari judul buku atau pengarang..."
            value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
        <button class="btn btn-primary" type="submit">Cari</button>
    </div>
</form>

<div class="row g-4">
    <?php
    $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
    $query = mysqli_query($koneksi, "SELECT * FROM tabel_buku WHERE (judul_buku LIKE '%$cari%' OR pengarang LIKE '%$cari%') AND stok > 0 ORDER BY judul_buku ASC");
    if (mysqli_num_rows($query) == 0) {
        echo "<div class='col-12'><div class='alert alert-light text-center'>Buku tidak ditemukan atau stok kosong.</div></div>";
    }
    while ($d = mysqli_fetch_array($query)) {
        ?>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <span class="badge bg-light text-dark mb-2">
                        <?= $d['kode_buku'] ?>
                    </span>
                    <h5 class="card-title">
                        <?= $d['judul_buku'] ?>
                    </h5>
                    <p class="card-text mb-1"><small class="text-muted">Pengarang:
                            <?= $d['pengarang'] ?>
                        </small></p>
                    <p class="card-text mb-3"><small class="text-muted">Penerbit:
                            <?= $d['penerbit'] ?> (
                            <?= $d['tahun_terbit'] ?>)
                        </small></p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <span class="text-success fw-bold">Stok:
                            <?= $d['stok'] ?>
                        </span>
                        <a href="?pinjam_buku=<?= $d['id_buku'] ?>" class="btn btn-primary btn-sm"
                            onclick="return confirm('Pinjam buku ini?')">Pinjam Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<?php include 'layout/footer.php'; ?>