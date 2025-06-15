<?php
// Selalu panggil config untuk memulai sesi
require_once __DIR__ . '/../app/config.php';

// Hancurkan semua data yang tersimpan di session
session_destroy();

// Setelah logout, alihkan pengguna kembali ke halaman login siswa
header('Location: login.php');
exit(); // Pastikan tidak ada kode lain yang dieksekusi setelah redirect
?>
