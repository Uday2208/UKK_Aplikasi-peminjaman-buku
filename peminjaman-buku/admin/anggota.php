<?php
include '../config/koneksi.php';

// Handle Add/Edit/Delete
if (isset($_POST['simpan'])) {
    $id_anggota = $_POST['id_anggota'];
    $nama_anggota = $_POST['nama_anggota'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];

    if ($id_anggota == "") {
        // Insert
        mysqli_query($koneksi, "INSERT INTO tabel_anggota VALUES(NULL, '$nama_anggota', '$kelas', '$alamat', '$no_hp')");
    } else {
        // Update
        mysqli_query($koneksi, "UPDATE tabel_anggota SET nama_anggota='$nama_anggota', kelas='$kelas', alamat='$alamat', no_hp='$no_hp' WHERE id_anggota='$id_anggota'");
    }
    header("location:anggota.php");
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tabel_anggota WHERE id_anggota='$id'");
    header("location:anggota.php");
}

include 'layout/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Kelola Data Anggota</h4>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAnggota">
        <i class="bi bi-person-plus me-2"></i> Tambah Anggota
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <form action="" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="cari" class="form-control" placeholder="Cari nama anggota..."
                    value="<?= isset($_GET['cari']) ? $_GET['cari'] : '' ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Anggota</th>
                        <th>Kelas</th>
                        <th>Alamat</th>
                        <th>No. HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $cari = isset($_GET['cari']) ? $_GET['cari'] : '';
                    $query = mysqli_query($koneksi, "SELECT * FROM tabel_anggota WHERE nama_anggota LIKE '%$cari%' ORDER BY id_anggota DESC");
                    while ($d = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td>
                                <?= $no++ ?>
                            </td>
                            <td><strong>
                                    <?= $d['nama_anggota'] ?>
                                </strong></td>
                            <td>
                                <?= $d['kelas'] ?>
                            </td>
                            <td>
                                <?= $d['alamat'] ?>
                            </td>
                            <td>
                                <?= $d['no_hp'] ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-warning mb-1"
                                    onclick="editAnggota('<?= $d['id_anggota'] ?>', '<?= addslashes($d['nama_anggota']) ?>', '<?= addslashes($d['kelas']) ?>', '<?= addslashes($d['alamat']) ?>', '<?= $d['no_hp'] ?>')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <a href="?hapus=<?= $d['id_anggota'] ?>" class="btn btn-sm btn-danger mb-1"
                                    onclick="return confirm('Hapus anggota ini?')">
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
<div class="modal fade" id="modalAnggota" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Data Anggota</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_anggota" id="id_anggota">
                    <div class="mb-3">
                        <label class="form-label">Nama Anggota</label>
                        <input type="text" name="nama_anggota" id="nama_anggota" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" id="kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control" required>
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
    function editAnggota(id, nama, kelas, alamat, no_hp) {
        document.getElementById('modalTitle').innerText = 'Edit Data Anggota';
        document.getElementById('id_anggota').value = id;
        document.getElementById('nama_anggota').value = nama;
        document.getElementById('kelas').value = kelas;
        document.getElementById('alamat').value = alamat;
        document.getElementById('no_hp').value = no_hp;

        var myModal = new bootstrap.Modal(document.getElementById('modalAnggota'));
        myModal.show();
    }

    document.getElementById('modalAnggota').addEventListener('hidden.bs.modal', function () {
        document.getElementById('modalTitle').innerText = 'Tambah Data Anggota';
        document.getElementById('id_anggota').value = '';
        document.querySelector('form').reset();
    });
</script>

<?php include 'layout/footer.php'; ?>