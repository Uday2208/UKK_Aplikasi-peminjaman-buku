CREATE DATABASE IF NOT EXISTS db_perpustakaan;
USE db_perpustakaan;

CREATE TABLE IF NOT EXISTS tabel_users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    level ENUM('admin', 'user') NOT NULL
);

CREATE TABLE IF NOT EXISTS tabel_buku (
    id_buku INT AUTO_INCREMENT PRIMARY KEY,
    kode_buku VARCHAR(20) NOT NULL UNIQUE,
    judul_buku VARCHAR(255) NOT NULL,
    pengarang VARCHAR(100) NOT NULL,
    penerbit VARCHAR(100) NOT NULL,
    tahun_terbit YEAR NOT NULL,
    stok INT NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS tabel_anggota (
    id_anggota INT AUTO_INCREMENT PRIMARY KEY,
    nama_anggota VARCHAR(100) NOT NULL,
    kelas VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS tabel_transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    id_buku INT,
    id_anggota INT,
    tanggal_pinjam DATE NOT NULL,
    tanggal_kembali DATE DEFAULT NULL,
    status ENUM('Dipinjam', 'Dikembalikan') NOT NULL DEFAULT 'Dipinjam',
    FOREIGN KEY (id_buku) REFERENCES tabel_buku(id_buku) ON DELETE CASCADE,
    FOREIGN KEY (id_anggota) REFERENCES tabel_anggota(id_anggota) ON DELETE CASCADE
);

INSERT IGNORE INTO tabel_users (nama, username, password, level) VALUES 
('Administrator', 'admin', MD5('admin123'), 'admin'),
('Siswa Contoh', 'user', MD5('user123'), 'user');
