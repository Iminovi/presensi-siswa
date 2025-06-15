<?php
require_once __DIR__ . '/../app/config.php';

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header('Location: login_admin.php');
    exit();
}

$page = $_GET['page'] ?? 'dashboard';
$page_title = "Admin - " . ucfirst($page);

require_once __DIR__ . '/../app/templates/header_admin.php';

echo '<div class="admin-content">';
switch ($page) {
    case 'siswa':
        include __DIR__ . '/../app/views/admin_siswa.php';
        break;
    case 'edit_siswa': // Halaman baru untuk edit
        include __DIR__ . '/../app/views/admin_edit_siswa.php';
        break;
    case 'kelas_jadwal': // Halaman baru untuk kelas & jadwal
        include __DIR__ . '/../app/views/admin_kelas_jadwal.php';
        break;
    case 'qr':
        include __DIR__ . '/../app/views/admin_qr_display.php';
        break;
    default:
        include __DIR__ . '/../app/views/admin_dashboard.php';
        break;
    case 'laporan':
        include __DIR__ . '/../app/views/admin_laporan.php';
        break;
}
echo '</div>';

require_once __DIR__ . '/../app/templates/footer_admin.php';
?>
