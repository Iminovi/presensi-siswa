<?php
// Ambil username admin dari sesi untuk ditampilkan
$admin_username = $_SESSION['admin_username'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Admin Panel'; ?></title>
    <link rel="stylesheet" href="assets/css/admin_style.css">
</head>
<body>
<div class="sidebar">
    <h2>Absensi Admin</h2>
    <nav>
        <a href="admin.php?page=dashboard" class="<?php echo ($page === 'dashboard' ? 'active' : ''); ?>">Dashboard</a>
        <a href="admin.php?page=siswa" class="<?php echo ($page === 'siswa' ? 'active' : ''); ?>">Manajemen Siswa</a>
        <a href="admin.php?page=pengaturan" class="<?php echo ($page === 'pengaturan' ? 'active' : ''); ?>">Pengaturan Jam</a>
        <a href="admin.php?page=qr" class="<?php echo ($page === 'qr' ? 'active' : ''); ?>">Tampilkan QR</a>
    </nav>
    <div class="logout-section">
        <span class="admin-name">Halo, <?php echo htmlspecialchars($admin_username); ?></span>
        <a href="logout_admin.php" class="logout-btn">Logout</a>
    </div>
</div>
<div class="main-content">
