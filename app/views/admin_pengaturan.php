<?php
// FILE: app/views/admin_pengaturan.php

try {
    // === BAGIAN YANG DIPERBAIKI ===
    // Pilih HANYA dua kolom yang dibutuhkan: nama_pengaturan sebagai kolom 1 (key),
    // dan nilai_pengaturan sebagai kolom 2 (value).
    $query = "SELECT nama_pengaturan, nilai_pengaturan FROM pengaturan";
    $pengaturan = $pdo->query($query)->fetchAll(PDO::FETCH_KEY_PAIR);
    
    // Gunakan null coalescing '??' untuk memberikan nilai default jika data tidak ada
    $jam_masuk = $pengaturan['jam_masuk'] ?? '08:00:00';
    $jam_pulang = $pengaturan['jam_pulang'] ?? '16:00:00';

} catch (PDOException $e) {
    // Jika ada error (misal: tabel belum ada), gunakan nilai default
    $jam_masuk = '08:00:00';
    $jam_pulang = '16:00:00';
    // Anda bisa tambahkan pesan error di sini jika perlu
    // echo "Error: Tidak dapat mengambil data pengaturan.";
}

?>
<h2>Pengaturan Jam Absensi</h2>
<div class="form-container">
    <form action="../app/proses/proses_admin.php" method="POST">
        <input type="hidden" name="action" value="simpan_pengaturan">
        <div class="form-group">
            <label for="jam_masuk">Jam Masuk</label>
            <input type="time" id="jam_masuk" name="jam_masuk" value="<?php echo htmlspecialchars($jam_masuk); ?>" required>
        </div>
        <div class="form-group">
            <label for="jam_pulang">Jam Pulang</label>
            <input type="time" id="jam_pulang" name="jam_pulang" value="<?php echo htmlspecialchars($jam_pulang); ?>" required>
        </div>
        <button type="submit">Simpan Pengaturan</button>
    </form>
</div>
