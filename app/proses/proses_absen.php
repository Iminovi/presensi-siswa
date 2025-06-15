<?php
require_once __DIR__ . '/../config.php';
header('Content-Type: application/json');

// 1. Ambil semua data yang dibutuhkan dari URL
$token_from_qr = $_GET['token'] ?? '';
$nis = $_GET['nis'] ?? '';
$type = $_GET['type'] ?? 'masuk';

// 2. Validasi dasar
if (empty($token_from_qr) || empty($nis)) {
    echo json_encode(['status' => 'error', 'message' => 'Permintaan tidak valid. Token atau NIS kosong.']);
    exit();
}

// 3. Validasi Keamanan Token QR dari FILE
$tokenFilePath = __DIR__ . '/../token/qr_token.json';
if (!file_exists($tokenFilePath)) {
    echo json_encode(['status' => 'error', 'message' => 'Sesi absen QR tidak aktif.']);
    exit();
}
$data = json_decode(file_get_contents($tokenFilePath), true);
$server_token = $data['token'] ?? null;
$token_expiry = $data['expiry'] ?? 0;
if ($server_token === null || $token_from_qr !== $server_token || time() > $token_expiry) {
    echo json_encode(['status' => 'error', 'message' => 'Kode QR tidak valid atau sudah kedaluwarsa.']);
    exit();
}
unlink($tokenFilePath);

try {
    // 4. Ambil data siswa beserta jadwal kelasnya
    $stmtSiswa = $pdo->prepare("SELECT s.id, s.nama, s.kelas_id, j.jam_masuk FROM siswa s JOIN kelas k ON s.kelas_id = k.id JOIN jadwal j ON k.jadwal_id = j.id WHERE s.nis = ?");
    $stmtSiswa->execute([$nis]);
    $siswa = $stmtSiswa->fetch();
    if (!$siswa) {
        echo json_encode(['status' => 'error', 'message' => 'NIS Anda tidak terdaftar atau kelas Anda belum memiliki jadwal.']);
        exit();
    }
    
    $siswa_id = $siswa['id'];
    $jam_masuk_str = $siswa['jam_masuk'];
    $tanggal_sekarang = date('Y-m-d');

    // Cek data absen hari ini
    $stmtCek = $pdo->prepare("SELECT * FROM absensi WHERE siswa_id = ? AND tanggal = ?");
    $stmtCek->execute([$siswa_id, $tanggal_sekarang]);
    $absen_hari_ini = $stmtCek->fetch();

    // 5. Logika utama berdasarkan tipe absen
    if ($type === 'masuk') {
        if ($absen_hari_ini) {
            echo json_encode(['status' => 'error', 'message' => 'Anda sudah melakukan absen masuk hari ini.']);
            exit();
        }
        
        // === PERBAIKAN LOGIKA MASUK ===
        // Tentukan status terlambat atau tidak, TAPI JANGAN BLOKIR.
        $batas_waktu_masuk = strtotime($tanggal_sekarang . ' ' . $jam_masuk_str);
        $status_kehadiran = (time() > $batas_waktu_masuk) ? 'Terlambat' : 'Tepat Waktu';

        // Masukkan data absensi baru dengan status yang benar
        $stmtInsert = $pdo->prepare("INSERT INTO absensi (siswa_id, waktu_hadir, tanggal, status) VALUES (?, NOW(), ?, ?)");
        $stmtInsert->execute([$siswa_id, $tanggal_sekarang, $status_kehadiran]);

        $pesan = "Absensi Masuk berhasil! Status Anda: {$status_kehadiran}.";
        $response_status = ($status_kehadiran === 'Terlambat') ? 'late' : 'success';
        echo json_encode(['status' => $response_status, 'message' => $pesan]);

    } elseif ($type === 'pulang') {
        if (!$absen_hari_ini) {
            echo json_encode(['status' => 'error', 'message' => 'Anda belum melakukan absen masuk hari ini.']);
            exit();
        }
        if ($absen_hari_ini['waktu_pulang'] !== null) {
            echo json_encode(['status' => 'error', 'message' => 'Anda sudah melakukan absen pulang hari ini.']);
            exit();
        }

        // === PERBAIKAN LOGIKA PULANG ===
        // Hanya perbarui waktu pulang. JANGAN UBAH STATUS, agar catatan 'Terlambat' tidak hilang.
        $stmtUpdate = $pdo->prepare("UPDATE absensi SET waktu_pulang = NOW() WHERE id = ?");
        $stmtUpdate->execute([$absen_hari_ini['id']]);

        echo json_encode(['status' => 'success', 'message' => 'Absensi Pulang berhasil! Sampai jumpa besok.']);
    }

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Terjadi kesalahan pada server.']);
    error_log($e->getMessage());
}
?>
