<h2>Tambah Siswa Baru</h2>
<form action="../app/proses/proses_admin.php" method="POST" class="form-admin">
    <input type="hidden" name="action" value="tambah_siswa">
    <div class="form-group">
        <label for="nis">Nomor Induk Siswa (NIS)</label>
        <input type="text" id="nis" name="nis" required>
    </div>
    <div class="form-group">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required>
    </div>
    <div class="form-group">
        <label for="kelas">Kelas</label>
        <input type="text" id="kelas" name="kelas" required>
    </div>
    <button type="submit">Tambahkan Siswa</button>
</form>