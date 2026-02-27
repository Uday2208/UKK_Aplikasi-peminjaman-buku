<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            margin-top: 100px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center login-container">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Login Perpustakaan</h4>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_GET['pesan'])): ?>
                            <div class="alert alert-danger text-center">
                                <?php
                                if ($_GET['pesan'] == "gagal")
                                    echo "Login gagal! Username atau password salah.";
                                elseif ($_GET['pesan'] == "logout")
                                    echo "Anda telah berhasil logout.";
                                elseif ($_GET['pesan'] == "belum_login")
                                    echo "Anda harus login untuk mengakses halaman.";
                                ?>
                            </div>
                        <?php endif; ?>
                        <form action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                                    required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>