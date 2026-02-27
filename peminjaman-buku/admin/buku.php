<?php
include '../config/koneksi.php';

// Handle Add/Edit/Delete
if (isset($_POST['simpan'])) {
    $id_buku = $_POST['id_buku'];
    $kode = $_POST['kode_buku'];
    $judul = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun_terbit'];
    $stok = $_POST['stok'];

    if ($id_buku == "") {
        // Insert
        mysqli_query($koneksi, "INSERT INTO tabel_buku VALUES(NULL, '$kode', '$judul', '$pengarang', '$penerbit', '$tahun', '$stok')");
    } else {
        // Update
        mysqli_query($koneksi, "UPDATE tabel_buku SET kode_buku='$kode', judul_buku='$judul', pengarang='$pengarang', penerbit='$penerbit', tahun_terbit='$tahun', stok='$stok' WHERE id_buku='$id_buku'");
    }
    header("location:buku.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tabel_buku WHERE id_buku='$id'");
    header("location:buku.php");
}

include 'layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Kelola Data Buku</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuku">
        <i class="bi bi-plus-circle me-2"></i> Tambah Buku
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari judul atau pengarang..."
                    value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Judul Buku</th>
                        <th>Pengarang</th>
                        <th>Penerbit</th>
                        <th>Tahun</th>
                        <th>Stok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
                    $query = mysqli_query($koneksi, "SELECT * FROM tabel_buku WHERE judul_buku LIKE '%$cari%' OR pengarang LIKE '%$cari%' ORDER BY id_buku DESC");
                    while ($d = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td><span class="badge bg-secondary">
                                    <?= $d['kode_buku'] ?>
                                </span></td>
                            <td><strong>
                                    <?= $d['judul_buku'] ?>
                                </strong></td>
                            <td>
                                <?= $d['pengarang'] ?>
                            </td>
                            <td>
                                <?= $d['penerbit'] ?>
                            </td>
                            <td>
                                <?= $d['tahun_terbit'] ?>
                            </td>
                            <td>
                                <?= $d['stok'] ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-1"
                                    onclick="editBuku('<?= $d['id_buku'] ?>', '<?= $d['kode_buku'] ?>', '<?= addslashes($d['judul_buku']) ?>', '<?= addslashes($d['pengarang']) ?>', '<?= addslashes($d['penerbit']) ?>', '<?= $d['tahun_terbit'] ?>', '<?= $d['stok'] ?>')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="?hapus=<?= $d['id_buku'] ?>" class="btn btn-sm btn-danger mb-1"
                                    onclick="return confirm('Hapus buku ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalBuku" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Data Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_buku" id="id_buku">
                    <div class="mb-3">
                        <label class="form-label">Kode Buku</label>
                        <input type="text" name="kode_buku" id="kode_buku" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul_buku" id="judul_buku" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pengarang</label>
                            <input type="text" name="pengarang" id="pengarang" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" id="penerbit" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" id="stok" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editBuku(id, kode, judul, pengarang, penerbit, tahun, stok) {
        document.getElementById('modalTitle').innerText = 'Edit Data Buku';
        document.getElementById('id_buku').value = id;
        document.getElementById('kode_buku').value = kode;
        document.getElementById('judul_buku').value = judul;
        document.getElementById('pengarang').value = pengarang;
        document.getElementById('penerbit').value = penerbit;
        document.getElementById('tahun_terbit').value = tahun;
        document.getElementById('stok').value = stok;

        var myModal = new bootstrap.Modal(document.getElementById('modalBuku'));
        myModal.show();
    }

    // Reset modal when closed
    document.getElementById('modalBuku').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Tambah Data Buku';
        document.getElementById('id_buku').value = '';
        document.querySelector('form').reset();
    });
</script>

<?php include 'layout/footer.php'; ?>