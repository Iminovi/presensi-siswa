<?php
// Langkah 1: Panggil file konfigurasi untuk memulai sesi dan koneksi DB
// Ini HARUS menjadi baris pertama.
require_once __DIR__ . '/../app/config.php';

// Langkah 2: Proses form HANYA jika ada data yang dikirim (metode POST)
$error_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($username) || empty($password)) {
        $error_message = 'Username dan kata sandi wajib diisi.';
    } else {
        // Cari admin di database
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();

        // Verifikasi password jika admin ditemukan
        if ($admin && password_verify($password, $admin['password'])) {
            // Jika berhasil: set session dan alihkan ke dashboard
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            header('Location: admin.php');
            exit(); // Penting: hentikan eksekusi setelah redirect
        } else {
            // Jika gagal: siapkan pesan error
            $error_message = 'Username atau kata sandi salah.';
        }
    }
}

// Langkah 3: Cek setelah semua proses, apakah pengguna sudah login?
// Jika sudah, jangan tampilkan form, langsung alihkan.
if (isset($_SESSION['admin_login']) && $_SESSION['admin_login'] === true) {
    header('Location: admin.php');
    exit();
}

// Langkah 4: Jika semua proses di atas tidak menyebabkan redirect,
// barulah tampilkan halaman HTML di bawah ini.
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body { display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f2f5; }
        .login-wrapper { max-width: 400px; width: 100%; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .error-msg { color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; padding: 10px; border-radius: 4px; text-align: center; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        .btn-login { width: 100%; background-color: #3498db; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="brand">
			<img class="brand-img" style="width: 160px;" src="channels4_profile.jpg" alt="...">
            ====
            <img class="brand-img" style="width: 130px;" src="PP.jpg" alt="...">
        <?php if (!empty($error_message)): ?>
            <p class="error-msg"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="login_admin.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html>
