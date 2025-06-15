<?php
require_once __DIR__ . '/../app/config.php';

// Cek sesi admin
if (!isset($_SESSION['admin_login'])) {
    die('Akses ditolak. Silakan login sebagai admin.');
}

// Tentukan jenis laporan
$jenis_laporan = $_GET['jenis'] ?? '';
$kelas_id = $_GET['kelas_id'] ?? '';
$params = [];
$filter_kelas_text = "Semua Kelas";

// Bangun query SQL berdasarkan jenis laporan
$sql = "SELECT s.nis, s.nama, k.nama_kelas, a.tanggal, a.waktu_hadir, a.waktu_pulang, a.status 
        FROM absensi a 
        JOIN siswa s ON a.siswa_id = s.id 
        LEFT JOIN kelas k ON s.kelas_id = k.id";

if ($jenis_laporan === 'harian') {
    $tanggal = $_GET['tanggal'] ?? date('Y-m-d');
    $judul_laporan = "Laporan Absensi Harian - " . date('d F Y', strtotime($tanggal));
    $sql .= " WHERE a.tanggal = ?";
    $params[] = $tanggal;
} elseif ($jenis_laporan === 'bulanan') {
    $bulan = $_GET['bulan'] ?? date('n');
    $tahun = $_GET['tahun'] ?? date('Y');
    $nama_bulan = date('F', mktime(0, 0, 0, $bulan, 10));
    $judul_laporan = "Laporan Absensi Bulanan - {$nama_bulan} {$tahun}";
    $sql .= " WHERE MONTH(a.tanggal) = ? AND YEAR(a.tanggal) = ?";
    $params[] = $bulan;
    $params[] = $tahun;
} else {
    die('Jenis laporan tidak valid.');
}

// Tambahkan filter kelas jika dipilih
if (!empty($kelas_id)) {
    $sql .= " AND s.kelas_id = ?";
    $params[] = $kelas_id;
    // Ambil nama kelas untuk judul
    $stmt_nama_kelas = $pdo->prepare("SELECT nama_kelas FROM kelas WHERE id = ?");
    $stmt_nama_kelas->execute([$kelas_id]);
    $filter_kelas_text = $stmt_nama_kelas->fetchColumn();
}

$sql .= " ORDER BY a.tanggal ASC, s.nama ASC";

// Eksekusi query
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$data_laporan = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?php echo $judul_laporan; ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
        h1 { margin: 0; }
        h2 { margin-top: 5px; font-weight: normal; font-size: 1em; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .no-print { margin-top: 20px; text-align: center; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo $judul_laporan; ?></h1>
        <h2>Kelas: <?php echo htmlspecialchars($filter_kelas_text); ?></h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Tanggal</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($data_laporan) > 0): ?>
                <?php foreach ($data_laporan as $index => $row): ?>
                    <tr>
                        <td><?php echo $index + 1; ?></td>
                        <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td><?php echo htmlspecialchars($row['nis']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama']); ?></td>
                        <td><?php echo ($row['waktu_hadir'] ? date('H:i:s', strtotime($row['waktu_hadir'])) : '-'); ?></td>
                        <td><?php echo ($row['waktu_pulang'] ? date('H:i:s', strtotime($row['waktu_pulang'])) : '-'); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data absensi untuk periode ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="no-print">
        <button onclick="window.print()">Cetak Halaman</button>
    </div>
</body>
</html>
