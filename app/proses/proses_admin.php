<?php
require_once __DIR__ . '/../config.php';
if (!isset($_SESSION['admin_login'])) { die('Akses ditolak.'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    try {
        // Gunakan transaksi untuk keamanan data saat menghapus
        $pdo->beginTransaction();

        switch ($action) {
            // == AKSI SISWA ==
            case 'tambah_siswa':
                $stmt = $pdo->prepare("INSERT INTO siswa (nis, nama, kelas_id) VALUES (?, ?, ?)");
                $stmt->execute([$_POST['nis'], $_POST['nama'], $_POST['kelas_id']]);
                break;

            case 'edit_siswa':
                $stmt = $pdo->prepare("UPDATE siswa SET nis = ?, nama = ?, kelas_id = ? WHERE id = ?");
                $stmt->execute([$_POST['nis'], $_POST['nama'], $_POST['kelas_id'], $_POST['id']]);
                break;

            case 'hapus_siswa':
                $stmt = $pdo->prepare("DELETE FROM siswa WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                break;
            
            // == AKSI KELAS ==
            case 'tambah_kelas':
                $stmt = $pdo->prepare("INSERT INTO kelas (nama_kelas) VALUES (?)");
                $stmt->execute([$_POST['nama_kelas']]);
                break;

            case 'hapus_kelas':
                // Lepaskan dulu semua siswa dari kelas ini
                $stmt_update_siswa = $pdo->prepare("UPDATE siswa SET kelas_id = NULL WHERE kelas_id = ?");
                $stmt_update_siswa->execute([$_POST['id']]);
                // Baru hapus kelasnya
                $stmt_hapus_kelas = $pdo->prepare("DELETE FROM kelas WHERE id = ?");
                $stmt_hapus_kelas->execute([$_POST['id']]);
                break;

            // == AKSI JADWAL ==
            case 'tambah_jadwal':
                $stmt = $pdo->prepare("INSERT INTO jadwal (nama_jadwal, jam_masuk, jam_pulang) VALUES (?, ?, ?)");
                $stmt->execute([$_POST['nama_jadwal'], $_POST['jam_masuk'], $_POST['jam_pulang']]);
                break;
            
            case 'ubah_jadwal_kelas':
                $stmt = $pdo->prepare("UPDATE kelas SET jadwal_id = ? WHERE id = ?");
                $stmt->execute([$_POST['jadwal_id'], $_POST['kelas_id']]);
                break;
            
            case 'hapus_jadwal':
                // Lepaskan dulu semua kelas dari jadwal ini
                $stmt_update_kelas = $pdo->prepare("UPDATE kelas SET jadwal_id = NULL WHERE jadwal_id = ?");
                $stmt_update_kelas->execute([$_POST['id']]);
                // Baru hapus jadwalnya
                $stmt_hapus_jadwal = $pdo->prepare("DELETE FROM jadwal WHERE id = ?");
                $stmt_hapus_jadwal->execute([$_POST['id']]);
                break;
        }

        // Jika semua berhasil, simpan perubahan
        $pdo->commit();

    } catch (PDOException $e) {
        // Jika ada error, batalkan semua perubahan
        $pdo->rollBack();
        header('Location: ../../public/admin.php?page=dashboard&status=gagal&err=' . urlencode($e->getMessage()));
        exit();
    }
    
    // Jika berhasil, redirect ke halaman yang sesuai
    $redirect_page = 'kelas_jadwal';
    if (in_array($action, ['tambah_siswa', 'edit_siswa', 'hapus_siswa'])) {
        $redirect_page = 'siswa';
    }
    header("Location: ../../public/admin.php?page={$redirect_page}&status=ok");
}
exit();
?>
