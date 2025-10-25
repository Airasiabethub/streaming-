<?php
// File: db_connect.php

// Definisikan variabel $pdo di awal, agar bisa diakses di luar blok try/catch
$pdo = null; 

// Tentukan path ke file database SQLite. File akan dibuat di folder ini.
$db_file = __DIR__ . '/videos.db';

try {
    // 1. Buat (atau buka) koneksi ke database
    $pdo = new PDO('sqlite:' . $db_file); 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ==========================================================
    // BAGIAN INISIALISASI DATABASE
    // ==========================================================
    
    // 2. SQL untuk membuat tabel 'videos' jika belum ada
    $create_videos_table_query = "
    CREATE TABLE IF NOT EXISTS videos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        title TEXT NOT NULL,
        description TEXT,
        thumbnail_url TEXT,
        video_url TEXT NOT NULL
    );";

    // 3. SQL untuk membuat tabel 'users' jika belum ada (UNTUK LOGIN)
    $create_users_table_query = "
    CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password TEXT NOT NULL 
    );";

    // Eksekusi query untuk membuat kedua tabel
    $pdo->exec($create_videos_table_query);
    $pdo->exec($create_users_table_query);

    // 4. Masukkan admin default jika tabel 'users' masih kosong
    $check_user_query = $pdo->query("SELECT COUNT(*) FROM users");
    $user_count = $check_user_query->fetchColumn();

    if ($user_count == 0) {
        $default_username = 'admin123';
        $default_password = 'admin123';
        
        // Password dienkripsi dengan BCRYPT
        $default_password_hash = password_hash($default_password, PASSWORD_BCRYPT); 
        
        $insert_admin_query = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $insert_admin_query->execute([$default_username, $default_password_hash]);
    }
    // ==========================================================

} catch (PDOException $e) {
    // Tampilkan pesan error dan set $pdo=null.
    $pdo = null;
    die("Koneksi database gagal: " . $e->getMessage() . ". Cek izin tulis (write permission) pada folder.");
}
?>
<!-- TIDAK ADA TEKS ATAU KODE APAPUN DI BAWAH TAG PENUTUP PHP INI -->