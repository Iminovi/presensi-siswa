<?php 
// Ambil username admin dari sesi untuk ditampilkan
$admin_username = $_SESSION['admin_username'] ?? 'Admin';
$page = $_GET['page'] ?? 'dashboard'; // Ambil halaman saat ini untuk active state
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Admin Panel'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- (Konfigurasi Tailwind bisa Anda tambahkan di sini jika perlu) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-b from-blue-900 to-blue-800 shadow-xl">
        <div class="flex items-center justify-center h-16 bg-blue-950 shadow-lg">
            <a href="admin.php?page=dashboard" class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center"><i class="fas fa-user-check text-blue-900 text-lg"></i></div>
                <h2 class="text-white text-xl font-bold tracking-wide">Absensi Admin</h2>
            </a>
        </div>
        <nav class="mt-6 px-4">
            <div class="space-y-2">
                <a href="admin.php?page=dashboard" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 <?php echo ($page === 'dashboard' ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100'); ?>"><i class="fas fa-tachometer-alt mr-3 text-lg"></i><span>Dashboard</span></a>
                <a href="admin.php?page=siswa" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 <?php echo ($page === 'siswa' || $page === 'edit_siswa' ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100'); ?>"><i class="fas fa-users mr-3 text-lg"></i><span>Manajemen Siswa</span></a>
                <a href="admin.php?page=kelas_jadwal" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 <?php echo ($page === 'kelas_jadwal' ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100'); ?>"><i class="fas fa-calendar-alt mr-3 text-lg"></i><span>Kelas & Jadwal</span></a>
                <a href="admin.php?page=laporan" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 <?php echo ($page === 'laporan' ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100'); ?>"><i class="fas fa-chart-bar mr-3 text-lg"></i><span>Laporan Absensi</span></a>
                <a href="admin.php?page=qr" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all duration-200 hover:bg-blue-700 <?php echo ($page === 'qr' ? 'bg-blue-600 text-white shadow-lg' : 'text-blue-100'); ?>"><i class="fas fa-qrcode mr-3 text-lg"></i><span>Tampilkan QR</span></a>
            </div>
        </nav>
        <!-- Admin Info & Logout Section -->
        <div class="absolute bottom-0 left-0 right-0 p-4 bg-blue-950/50">
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-10 h-10 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full flex items-center justify-center text-blue-900 text-sm font-bold">
                    <?php echo strtoupper(substr($admin_username, 0, 1)); ?>
                </div>
                <div>
                    <p class="text-white text-sm font-medium"><?php echo htmlspecialchars($admin_username); ?></p>
                    <p class="text-blue-300 text-xs">Administrator</p>
                </div>
            </div>
            <button onclick="confirmLogout()" class="w-full flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors"><i class="fas fa-sign-out-alt mr-2"></i>Logout</button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="ml-64 min-h-screen">
        <!-- Top Header Bar -->
        <header class="bg-white shadow-sm border-b border-gray-200 px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900"><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Dashboard'; ?></h1>
                    <p class="text-gray-600 text-sm mt-1"><?php echo date('l, d F Y'); ?></p>
                </div>
            </div>
        </header>
        <!-- Page Content Container -->
        <div class="p-6">
            <!-- Konten dari setiap halaman (misal: admin_dashboard.php) akan dimuat di sini -->
