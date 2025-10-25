<?php
// File: delete_video.php
require_once 'db_connect.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM videos WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
}

// Redirect kembali ke halaman utama setelah menghapus
header("Location: index.php");
exit;
?>