<?php
include '../config/koneksi.php';
include 'layout/header.php';

$nama_user = $_SESSION['nama'];
$cek_anggota = mysqli_query($koneksi, "SELECT id_anggota FROM tabel_anggota WHERE nama_anggota='$nama_user'");
$d_agt = mysqli_fetch_array($cek_anggota);
$id_anggota = $d_agt['id_anggota'];

if (isset($_GET['proses_kembali'])) {
    $id_transaksi = $_GET['proses_kembali'];
    $tgl_kembali = date('Y-m-d');

    $trans = mysqli_query($koneksi, "SELECT id_buku FROM tabel_transaksi WHERE id_transaksi='$id_transaksi'");
    $dtrans = mysqli_fetch_array($trans);
    $id_buku = $dtrans['id_buku'];

    mysqli_query($koneksi, "UPDATE tabel_transaksi SET tanggal_kembali='$tgl_kembali', status='Dikembalikan' WHERE id_transaksi='$id_transaksi'");
    mysqli_query($koneksi, "UPDATE tabel_buku SET stok=stok+1 WHERE id_buku='$id_buku'");
    echo "<script>alert('Buku berhasil dikembalikan!'); window.location='kembali.php';</script>";
}
?>

<div class="mb-4">
    <h4>Riwayat Peminjaman</h4>
    <p class="text-muted">Daftar buku yang Anda pinjam dan pernah dipinjam.</p>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT t.*, b.judul_buku 
                                                   FROM tabel_transaksi t 
                                                   JOIN tabel_buku b ON t.id_buku = b.id_buku 
                                                   WHERE t.id_anggota = '$id_anggota'
                                                   ORDER BY t.id_transaksi DESC");
                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='6' class='text-center'>Belum ada riwayat peminjaman.</td></tr>";
                    }
                    while ($d = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td><strong>
                                    <?= $d['judul_buku'] ?>
                                </strong></td>
                            <td>
                                <?= date('d/m/Y', strtotime($d['tanggal_pinjam'])) ?>
                            </td>
                            <td>
                                <?= $d['tanggal_kembali'] ? date('d/m/Y', strtotime($d['tanggal_kembali'])) : '-' ?>
                            </td>
                            <td>
                                <span class="badge bg-<?= $d['status'] == 'Dipinjam' ? 'warning' : 'success' ?>">
                                    <?= $d['status'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($d['status'] == 'Dipinjam'): ?>
                                    <a href="?proses_kembali=<?= $d['id_transaksi'] ?>" class="btn btn-sm btn-outline-success"
                                        onclick="return confirm('Kembalikan buku ini?')">
                                        Kembalikan
                                    </a>
                                <?php else: ?>
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>