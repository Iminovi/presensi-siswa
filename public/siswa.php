<?php
require_once __DIR__ . '/../app/config.php';

// Langkah 1: Ambil NIS. Prioritaskan dari URL (saat login baru),
// jika tidak ada, ambil dari sesi (jika sudah login sebelumnya).
$nis = $_GET['nis'] ?? ($_SESSION['nis'] ?? '');

// Jika tidak ada NIS sama sekali, paksa kembali ke halaman login.
if (empty($nis)) {
    header('Location: login.php');
    exit();
}

// Langkah 2: Verifikasi NIS ke database.
try {
    $stmt = $pdo->prepare("SELECT siswa.*, kelas.nama_kelas FROM siswa LEFT JOIN kelas ON siswa.kelas_id = kelas.id WHERE nis = ?");
    $stmt->execute([$nis]);
    $siswa = $stmt->fetch();
    
    // Jika NIS TIDAK DITEMUKAN di database:
    if (!$siswa) {
        // Hapus sesi yang mungkin salah
        unset($_SESSION['nis']);
        // Arahkan kembali ke login dengan pesan error
        header('Location: login.php?error=notfound');
        exit();
    }
    
    // Jika DITEMUKAN: Simpan NIS ke sesi. Ini adalah "kunci" login siswa.
    $_SESSION['nis'] = $siswa['nis'];

} catch (PDOException $e) {
    die("Error: Gagal memvalidasi data siswa. " . $e->getMessage());
}

// ---- Mulai Tampilan Halaman Dashboard ----
$page_title = "Dashboard Siswa";
require_once __DIR__ . '/../app/templates/header.php';
?>

<div class="siswa-dashboard">
    <div class="profile-card">
        <h2>Selamat Datang, <?php echo htmlspecialchars($siswa['nama']); ?>!</h2>
        <p>NIS: <?php echo htmlspecialchars($siswa['nis']); ?> | Kelas: <?php echo htmlspecialchars($siswa['nama_kelas'] ?? 'Belum ada kelas'); ?></p>
        <a href="logout_siswa.php" class="btn-logout">Logout</a>
    </div>

    <div class="action-buttons">
        <a href="scan.php?type=masuk" class="btn btn-masuk">Absen Masuk</a>
        <a href="scan.php?type=pulang" class="btn btn-pulang">Absen Pulang</a>
    </div>

    <!-- Sisa kode untuk menampilkan riwayat absensi -->
    <!-- ... -->
</div>

<?php require_once __DIR__ . '/../app/templates/footer.php'; ?>
