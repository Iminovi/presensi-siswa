// Jalankan kode setelah seluruh halaman HTML dimuat
document.addEventListener("DOMContentLoaded", function() {
    const resultDiv = document.getElementById('scan-result');
    const qrReaderDiv = document.getElementById('qr-reader');

    // Jika elemen untuk menampilkan kamera tidak ada, hentikan script
    if (!qrReaderDiv) return;

    // Fungsi yang akan dijalankan ketika QR code berhasil dipindai
    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan scanner agar kamera tidak terus berjalan
        html5QrcodeScanner.clear();
        
        // Tampilkan pesan proses
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = `Memproses absensi...`;

        // Kirim data ke server (token, nis, dan tipe absen)
        const url = `../app/proses/proses_absen.php?token=${decodedText}&nis=${userNis}&type=${scanType}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Tampilkan pesan dari server (sukses, gagal, atau terlambat)
                resultDiv.innerHTML = data.message;
                resultDiv.className = 'result ' + data.status;

                // Setelah 3 detik, alihkan kembali ke dashboard siswa
                setTimeout(() => { 
                    window.location.href = 'siswa.php'; 
                }, 3000);
            })
            .catch(error => {
                // Jika ada error koneksi ke server
                resultDiv.innerHTML = "Terjadi kesalahan koneksi ke server.";
                resultDiv.className = 'result error';
            });
    }

    // Inisialisasi library scanner
    const html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { fps: 10, qrbox: { width: 250, height: 250 } }
    );

    // Mulai proses rendering kamera dan scan
    html5QrcodeScanner.render(onScanSuccess);
});
