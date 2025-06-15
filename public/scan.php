<?php
require_once __DIR__ . '/../app/config.php';

// Ambil NIS dari session yang sudah disimpan saat login
$nis = $_SESSION['nis'] ?? '';
// Ambil tipe absen ('masuk' atau 'pulang') dari URL
$type = $_GET['type'] ?? 'masuk';

// Jika tidak ada sesi NIS, paksa kembali ke halaman login
if (empty($nis)) {
    header('Location;'' login.php');
    exit();
}

$page_title = "Scan QR Absen " . ucfirst($type);
require_once __DIR__ . '/../app/templates/header.php';
?>
<div class="scan-wrapper">
    <h1>Scan QR untuk Absen <?php echo ucfirst($type); ?></h1>
    <p>Arahkan kamera Anda ke QR Code yang ditampilkan.</p>
    <a href="siswa.php" class="back-button">Kembali ke Dashboard</a>
    
    <!-- Elemen ini adalah tempat kamera akan muncul -->
    <div id="qr-reader"></div>
    
    <!-- Elemen ini untuk menampilkan pesan hasil scan -->
    <div id="scan-result" class="result"></div>
</div>

<!-- Mengoper variabel PHP ke JavaScript -->
<script>
    const userNis = "<?php echo htmlspecialchars($nis); ?>";
    const scanType = "<?php echo htmlspecialchars($type); ?>";
</script>

<!-- Memuat library dan skrip yang dibutuhkan -->
<script src="assets/lib/html5-qrcode.min.js"></script>
<script src="assets/js/scanner.js"></script>
<?php require_once __DIR__ . '/../app/templates/footer.php'; ?>
