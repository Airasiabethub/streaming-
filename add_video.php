<?php
// File: add_video.php
require_once 'db_connect.php';

// Cek jika form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $thumbnail_url = $_POST['thumbnail_url'] ?? '';
    $video_url = $_POST['video_url'] ?? '';

    // Validasi sederhana
    if (!empty($title) && !empty($video_url)) {
        $sql = "INSERT INTO videos (title, description, thumbnail_url, video_url) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $thumbnail_url, $video_url]);

        // Redirect kembali ke halaman utama
        header("Location: index.php");
        exit;
    } else {
        $error = "Judul dan Video URL tidak boleh kosong!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Video Baru</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #444; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .submit-btn { background-color: #008CBA; color: white; }
        .back-link { display: inline-block; margin-top: 15px; color: #008CBA; text-decoration: none; }
        .error { color: #f44336; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Tambah Video Baru</h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="add_video.php" method="post">
        <div class="form-group">
            <label for="title">Judul Video</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div class="form-group">
            <label for="thumbnail_url">URL Thumbnail</label>
            <input type="text" id="thumbnail_url" name="thumbnail_url">
        </div>
        <div class="form-group">
            <label for="video_url">URL Video</label>
            <input type="text" id="video_url" name="video_url" required>
        </div>
        <button type="submit" class="btn submit-btn">Simpan Video</button>
    </form>

    <a href="index.php" class="back-link">&larr; Kembali ke Daftar Video</a>
</div>

</body>
</html>