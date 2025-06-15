<div class="dashboard-stats">
    <div class="stat-card">
        <h3>Total Siswa</h3>
        <p><?php echo $totalSiswa; ?></p>
    </div>
    <div class="stat-card">
        <h3>Hadir Hari Ini</h3>
        <p><?php echo $totalHadirHariIni; ?></p>
    </div>
</div>

<h2>Daftar Siswa</h2>
<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $pdo->query("SELECT nis, nama, kelas FROM siswa ORDER BY nama ASC");
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nis']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>