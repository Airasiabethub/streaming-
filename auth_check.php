<?php
// File: auth_check.php
// Memulai sesi (session)
session_start();

// Jika pengguna BELUM login, arahkan ke halaman login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
?>