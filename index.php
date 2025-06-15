<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Sistem Absensi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f2f5;
        }
        .welcome-container {
            text-align: center;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .button-group {
            display: flex;
            gap: 20px;
        }
        .btn {
            display: inline-block;
            text-decoration: none;
            color: white;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }
        .btn-siswa {
            background-color: #28a745; /* Hijau */
        }
        .btn-admin {
            background-color: #007bff; /* Biru */
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Sistem Absensi QR Code</h1>
        <div class="button-group">
            <a href="public/login.php" class="btn btn-siswa">Login sebagai Siswa</a>
            <a href="public/login_admin.php'' class="btn btn-admin">Login sebagai Admin</a>
        </div>
    </div>
</body>
</html>
