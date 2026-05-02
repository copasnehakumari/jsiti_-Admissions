<?php
include "../db.php";

// 1. Sabhi courses fetch karein filter ke liye
$courses_res = mysqli_query($conn, "SELECT * FROM courses");

// 2. Filter Logic (Agar kisi specific course ki video dekhni ho)
$filter_query = "";
if(isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $c_id = mysqli_real_escape_string($conn, $_GET['course_id']);
    $filter_query = " WHERE trade_videos.course_id = '$c_id' ";
}

// 3. Videos fetch karein course name ke saath
$sql = "SELECT trade_videos.*, courses.course_name 
        FROM trade_videos 
        LEFT JOIN courses ON trade_videos.course_id = courses.id 
        $filter_query 
        ORDER BY trade_videos.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Lectures | ITI Admin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #002147;
            --accent: #fbbf24;
            --bg-soft: #f4f7fe;
            --sidebar-w: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-soft); color: #1e293b; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 30px; 
            transition: all 0.3s;
        }

        /* --- Header & Filter Area --- */
        .page-header {
            background: #fff;
            padding: 25px 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        .header-title h2 { color: var(--primary); font-weight: 800; font-size: 24px; }

        .filter-section { display: flex; gap: 15px; align-items: center; }
        
        .select-input {
            padding: 10px 15px; border-radius: 12px; border: 2px solid #e2e8f0;
            font-size: 14px; font-weight: 600; outline: none; background: #fff;
        }

        .btn-add-video {
            background: var(--primary); color: #fff; padding: 12px 22px;
            border-radius: 12px; text-decoration: none; font-weight: 700;
            font-size: 14px; display: flex; align-items: center; gap: 8px;
            transition: 0.3s;
        }
        .btn-add-video:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,33,71,0.2); }

        /* --- Video Grid --- */
        .video-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .video-card {
            background: #fff;
            border-radius: 22px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
            transition: 0.3s;
            border: 1px solid rgba(0,0,0,0.05);
        }

        .video-card:hover { transform: translateY(-5px); box-shadow: 0 15px 35px rgba(0,0,0,0.08); }

        .video-container {
            width: 100%;
            height: 180px;
            background: #000;
            position: relative;
        }

        video { width: 100%; height: 100%; object-fit: cover; }

        .video-info { padding: 20px; position: relative; }
        
        .course-badge {
            font-size: 10px; font-weight: 800; background: #fffbeb;
            color: #b45309; padding: 5px 12px; border-radius: 20px;
            display: inline-block; margin-bottom: 10px; text-transform: uppercase;
        }

        .video-title {
            font-size: 16px; font-weight: 700; color: var(--primary);
            margin-bottom: 15px; display: block;
        }

        /* --- Delete Button --- */
        .btn-delete-vid {
            background: #fee2e2; color: #ef4444; border: none;
            width: 40px; height: 40px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: 0.3s;
            position: absolute; bottom: 15px; right: 15px;
        }
        .btn-delete-vid:hover { background: #ef4444; color: #fff; }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; }
            :root { --sidebar-w: 0px; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <div class="header-title">
                <h2><i class="fas fa-play-circle"></i> Course Video Lectures</h2>
            </div>

            <div class="filter-section">
                <form method="GET" id="filterForm">
                    <select name="course_id" class="select-input" onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Course Categories</option>
                        <?php 
                        mysqli_data_seek($courses_res, 0);
                        while($c = mysqli_fetch_assoc($courses_res)){
                            $selected = (isset($_GET['course_id']) && $_GET['course_id'] == $c['id']) ? "selected" : "";
                            echo "<option value='".$c['id']."' $selected>".$c['course_name']."</option>";
                        }
                        ?>
                    </select>
                </form>
                <a href="add_trade_videos.php" class="btn-add-video">
                    <i class="fas fa-upload"></i> New Upload
                </a>
            </div>
        </div>

        <div class="video-grid">
            <?php if(mysqli_num_rows($result) > 0){ ?>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="video-card">
                    <div class="video-container">
                        <video controls>
                            <source src="../video/<?php echo $row['video']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                    <div class="video-info">
                        <span class="course-badge"><?php echo $row['course_name']; ?></span>
                        <strong class="video-title">Module Lecture #<?php echo $row['id']; ?></strong>
                        
                        <p style="font-size: 12px; color: #94a3b8;"><i class="fas fa-file-video"></i> <?php echo $row['video']; ?></p>

                        <button class="btn-delete-vid" onclick="confirmDelete(<?php echo $row['id']; ?>)" title="Delete Video">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <?php } ?>
            <?php } else { ?>
                <div style="grid-column: span 3; text-align: center; padding: 60px; background: #fff; border-radius: 30px;">
                    <i class="fas fa-video-slash" style="font-size: 60px; color: #e2e8f0; margin-bottom: 20px;"></i>
                    <h3 style="color: #64748b;">No videos found</h3>
                    <p style="color: #94a3b8;">Try changing the filter or upload a new lecture.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Video?',
            text: "Kyah aap waqai is lecture video ko hatana chahte hain?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#002147',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete_video.php?id=' + id;
            }
        })
    }

    // Deletion Status Toast
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Video removed successfully',
        showConfirmButton: false,
        timer: 3000
    });
    <?php endif; ?>
    </script>
</body>
</html>