<?php
// Selalu panggil config.php di awal untuk memulai sesi
require_once __DIR__ . '/../app/config.php';

// Jika siswa SUDAH login (ada sesi 'nis'), langsung arahkan ke dashboard.
// Ini mencegah mereka melihat halaman login lagi.
if (isset($_SESSION['nis'])) {
    header('Location: siswa.php');
    exit();
}

$page_title = "Login Siswa";
require_once __DIR__ . '/../app/templates/header.php';
?>

<div class="login-wrapper">
    <h1>Login Siswa</h1>
    <p>Masukkan Nomor Induk Siswa (NIS) Anda untuk melanjutkan.</p>

    <?php
    // Menampilkan pesan error jika login gagal (misal: NIS tidak ditemukan)
    // Pesan ini dikirim dari halaman siswa.php
    if (isset($_GET['error']) && $_GET['error'] === 'notfound'):
    ?>
        <p class="error-msg">NIS yang Anda masukkan tidak terdaftar. Silakan coba lagi.</p>
    <?php endif; ?>

    <!-- FORM ACTION DIPERBAIKI: Mengarah ke siswa.php, BUKAN scan.php -->
    <form action="siswa.php" method="GET">
        <div class="form-group">
            <label for="nis">Nomor Induk Siswa (NIS)</label>
            <input type="text" id="nis" name="nis" placeholder="Contoh: 12345" required autofocus>
        </div>
        <!-- Tombol diubah untuk kejelasan -->
        <button type="submit">Masuk ke Dashboard</button>
    </form>
</div>

<!-- Style untuk pesan error, bisa dipindah ke file css utama -->
<style>
.login-wrapper{ max-width:400px; margin:auto; }
.error-msg{ color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 15px; }
</style>

<?php
require_once __DIR__ . '/../app/templates/footer.php';
?>
