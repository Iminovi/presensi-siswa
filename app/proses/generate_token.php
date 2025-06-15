<?php
require_once __DIR__ . '/../config.php';

// Path ke file token sementara
$tokenFilePath = __DIR__ . '/../token/qr_token.json';

// Buat data token baru
$data = [
    'token' => generateToken(20),
    'expiry' => time() + 10 // Tetap berlaku 10 detik
];

// Simpan data ke file dalam format JSON
file_put_contents($tokenFilePath, json_encode($data));

// Kirim token-nya saja sebagai respons ke browser admin
echo $data['token'];
?>
