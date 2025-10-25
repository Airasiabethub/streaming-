<?php
// File: index.php

// ==========================================================
// 1. TAMBAHKAN PENGECEKAN OTENTIKASI (PENTING!)
// File ini akan memaksa user login jika belum ada sesi.
require_once 'auth_check.php'; 
// ==========================================================

require_once 'db_connect.php';

// Ambil semua video dari database, urutkan dari yang terbaru
$stmt = $pdo->query('SELECT id, title FROM videos ORDER BY id DESC');
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Daftar Video</title>
    <style>
        /* Menggunakan style Bootstrap untuk tampilan yang lebih bersih */
        body { font-family: sans-serif; background-color: #f4f4f9; color: #333; }
        .container { max-width: 800px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #212529; border-bottom: 2px solid #0d6efd; padding-bottom: 10px; margin-bottom: 20px; }
        .actions a { text-decoration: none; padding: 5px 10px; margin-right: 5px; border-radius: 4px; }
        /* Mengganti CSS kustom Anda dengan class Bootstrap */
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Video</h1>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
    
    <a href="add_video.php" class="btn btn-primary mb-3">Tambah Video Baru</a>

    <table class="table table-striped table-hover"> 
        <thead>
            <tr>
                <th style="width: 10%;">ID</th>
                <th>Judul</th>
                <th style="width: 25%;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($videos)): ?>
                <tr>
                    <td colspan="3" class="text-center">Belum ada video.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($videos as $video): ?>
                <tr>
                    <td><?= htmlspecialchars($video['id']) ?></td>
                    <td><?= htmlspecialchars($video['title']) ?></td>
                    <td class="actions">
                        <a href="edit_video.php?id=<?= $video['id'] ?>" class="btn btn-success btn-sm">Edit</a>
                        <a href="delete_video.php?id=<?= $video['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus video ini?');">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>