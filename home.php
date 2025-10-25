<?php
// TUGAS 1: MEMUAT KONEKSI
require_once 'db_connect.php'; // Memuat koneksi ke SQLite PDO ($pdo)
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Situs Streaming Keren</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #141414; /* Background gelap khas streaming */
            color: #fff; /* Teks putih */
            font-family: 'Arial', sans-serif;
        }
        .header-bar {
            background-color: #000;
            padding: 15px 30px;
            margin-bottom: 20px;
            border-bottom: 3px solid #E50914; /* Garis merah sebagai aksen */
        }
        .header-bar h1 {
            color: #E50914; /* Judul situs berwarna merah */
            font-weight: bold;
        }
        .card-video {
            /* Menghilangkan border standar dan bayangan untuk tampilan clean */
            border: none;
            background-color: #1f1f1f; 
            transition: transform 0.2s; /* Efek hover sederhana */
            cursor: pointer;
        }
        .card-video:hover {
            transform: scale(1.05); /* Memperbesar kartu saat di-hover */
            z-index: 10; /* Pastikan kartu yang diperbesar menutupi kartu di sebelahnya */
        }
        .card-img-top {
            object-fit: cover;
            height: 200px; /* Tinggi thumbnail yang seragam */
        }
        .card-title {
            font-size: 1rem;
            white-space: nowrap; /* Mencegah judul turun baris */
            overflow: hidden;
            text-overflow: ellipsis; /* Menampilkan elipsis jika judul terlalu panjang */
        }
        .text-danger {
             /* Menghilangkan tautan "Tonton" yang tidak lagi diperlukan, karena tautan ada pada kartu */
             display: none;
        }
    </style>
</head>
<body>

    <header class="header-bar">
        <div class="d-flex justify-content-between align-items-center">
            <h1>STREAMING KERE-N</h1>
            <a href="../admin-videotest/index.php" class="btn btn-outline-light">Admin Panel</a>
        </div>
    </header>

    <div class="container-fluid px-4">
        <h2>Katalog Video Populer</h2>
        
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 g-md-4"> 
            <?php
            // TUGAS 2: MENGAMBIL DATA DARI DATABASE
            try {
                $stmt = $pdo->query("SELECT id, title, thumbnail_url, video_url FROM videos ORDER BY id DESC");
                $videos = $stmt->fetchAll();

                if (count($videos) > 0) {
                    // TUGAS 3: MENAMPILKAN KATALOG DENGAN PERULANGAN (LOOP)
                    foreach ($videos as $video) {
            ?>
                        <div class="col">
                            <a href="play.php?id=<?php echo $video['id']; ?>" class="text-decoration-none text-white">
                                <div class="card card-video shadow">
                                    <img src="<?php echo htmlspecialchars($video['thumbnail_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($video['title']); ?>">
                                    <div class="card-body p-2">
                                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($video['title']); ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
            <?php
                    }
                } else {
                    echo "<p class='text-white p-3'>Katalog masih kosong. Silakan tambahkan video melalui Admin Panel.</p>";
                }
            } catch (PDOException $e) {
                echo "<p class='text-danger'>Error saat mengambil data: " . $e->getMessage() . "</p>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>