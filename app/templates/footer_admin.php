        </div> <!-- Penutup untuk .p-6 -->
    </main> <!-- Penutup untuk .ml-64 -->

<script>
function confirmLogout() {
    // Tampilkan dialog konfirmasi
    if (confirm('Apakah Anda yakin ingin logout?')) {
        // Arahkan ke file logout yang benar
        window.location.href = 'logout_admin.php';
    }
}
</script>

</body>
</html>
<footer class="bg-white shadow-inner py-4">
    <div class="container mx-auto text-center text-gray-600">
        <p class="text-sm">© <?php echo date('Y'); ?> Sistem Absensi Sekolah. All rights reserved.</p>
        <p class="text-xs">Dikembangkan oleh Tim IT jokitugas69</p>
    </div>
</footer>