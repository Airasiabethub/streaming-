<?php
// File: edit_video.php
require_once 'db_connect.php';

$id = $_GET['id'] ?? null;

// Jika tidak ada ID, redirect ke halaman utama
if (!$id) {
    header('Location: index.php');
    exit;
}

// Cek jika form disubmit untuk proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $thumbnail_url = $_POST['thumbnail_url'] ?? '';
    $video_url = $_POST['video_url'] ?? '';
    $video_id = $_POST['id'] ?? '';

    if (!empty($title) && !empty($video_url) && !empty($video_id)) {
        $sql = "UPDATE videos SET title = ?, description = ?, thumbnail_url = ?, video_url = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$title, $description, $thumbnail_url, $video_url, $video_id]);

        header("Location: index.php");
        exit;
    } else {
        $error = "Judul dan Video URL tidak boleh kosong!";
    }
}

// Ambil data video yang akan diedit
$stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
$stmt->execute([$id]);
$video = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika video tidak ditemukan, redirect
if (!$video) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Video</title>
    <style>
        body { font-family: sans-serif; margin: 40px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #444; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        textarea { resize: vertical; height: 100px; }
        .btn { padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        .submit-btn { background-color: #4CAF50; color: white; }
        .back-link { display: inline-block; margin-top: 15px; color: #008CBA; text-decoration: none; }
        .error { color: #f44336; margin-bottom: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Video: <?= htmlspecialchars($video['title']) ?></h1>

    <?php if (isset($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="edit_video.php?id=<?= $video['id'] ?>" method="post">
        <input type="hidden" name="id" value="<?= $video['id'] ?>">
        <div class="form-group">
            <label for="title">Judul Video</label>
            <input type="text" id="title" name="title" value="<?= htmlspecialchars($video['title']) ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"><?= htmlspecialchars($video['description']) ?></textarea>
        </div>
        <div class="form-group">
            <label for="thumbnail_url">URL Thumbnail</label>
            <input type="text" id="thumbnail_url" name="thumbnail_url" value="<?= htmlspecialchars($video['thumbnail_url']) ?>">
        </div>
        <div class="form-group">
            <label for="video_url">URL Video</label>
            <input type="text" id="video_url" name="video_url" value="<?= htmlspecialchars($video['video_url']) ?>" required>
        </div>
        <button type="submit" class="btn submit-btn">Update Video</button>
    </form>

    <a href="index.php" class="back-link">&larr; Kembali ke Daftar Video</a>
</div>

</body>
</html>