<?php
include "db.php";

// Fetch Images - Sabhi images fetch hongi (No Limit)
$images_sql = "SELECT trade_images.*, courses.course_name FROM trade_images 
               LEFT JOIN courses ON trade_images.course_id = courses.id ORDER BY id DESC";
$images_res = mysqli_query($conn, $images_sql);

// Fetch Videos - Sabhi videos fetch hongi (No Limit)
$videos_sql = "SELECT trade_videos.*, courses.course_name FROM trade_videos 
               LEFT JOIN courses ON trade_videos.course_id = courses.id ORDER BY id DESC";
$videos_res = mysqli_query($conn, $videos_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery | ITI Campus Life</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primarye: #042954;
            --accent: #FFC107;
            --blue-soft: #3b82f6;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-body: #f8fafc;
            --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--bg-body); color: var(--text-main); }

        .hero-section {
            padding: 100px 20px 40px;
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }
        .hero-section h1 {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--primarye);
            margin-bottom: 15px;
        }
        .line { width: 50px; height: 5px; background: var(--accent); margin: 0 auto 20px; border-radius: 10px; }

        /* --- Tabs --- */
        .filter-wrapper { 
            display: flex; justify-content: center; margin-bottom: 40px;
            position: sticky; top: 10px; z-index: 100;
        }
        .tab-box { 
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            padding: 6px; border-radius: 100px; display: flex; gap: 5px;
            border: 1px solid #e2e8f0; box-shadow: var(--card-shadow);
        }
        .t-btn {
            border: none; background: transparent; padding: 12px 30px;
            border-radius: 100px; font-weight: 700; cursor: pointer;
            transition: 0.3s; color: var(--text-muted);
        }
        .t-btn.active { background: var(--primarye); color: #fff; }

        /* --- UNLIMITED GRID --- */
        .container { max-width: 1400px; margin: 0 auto; padding: 0 20px 80px; }
        
        .media-grid {
            display: none;
            /* Ye line sabse important hai unlimited items ke liye */
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .media-grid.active { display: grid; animation: fadeIn 0.5s ease-in-out; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        .card {
            background: #fff; border-radius: 20px; overflow: hidden;
            transition: 0.3s; box-shadow: var(--card-shadow);
            border: 1px solid #f1f5f9;
        }
        .card:hover { transform: translateY(-8px); }

        .media-holder {
            width: 100%;
            aspect-ratio: 4 / 3; /* Sabhi items ek hi size ke dikhenge */
            background: #000;
            overflow: hidden;
        }
        .media-holder img, .media-holder video {
            width: 100%; height: 100%; object-fit: cover;
        }

        .card-info { padding: 15px 20px; background: #fff; }
        .tag {
            font-size: 13px; font-weight: 700; color: var(--primarye);
            display: flex; align-items: center; gap: 8px; text-transform: uppercase;
        }
        .tag::before { content: ""; width: 6px; height: 6px; background: var(--accent); border-radius: 50%; }

        @media (max-width: 640px) {
            .media-grid { grid-template-columns: 1fr; } /* Mobile me single column */
            .hero-section { padding-top: 60px; }
        }
    </style>
</head>
<body>

    <?php include "navbar.php"; ?>

    <section class="hero-section">
        <span style="color:var(--blue-soft); font-weight:800; letter-spacing:1px; font-size: 14px;">EXPLORE JS ITI</span>
        <h1>Campus Life Gallery</h1>
        <div class="line"></div>
        <p style="color:var(--text-muted);">A glimpse into our training workshops, events, and student activities.</p>
    </section>

    <div class="container">
        <div class="filter-wrapper">
            <div class="tab-box">
                <button class="t-btn active" onclick="switchMedia(event, 'photos')">
                    <i class="fas fa-camera"></i> Photos
                </button>
                <button class="t-btn" onclick="switchMedia(event, 'videos')">
                    <i class="fas fa-play-circle"></i> Videos
                </button>
            </div>
        </div>

        <div id="photos" class="media-grid active">
            <?php 
            if(mysqli_num_rows($images_res) > 0) {
                while($img = mysqli_fetch_assoc($images_res)){ 
            ?>
            <div class="card">
                <div class="media-holder">
                    <img src="image/<?php echo $img['image']; ?>" alt="Campus" loading="lazy">
                </div>
                <div class="card-info">
                    <span class="tag"><?php echo $img['course_name']; ?></span>
                </div>
            </div>
            <?php 
                }
            } else { echo "<p style='text-align:center; grid-column: 1/-1;'>No photos available.</p>"; }
            ?>
        </div>

        <div id="videos" class="media-grid">
            <?php 
            if(mysqli_num_rows($videos_res) > 0) {
                while($vid = mysqli_fetch_assoc($videos_res)){ 
            ?>
            <div class="card">
                <div class="media-holder">
                    <video controls preload="metadata">
                        <source src="video/<?php echo $vid['video']; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                <div class="card-info">
                    <span class="tag"><?php echo $vid['course_name']; ?></span>
                </div>
            </div>
            <?php 
                }
            } else { echo "<p style='text-align:center; grid-column: 1/-1;'>No videos available.</p>"; }
            ?>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script>
        function switchMedia(event, type) {
            const buttons = document.querySelectorAll('.t-btn');
            const grids = document.querySelectorAll('.media-grid');
            
            buttons.forEach(btn => btn.classList.remove('active'));
            grids.forEach(grid => grid.classList.remove('active'));

            event.currentTarget.classList.add('active');
            document.getElementById(type).classList.add('active');
            
            // Auto-pause videos when switching to photos
            if(type === 'photos') {
                document.querySelectorAll('video').forEach(v => v.pause());
            }
        }
    </script>

</body>
</html>