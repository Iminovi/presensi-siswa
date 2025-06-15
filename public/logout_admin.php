<?php
require_once __DIR__ . '/../app/config.php';

// Hancurkan semua data yang tersimpan di session
session_destroy();

// Alihkan ke halaman login admin
header('Location: login_admin.php');
exit();
