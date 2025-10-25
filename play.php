<?php
// Memuat koneksi database (SQLite)
require_once 'db_connect.php'; 

// 1. Ambil ID video dari URL (contoh: play.php?id=1)
$video_id = $_GET['id'] ?? null; 

// Pastikan ID adalah angka untuk keamanan
if (!filter_var($video_id, FILTER_VALIDATE_INT)) {
    die("ID video tidak valid.");
}

// 2. Ambil data video berdasarkan ID
try {
    // Siapkan query yang aman
    $stmt = $pdo->prepare("SELECT * FROM videos WHERE id = ?");
    $stmt->execute([$video_id]);
    $video = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$video) {
        die("Video tidak ditemukan.");
    }
} catch (PDOException $e) {
    die("Error database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tonton: <?php echo htmlspecialchars($video['title']); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #141414; /* Background gelap khas streaming */
            color: #fff; /* Teks putih */
            font-family: 'Arial', sans-serif;
            padding-top: 20px;
        }
        .header-link {
            color: #fff;
            text-decoration: none;
            margin-bottom: 20px;
            display: inline-block;
            font-size: 1.1rem;
        }
        .header-link:hover {
            color: #E50914; /* Efek hover merah */
        }
        .video-player-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }
        .ratio-16x9 {
            margin-bottom: 20px;
            /* Pastikan player memiliki tampilan border-radius agar lebih modern */
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="home.php" class="header-link">&larr; Kembali ke Katalog</a>

    <div class="video-player-container">
        <h1 class="text-white mb-4"><?php echo htmlspecialchars($video['title']); ?></h1>

        <div class="ratio ratio-16x9">
            <?php 
            $url = htmlspecialchars($video['video_url']);
            
            // Logika pemutar video
            if (strpos($url, 'youtube.com') !== false || strpos($url, 'youtu.be') !== false) {
                echo "<iframe src=\"$url\" allowfullscreen></iframe>";
            } else {
                // Jika bukan link embed, gunakan tag HTML5 <video>
                echo "<video width='100%' controls class='bg-black'><source src=\"$url\" type=\"video/mp4\">Browser Anda tidak mendukung pemutaran video.</video>";
            }
            ?>
        </div>
        
        <div class="description-box mt-4 p-3 bg-dark rounded shadow">
            <h3 class="text-white border-bottom pb-2">Deskripsi</h3>
            <p class="text-secondary"><?php echo nl2br(htmlspecialchars($video['description'])); ?></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>