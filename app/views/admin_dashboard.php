<?php
// Ambil statistik dari database
$stmtSiswa = $pdo->query("SELECT COUNT(*) FROM siswa");
$totalSiswa = $stmtSiswa->fetchColumn();
$stmtHadir = $pdo->query("SELECT COUNT(DISTINCT siswa_id) FROM absensi WHERE tanggal = CURDATE()");
$totalHadir = $stmtHadir->fetchColumn();
$stmtTerlambat = $pdo->query("SELECT COUNT(DISTINCT siswa_id) FROM absensi WHERE tanggal = CURDATE() AND status = 'Terlambat'");
$totalTerlambat = $stmtTerlambat->fetchColumn();
$totalTidakHadir = $totalSiswa - $totalHadir;
?>

<!-- Dashboard Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
            <p class="text-gray-600">Selamat datang di sistem absensi siswa</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-500">Terakhir diupdate</p>
            <p class="text-lg font-semibold text-gray-900"><?php echo date('H:i:s'); ?></p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Siswa Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Siswa</p>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($totalSiswa); ?></p>
                <p class="text-blue-100 text-xs mt-1">Terdaftar dalam sistem</p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Hadir Hari Ini Card -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Hadir Hari Ini</p>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($totalHadir); ?></p>
                <p class="text-green-100 text-xs mt-1">
                    <?php echo $totalSiswa > 0 ? round(($totalHadir / $totalSiswa) * 100, 1) : 0; ?>% dari total siswa
                </p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-check-circle text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Terlambat Hari Ini Card -->
    <div class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-yellow-100 text-sm font-medium">Terlambat Hari Ini</p>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($totalTerlambat); ?></p>
                <p class="text-yellow-100 text-xs mt-1">
                    <?php echo $totalHadir > 0 ? round(($totalTerlambat / $totalHadir) * 100, 1) : 0; ?>% dari yang hadir
                </p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-clock text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Tidak Hadir Card -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white transform hover:scale-105 transition-transform duration-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-medium">Tidak Hadir</p>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($totalTidakHadir); ?></p>
                <p class="text-red-100 text-xs mt-1">
                    <?php echo $totalSiswa > 0 ? round(($totalTidakHadir / $totalSiswa) * 100, 1) : 0; ?>% dari total siswa
                </p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-times-circle text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500">
        <div class="flex items-center">
            <div class="bg-blue-100 rounded-full p-3 mr-4">
                <i class="fas fa-qrcode text-blue-600 text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">QR Code Absensi</h3>
                <p class="text-gray-600 text-sm">Tampilkan QR untuk absensi siswa</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="admin.php?page=qr" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200">
                <i class="fas fa-external-link-alt mr-2"></i>
                Buka QR Code
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-green-500">
        <div class="flex items-center">
            <div class="bg-green-100 rounded-full p-3 mr-4">
                <i class="fas fa-chart-line text-green-600 text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Laporan Absensi</h3>
                <p class="text-gray-600 text-sm">Lihat laporan dan statistik lengkap</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="admin.php?page=laporan" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-chart-bar mr-2"></i>
                Lihat Laporan
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500">
        <div class="flex items-center">
            <div class="bg-purple-100 rounded-full p-3 mr-4">
                <i class="fas fa-users-cog text-purple-600 text-xl"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">Manajemen Siswa</h3>
                <p class="text-gray-600 text-sm">Kelola data siswa dan kelas</p>
            </div>
        </div>
        <div class="mt-4">
            <a href="admin.php?page=siswa" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                <i class="fas fa-cog mr-2"></i>
                Kelola Siswa
            </a>
        </div>
    </div>
</div>

<!-- Absensi Hari Ini -->
<div class="bg-white rounded-xl shadow-lg">
    <div class="px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Absensi Hari Ini</h2>
                <p class="text-gray-600 text-sm"><?php echo date('l, d F Y'); ?></p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="refreshTable()" class="inline-flex items-center px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Auto-refresh:</span>
                    <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php
                // Query ini sudah benar, mengambil nama_kelas dari tabel kelas
                $query = "
                    SELECT s.nis, s.nama, k.nama_kelas, a.waktu_hadir, a.waktu_pulang, a.status 
                    FROM absensi a 
                    JOIN siswa s ON a.siswa_id = s.id
                    LEFT JOIN kelas k ON s.kelas_id = k.id
                    WHERE a.tanggal = CURDATE() 
                    ORDER BY a.waktu_hadir DESC";
                $stmt = $pdo->query($query);
                $absensi_hari_ini = $stmt->fetchAll();

                if (count($absensi_hari_ini) > 0) {
                    foreach ($absensi_hari_ini as $index => $row) {
                        $row_class = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                        echo "<tr class='{$row_class} hover:bg-blue-50 transition-colors duration-150'>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        echo "<div class='text-sm font-medium text-gray-900'>" . htmlspecialchars($row['nis']) . "</div>";
                        echo "</td>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        echo "<div class='flex items-center'>";
                        echo "<div class='w-8 h-8 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3'>";
                        echo strtoupper(substr($row['nama'], 0, 1));
                        echo "</div>";
                        echo "<div class='text-sm font-medium text-gray-900'>" . htmlspecialchars($row['nama']) . "</div>";
                        echo "</div>";
                        echo "</td>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        echo "<div class='text-sm text-gray-900 font-medium'>" . htmlspecialchars($row['nama_kelas'] ?? 'Belum ada kelas') . "</div>";
                        echo "</td>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        if ($row['waktu_hadir']) {
                            echo "<div class='flex items-center'>";
                            echo "<i class='fas fa-clock text-green-500 mr-2'></i>";
                            echo "<span class='text-sm text-gray-900 font-mono'>" . date('H:i:s', strtotime($row['waktu_hadir'])) . "</span>";
                            echo "</div>";
                        } else {
                            echo "<span class='text-gray-400'>-</span>";
                        }
                        echo "</td>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        if ($row['waktu_pulang']) {
                            echo "<div class='flex items-center'>";
                            echo "<i class='fas fa-clock text-blue-500 mr-2'></i>";
                            echo "<span class='text-sm text-gray-900 font-mono'>" . date('H:i:s', strtotime($row['waktu_pulang'])) . "</span>";
                            echo "</div>";
                        } else {
                            echo "<span class='text-gray-400'>-</span>";
                        }
                        echo "</td>";
                        
                        echo "<td class='px-6 py-4 whitespace-nowrap'>";
                        $status = $row['status'];
                        $status_config = [
                            'Hadir' => ['bg-green-100', 'text-green-800', 'fas fa-check-circle', 'border-green-200'],
                            'Terlambat' => ['bg-yellow-100', 'text-yellow-800', 'fas fa-clock', 'border-yellow-200'],
                            'Sakit' => ['bg-blue-100', 'text-blue-800', 'fas fa-thermometer-half', 'border-blue-200'],
                            'Izin' => ['bg-purple-100', 'text-purple-800', 'fas fa-hand-paper', 'border-purple-200'],
                            'Alpha' => ['bg-red-100', 'text-red-800', 'fas fa-times-circle', 'border-red-200']
                        ];
                        
                        $config = $status_config[$status] ?? ['bg-gray-100', 'text-gray-800', 'fas fa-question', 'border-gray-200'];
                        
                        echo "<span class='inline-flex items-center px-3 py-1 rounded-full text-xs font-medium border {$config[0]} {$config[1]} {$config[3]}'>";
                        echo "<i class='{$config[2]} mr-1'></i>";
                        echo htmlspecialchars($status);
                        echo "</span>";
                        echo "</td>";
                        
                        echo "</tr>";
                    }
                } else {
                    echo "<tr>";
                    echo "<td colspan='6' class='px-6 py-12 text-center'>";
                    echo "<div class='flex flex-col items-center'>";
                    echo "<i class='fas fa-calendar-times text-4xl text-gray-300 mb-4'></i>";
                    echo "<h3 class='text-lg font-medium text-gray-900 mb-2'>Belum Ada Data Absensi</h3>";
                    echo "<p class='text-gray-500'>Belum ada siswa yang melakukan absensi untuk hari ini.</p>";
                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <?php if (count($absensi_hari_ini) > 0): ?>
    <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-700">
                Menampilkan <span class="font-medium"><?php echo count($absensi_hari_ini); ?></span> dari 
                <span class="font-medium"><?php echo $totalSiswa; ?></span> siswa
            </p>
            <div class="flex items-center space-x-2">
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 border rounded">
                    <i class="fas fa-download mr-1"></i>
                    Export Excel
                </button>
                <button class="px-3 py-1 text-sm text-gray-500 hover:text-gray-700 border rounded">
                    <i class="fas fa-print mr-1"></i>
                    Print
                </button>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function refreshTable() {
    location.reload();
}

// Auto-refresh setiap 30 detik
setInterval(function() {
    // Bisa ditambahkan AJAX refresh untuk table saja
    console.log('Auto-refreshing data...');
}, 30000);

// Real-time clock update
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.querySelector('.clock')?.textContent = timeString;
}

setInterval(updateClock, 1000);
</script>