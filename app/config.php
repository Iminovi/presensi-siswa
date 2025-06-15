<?php
// Pastikan sesi hanya dimulai jika belum ada yang aktif
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- PENGATURAN DATABASE ---
$db_host = 'localhost';
$db_name = 'dba';
$db_user = 'root';
$db_pass = '';
// --------------------------

date_default_timezone_set('Asia/Jakarta');

try {
    $pdo = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}

// Fungsi ini tidak berubah
function generateToken($length = 16) {
    return bin2hex(random_bytes($length));
}
?>
