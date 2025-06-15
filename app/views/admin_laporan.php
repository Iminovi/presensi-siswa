<?php
// FILE: app/views/admin_laporan.php
// Pastikan file ini dipanggil dari admin.php agar variabel koneksi $pdo tersedia.

// Ambil daftar kelas dari database untuk filter dropdown
try {
    $stmt_kelas = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
    $daftar_kelas = $stmt_kelas->fetchAll();
} catch (PDOException $e) {
    // Jika ada error, buat array kosong agar halaman tidak rusak
    $daftar_kelas = [];
    error_log("Gagal mengambil daftar kelas: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(30px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
    <div class="relative min-h-screen py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12 animate-fade-in">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl mb-6 shadow-xl">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Cetak Laporan Absensi</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">Pilih jenis laporan yang ingin Anda cetak. Laporan akan dibuka di tab baru.</p>
            </div>

            <!-- Form Grid -->
            <div class="form-grid grid grid-cols-1 lg:grid-cols-2 gap-8 max-w-5xl mx-auto">
                <!-- Daily Report Form -->
                <div class="form-container group animate-slide-up">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Laporan Harian</h3>
                        <form action="cetak_laporan.php" method="GET" target="_blank" class="space-y-6">
                            <input type="hidden" name="jenis" value="harian">
                            <div class="form-group">
                                <label for="tanggal" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Tanggal</label>
                                <input type="date" id="tanggal" name="tanggal" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            </div>
                            <div class="form-group">
                                <label for="kelas_harian" class="block text-sm font-semibold text-gray-700 mb-2">Filter per Kelas (Opsional)</label>
                                <select name="kelas_id" id="kelas_harian" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-emerald-500">
                                    <option value="">🎯 Semua Kelas</option>
                                    <?php foreach ($daftar_kelas as $kelas): ?>
                                        <option value="<?php echo $kelas['id']; ?>">📚 <?php echo htmlspecialchars($kelas['nama_kelas']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">Cetak Laporan Harian</button>
                        </form>
                    </div>
                </div>

                <!-- Monthly Report Form -->
                <div class="form-container group animate-slide-up" style="animation-delay: 0.2s;">
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 p-8 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Laporan Bulanan</h3>
                        <form action="cetak_laporan.php" method="GET" target="_blank" class="space-y-6">
                            <input type="hidden" name="jenis" value="bulanan">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="form-group">
                                    <label for="bulan" class="block text-sm font-semibold text-gray-700 mb-2">Bulan</label>
                                    <select name="bulan" id="bulan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                                        <?php for ($i = 1; $i <= 12; $i++): ?>
                                            <option value="<?php echo $i; ?>" <?php echo ($i == date('n') ? 'selected' : ''); ?>>
                                                <?php echo date('F', mktime(0, 0, 0, $i, 10)); ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun" class="block text-sm font-semibold text-gray-700 mb-2">Tahun</label>
                                    <input type="number" id="tahun" name="tahun" value="<?php echo date('Y'); ?>" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="kelas_bulanan" class="block text-sm font-semibold text-gray-700 mb-2">Filter per Kelas (Opsional)</label>
                                <select name="kelas_id" id="kelas_bulanan" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500">
                                    <option value="">🎯 Semua Kelas</option>
                                    <?php foreach ($daftar_kelas as $kelas): ?>
                                        <option value="<?php echo $kelas['id']; ?>">📚 <?php echo htmlspecialchars($kelas['nama_kelas']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white font-bold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all">Cetak Laporan Bulanan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Set today's date as default for date input
        document.getElementById('tanggal').valueAsDate = new Date();
    </script>
</body>
</html>
