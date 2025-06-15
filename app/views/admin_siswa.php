<?php
// Ambil daftar kelas untuk dropdown di form tambah siswa
$stmt_kelas_dropdown = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
$daftar_kelas_dropdown = $stmt_kelas_dropdown->fetchAll();
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Manajemen Siswa</h1>
            <p class="text-gray-600">Kelola data siswa dan kelas dengan mudah</p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="toggleAddForm()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md">
                <i class="fas fa-plus mr-2"></i>
                Tambah Siswa
            </button>
            <button onclick="exportData()" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                <i class="fas fa-download mr-2"></i>
                Export Excel
            </button>
        </div>
    </div>
</div>

<!-- Form Tambah Siswa -->
<div id="addStudentForm" class="bg-white rounded-xl shadow-lg mb-8 overflow-hidden transform transition-all duration-300 scale-95 opacity-0 max-h-0" style="display: none;">
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-white">Tambah Siswa Baru</h3>
            </div>
            <button onclick="toggleAddForm()" class="text-white hover:text-gray-200 transition-colors duration-200">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
    </div>
    
    <form action="../app/proses/proses_admin.php" method="POST" class="p-6">
        <input type="hidden" name="action" value="tambah_siswa">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <label for="nis" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-id-card mr-2 text-blue-500"></i>
                    NIS (Nomor Induk Siswa)
                </label>
                <input type="text" 
                       id="nis" 
                       name="nis" 
                       required 
                       placeholder="Masukkan NIS siswa"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900">
            </div>
            
            <div class="space-y-2">
                <label for="nama" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-user mr-2 text-green-500"></i>
                    Nama Lengkap
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       required 
                       placeholder="Masukkan nama lengkap siswa"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900">
            </div>
        </div>
        
        <div class="mt-6 space-y-2">
            <label for="kelas_id" class="block text-sm font-semibold text-gray-700">
                <i class="fas fa-school mr-2 text-purple-500"></i>
                Kelas
            </label>
            <select id="kelas_id" 
                    name="kelas_id" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-gray-900">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($daftar_kelas_dropdown as $kelas): ?>
                    <option value="<?php echo $kelas['id']; ?>"><?php echo htmlspecialchars($kelas['nama_kelas']); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="mt-8 flex items-center justify-end space-x-4">
            <button type="button" 
                    onclick="toggleAddForm()"
                    class="px-6 py-3 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors duration-200">
                Batal
            </button>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors duration-200 shadow-md">
                <i class="fas fa-save mr-2"></i>
                Tambahkan Siswa
            </button>
        </div>
    </form>
</div>

<!-- Statistics Cards -->
<div id="statsCards" class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Siswa -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100 text-sm font-medium">Total Siswa</p>
                <?php
                $total_siswa = $pdo->query("SELECT COUNT(*) FROM siswa")->fetchColumn();
                ?>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($total_siswa); ?></p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Total Kelas -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-green-100 text-sm font-medium">Total Kelas</p>
                <?php
                $total_kelas = $pdo->query("SELECT COUNT(*) FROM kelas")->fetchColumn();
                ?>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($total_kelas); ?></p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-school text-2xl"></i>
            </div>
        </div>
    </div>
    
    <!-- Siswa Tanpa Kelas -->
    <div class="bg-gradient-to-r from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-red-100 text-sm font-medium">Tanpa Kelas</p>
                <?php
                $siswa_tanpa_kelas_count = $pdo->query("SELECT COUNT(*) FROM siswa WHERE kelas_id IS NULL")->fetchColumn();
                ?>
                <p class="text-3xl font-bold mt-2"><?php echo number_format($siswa_tanpa_kelas_count); ?></p>
            </div>
            <div class="bg-white bg-opacity-20 rounded-full p-3">
                <i class="fas fa-exclamation-triangle text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-xl shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
        <div class="flex-1 max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari siswa berdasarkan nama atau NIS..."
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>
        <div class="flex items-center space-x-4">
            <select id="filterKelas" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">Semua Kelas</option>
                <?php foreach ($daftar_kelas_dropdown as $kelas): ?>
                    <option value="<?php echo $kelas['id']; ?>"><?php echo htmlspecialchars($kelas['nama_kelas']); ?></option>
                <?php endforeach; ?>
                <option value="null">Tanpa Kelas</option>
            </select>
            <button onclick="resetFilters()" class="px-4 py-2 text-gray-600 hover:text-gray-800 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                <i class="fas fa-undo mr-2"></i>
                Reset
            </button>
        </div>
    </div>
</div>

<!-- Daftar Siswa per Kelas -->
<div class="space-y-6">
    <?php
    // Langkah 1: Ambil semua daftar kelas yang ada
    $stmt_kelas_utama = $pdo->query("SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
    $semua_kelas = $stmt_kelas_utama->fetchAll();

    // Langkah 2: Ulangi (loop) untuk setiap kelas
    foreach ($semua_kelas as $kelas):
    ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden" data-kelas-id="<?php echo $kelas['id']; ?>">
            <!-- Header Kelas -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-graduation-cap text-white text-lg"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-white"><?php echo htmlspecialchars($kelas['nama_kelas']); ?></h3>
                            <?php
                            $siswa_count = $pdo->prepare("SELECT COUNT(*) FROM siswa WHERE kelas_id = ?");
                            $siswa_count->execute([$kelas['id']]);
                            $count = $siswa_count->fetchColumn();
                            ?>
                            <p class="text-indigo-100 text-sm"><?php echo $count; ?> siswa</p>
                        </div>
                    </div>
                    <button onclick="toggleClassTable(<?php echo $kelas['id']; ?>)" class="text-white hover:text-indigo-200 transition-colors duration-200">
                        <i class="fas fa-chevron-down text-xl transform transition-transform duration-200" id="chevron-<?php echo $kelas['id']; ?>"></i>
                    </button>
                </div>
            </div>
            
            <!-- Tabel Siswa -->
            <div class="overflow-x-auto" id="table-<?php echo $kelas['id']; ?>">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        // Langkah 3: Ambil semua siswa yang ada di kelas saat ini
                        $stmt_siswa_per_kelas = $pdo->prepare("SELECT id, nis, nama FROM siswa WHERE kelas_id = ? ORDER BY nama ASC");
                        $stmt_siswa_per_kelas->execute([$kelas['id']]);
                        $siswa_di_kelas = $stmt_siswa_per_kelas->fetchAll();

                        if (count($siswa_di_kelas) > 0):
                            foreach ($siswa_di_kelas as $index => $row):
                                $row_class = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                        ?>
                            <tr class="<?php echo $row_class; ?> hover:bg-blue-50 transition-colors duration-150 student-row" data-nama="<?php echo strtolower($row['nama']); ?>" data-nis="<?php echo $row['nis']; ?>" data-kelas-id="<?php echo $kelas['id']; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-400 to-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                            <?php echo strtoupper(substr($row['nama'], 0, 1)); ?>
                                        </div>
                                        <span class="text-sm font-mono font-medium text-gray-900"><?php echo htmlspecialchars($row['nis']); ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['nama']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="admin.php?page=edit_siswa&id=<?php echo $row['id']; ?>" 
                                           class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors duration-200">
                                            <i class="fas fa-edit mr-1"></i>
                                            Edit
                                        </a>
                                        <form method="POST" action="../app/proses/proses_admin.php" class="inline" onsubmit="return confirmDelete('<?php echo htmlspecialchars($row['nama']); ?>')">
                                            <input type="hidden" name="action" value="hapus_siswa">
                                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full hover:bg-red-200 transition-colors duration-200">
                                                <i class="fas fa-trash mr-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            endforeach;
                        else:
                        ?>
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-4xl text-gray-300 mb-3"></i>
                                        <p class="text-gray-500">Tidak ada siswa di kelas ini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Siswa Tanpa Kelas -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border-l-4 border-red-500" data-kelas-id="null">
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-exclamation-triangle text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Siswa Belum Punya Kelas</h3>
                        <p class="text-red-100 text-sm"><?php echo $siswa_tanpa_kelas_count; ?> siswa</p>
                    </div>
                </div>
                <button onclick="toggleClassTable('null')" class="text-white hover:text-red-200 transition-colors duration-200">
                    <i class="fas fa-chevron-down text-xl transform transition-transform duration-200" id="chevron-null"></i>
                </button>
            </div>
        </div>
        
        <div class="overflow-x-auto" id="table-null">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIS</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $stmt_tanpa_kelas = $pdo->query("SELECT id, nis, nama FROM siswa WHERE kelas_id IS NULL ORDER BY nama ASC");
                    $siswa_tanpa_kelas = $stmt_tanpa_kelas->fetchAll();

                    if (count($siswa_tanpa_kelas) > 0):
                        foreach ($siswa_tanpa_kelas as $index => $row):
                            $row_class = $index % 2 === 0 ? 'bg-white' : 'bg-gray-50';
                    ?>
                        <tr class="<?php echo $row_class; ?> hover:bg-red-50 transition-colors duration-150 student-row" data-nama="<?php echo strtolower($row['nama']); ?>" data-nis="<?php echo $row['nis']; ?>" data-kelas-id="null">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-red-400 to-red-500 rounded-full flex items-center justify-center text-white text-sm font-bold mr-3">
                                        <?php echo strtoupper(substr($row['nama'], 0, 1)); ?>
                                    </div>
                                    <span class="text-sm font-mono font-medium text-gray-900"><?php echo htmlspecialchars($row['nis']); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['nama']); ?></div>
                                <div class="text-xs text-red-500 font-medium">Perlu ditempatkan ke kelas</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="admin.php?page=edit_siswa&id=<?php echo $row['id']; ?>" 
                                       class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full hover:bg-blue-200 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="../app/proses/proses_admin.php" class="inline" onsubmit="return confirmDelete('<?php echo htmlspecialchars($row['nama']); ?>')">
                                        <input type="hidden" name="action" value="hapus_siswa">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" 
                                                class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 text-xs font-medium rounded-full hover:bg-red-200 transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endforeach;
                    else:
                    ?>
                        <tr>
                            <td colspan="3" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-check-circle text-4xl text-green-400 mb-3"></i>
                                    <p class="text-gray-500">Semua siswa sudah memiliki kelas</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Toggle form tambah siswa
function toggleAddForm() {
    const form = document.getElementById('addStudentForm');
    const isHidden = form.style.display === 'none';
    
    if (isHidden) {
        form.style.display = 'block';
        setTimeout(() => {
            form.classList.remove('scale-95', 'opacity-0', 'max-h-0');
            form.classList.add('scale-100', 'opacity-100', 'max-h-full');
        }, 10);
    } else {
        form.classList.remove('scale-100', 'opacity-100', 'max-h-full');
        form.classList.add('scale-95', 'opacity-0', 'max-h-0');
        setTimeout(() => {
            form.style.display = 'none';
        }, 300);
    }
}

// Toggle tabel kelas
function toggleClassTable(kelasId) {
    const table = document.getElementById('table-' + kelasId);
    const chevron = document.getElementById('chevron-' + kelasId);
    
    if (table.style.display === 'none') {
        table.style.display = 'block';
        chevron.classList.remove('rotate-180');
    } else {
        table.style.display = 'none';
        chevron.classList.add('rotate-180');
    }
}

// Konfirmasi hapus
function confirmDelete(nama) {
    return confirm(`Apakah Anda yakin ingin menghapus siswa "${nama}"?\n\nTindakan ini tidak dapat dibatalkan.`);
}

// Search functionality
document.getElementById('searchInput').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('.student-row');
    
    rows.forEach(row => {
        const nama = row.dataset.nama;
        const nis = row.dataset.nis.toLowerCase();
        
        if (nama.includes(searchTerm) || nis.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Filter by class
document.getElementById('filterKelas').addEventListener('change', function() {
    const selectedKelas = this.value;
    const kelasContainers = document.querySelectorAll('[data-kelas-id]');
    
    kelasContainers.forEach(container => {
        if (selectedKelas === '' || container.dataset.kelasId === selectedKelas) {
            container.style.display = 'block';
        } else {
            container.style.display = 'none';
        }
    });
});

// Reset filters
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterKelas').value = '';
    
    // Show all rows and containers
    document.querySelectorAll('.student-row').forEach(row => {
        row.style.display = '';
    });
    
    document.querySelectorAll('[data-kelas-id]').forEach(container => {
        container.style.display = 'block';
    });
}

// Export functionality (placeholder)
function exportData() {
    alert('Fitur export akan segera tersedia!');
}

// Auto-focus on search when pressing '/'
document.addEventListener('keydown', function(e) {
    if (e.key === '/' && e.target.tagName !== 'INPUT') {
        e.preventDefault();
        document.getElementById('searchInput').focus();
    }
});
</script>