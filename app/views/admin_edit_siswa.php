<?php
// Ambil ID siswa dari URL
$siswa_id = $_GET['id'] ?? 0;

// Ambil data siswa yang akan diedit
$stmt_siswa = $pdo->prepare("SELECT * FROM siswa WHERE id = ?");
$stmt_siswa->execute([$siswa_id]);
$siswa = $stmt_siswa->fetch();

if (!$siswa) {
    echo '<div class="bg-red-50 border border-red-200 rounded-lg p-6 m-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Siswa tidak ditemukan</h3>
                    <p class="mt-1 text-sm text-red-700">Data siswa yang Anda cari tidak tersedia dalam sistem.</p>
                </div>
            </div>
          </div>';
    exit();
}

// Ambil daftar kelas untuk dropdown
$stmt_kelas = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
$daftar_kelas = $stmt_kelas->fetchAll();
?>

<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="admin.php?page=siswa" class="hover:text-gray-700 transition-colors">Data Siswa</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                <span class="text-gray-900 font-medium">Edit Siswa</span>
            </nav>
            
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Edit Data Siswa</h1>
                    <p class="text-gray-600 mt-1">Perbarui informasi data siswa</p>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white shadow-lg rounded-xl border border-gray-200 overflow-hidden">
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-blue-600 font-semibold text-sm"><?php echo strtoupper(substr($siswa['nama'], 0, 2)); ?></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($siswa['nama']); ?></h3>
                        <p class="text-sm text-gray-600">NIS: <?php echo htmlspecialchars($siswa['nis']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <form action="../app/proses/proses_admin.php" method="POST" class="p-6 space-y-6">
                <input type="hidden" name="action" value="edit_siswa">
                <input type="hidden" name="id" value="<?php echo $siswa['id']; ?>">

                <!-- NIS Field -->
                <div class="space-y-2">
                    <label for="nis" class="block text-sm font-semibold text-gray-700">
                        Nomor Induk Siswa (NIS)
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nis" 
                            name="nis" 
                            value="<?php echo htmlspecialchars($siswa['nis']); ?>" 
                            required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500"
                            placeholder="Masukkan NIS siswa"
                        >
                    </div>
                    <p class="text-xs text-gray-500">NIS harus unik dan tidak boleh sama dengan siswa lain</p>
                </div>

                <!-- Nama Field -->
                <div class="space-y-2">
                    <label for="nama" class="block text-sm font-semibold text-gray-700">
                        Nama Lengkap
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="<?php echo htmlspecialchars($siswa['nama']); ?>" 
                            required
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 placeholder-gray-500"
                            placeholder="Masukkan nama lengkap siswa"
                        >
                    </div>
                </div>

                <!-- Kelas Field -->
                <div class="space-y-2">
                    <label for="kelas_id" class="block text-sm font-semibold text-gray-700">
                        Kelas
                        <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <select 
                            id="kelas_id" 
                            name="kelas_id" 
                            required
                            class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 text-gray-900 bg-white appearance-none"
                        >
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach ($daftar_kelas as $kelas): ?>
                                <option value="<?php echo $kelas['id']; ?>" <?php echo ($kelas['id'] == $siswa['kelas_id'] ? 'selected' : ''); ?>>
                                    <?php echo htmlspecialchars($kelas['nama_kelas']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                    <button 
                        type="submit"
                        class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-[1.02] focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg hover:shadow-xl"
                    >
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </div>
                    </button>
                    
                    <a 
                        href="admin.php?page=siswa" 
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-lg transition-all duration-200 text-center border border-gray-300 hover:border-gray-400 focus:outline-none focus:ring-4 focus:ring-gray-300"
                    >
                        <div class="flex items-center justify-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span>Batal</span>
                        </div>
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start space-x-3">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="text-sm text-blue-700">
                    <p class="font-medium">Informasi Penting:</p>
                    <ul class="mt-1 space-y-1 list-disc list-inside">
                        <li>Pastikan NIS yang dimasukkan belum digunakan oleh siswa lain</li>
                        <li>Nama lengkap harus sesuai dengan dokumen resmi</li>
                        <li>Perubahan kelas akan mempengaruhi data akademik siswa</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>