<?php
include '../config/koneksi.php';

// Handle Peminjaman Baru
if (isset($_POST['pinjam'])) {
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl_pinjam = date('Y-m-d');

    // Cek stok
    $buku = mysqli_query($koneksi, "SELECT stok FROM tabel_buku WHERE id_buku='$id_buku'");
    $dbuku = mysqli_fetch_array($buku);

    if ($dbuku['stok'] > 0) {
        // Insert Transaksi
        mysqli_query($koneksi, "INSERT INTO tabel_transaksi (id_buku, id_anggota, tanggal_pinjam, status) VALUES ('$id_buku', '$id_anggota', '$tgl_pinjam', 'Dipinjam')");
        // Kurangi Stok
        mysqli_query($koneksi, "UPDATE tabel_buku SET stok=stok-1 WHERE id_buku='$id_buku'");
        header("location:transaksi.php?pesan=berhasil_pinjam");
    } else {
        header("location:transaksi.php?pesan=stok_habis");
    }
}

// Handle Pengembalian
if (isset($_GET['kembali'])) {
    $id_transaksi = $_GET['kembali'];
    $tgl_kembali = date('Y-m-d');

    // Ambil data buku
    $trans = mysqli_query($koneksi, "SELECT id_buku FROM tabel_transaksi WHERE id_transaksi='$id_transaksi'");
    $dtrans = mysqli_fetch_array($trans);
    $id_buku = $dtrans['id_buku'];

    // Update Status Transaksi
    mysqli_query($koneksi, "UPDATE tabel_transaksi SET tanggal_kembali='$tgl_kembali', status='Dikembalikan' WHERE id_transaksi='$id_transaksi'");
    // Tambah Stok
    mysqli_query($koneksi, "UPDATE tabel_buku SET stok=stok+1 WHERE id_buku='$id_buku'");
    header("location:transaksi.php?pesan=berhasil_kembali");
}

include 'layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Data Transaksi Peminjaman</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPinjam">
        <i class="bi bi-plus-circle me-2"></i> Peminjaman Baru
    </button>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php
        if ($_GET['pesan'] == "berhasil_pinjam")
            echo "Peminjaman berhasil dicatat.";
        elseif ($_GET['pesan'] == "berhasil_kembali")
            echo "Buku telah berhasil dikembalikan.";
        elseif ($_GET['pesan'] == "stok_habis")
            echo "Maaf, stok buku sedang habis.";
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Peminjam</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT t.*, b.judul_buku, a.nama_anggota 
                                                   FROM tabel_transaksi t 
                                                   JOIN tabel_buku b ON t.id_buku = b.id_buku 
                                                   JOIN tabel_anggota a ON t.id_anggota = a.id_anggota 
                                                   ORDER BY t.id_transaksi DESC");
                    while ($d = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td>
                                <?= $d['judul_buku'] ?>
                            </td>
                            <td>
                                <?= $d['nama_anggota'] ?>
                            </td>
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
                                    <a href="?kembali=<?= $d['id_transaksi'] ?>" class="btn btn-sm btn-success"
                                        onclick="return confirm('Proses pengembalian buku?')">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted small">Selesai</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Pinjam -->
<div class="modal fade" id="modalPinjam" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Catat Peminjaman Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Buku</label>
                        <select name="id_buku" class="form-select" required>
                            <option value="">-- Pilih Buku --</option>
                            <?php
                            $buku = mysqli_query($koneksi, "SELECT * FROM tabel_buku WHERE stok > 0");
                            while ($b = mysqli_fetch_array($buku)) {
                                echo "<option value='" . $b['id_buku'] . "'>" . $b['judul_buku'] . " (Stok: " . $b['stok'] . ")</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Anggota</label>
                        <select name="id_anggota" class="form-select" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php
                            $anggota = mysqli_query($koneksi, "SELECT * FROM tabel_anggota");
                            while ($a = mysqli_fetch_array($anggota)) {
                                echo "<option value='" . $a['id_anggota'] . "'>" . $a['nama_anggota'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="pinjam" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'layout/footer.php'; ?>