<?php
include "../db.php";

// Fetch all courses for the filter dropdown
$courses_res = mysqli_query($conn, "SELECT * FROM courses");

// Logic for filtering by course
$filter_query = "";
if(isset($_GET['course_id']) && !empty($_GET['course_id'])) {
    $c_id = mysqli_real_escape_string($conn, $_GET['course_id']);
    $filter_query = " WHERE trade_images.course_id = '$c_id' ";
}

// Fetch images with course names
$sql = "SELECT trade_images.*, courses.course_name 
        FROM trade_images 
        LEFT JOIN courses ON trade_images.course_id = courses.id 
        $filter_query 
        ORDER BY trade_images.id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trade Gallery | ITI Admin</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        /* --- Header & Filters --- */
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

        .filter-form { display: flex; gap: 10px; align-items: center; }
        
        .select-input {
            padding: 10px 15px; border-radius: 10px; border: 2px solid #e2e8f0;
            font-size: 14px; font-weight: 600; outline: none;
        }

        .btn-upload {
            background: var(--primary); color: #fff; padding: 12px 20px;
            border-radius: 12px; text-decoration: none; font-weight: 700;
            font-size: 14px; display: flex; align-items: center; gap: 8px;
        }

        /* --- Gallery Grid --- */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 25px;
        }

        .gallery-item {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
            position: relative;
            transition: 0.3s;
        }

        .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.08); }

        .image-wrapper {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .image-wrapper img {
            width: 100%; height: 100%; object-fit: cover; transition: 0.5s;
        }

        .gallery-item:hover img { scale: 1.1; }

        .item-info { padding: 15px; }
        .course-tag {
            font-size: 10px; font-weight: 800; background: #e0f2fe;
            color: #0ea5e9; padding: 4px 10px; border-radius: 20px;
            display: inline-block; margin-bottom: 8px;
        }

        /* --- Delete Overlay --- */
        .delete-btn {
            position: absolute; top: 10px; right: 10px;
            background: rgba(239, 68, 68, 0.9); color: #fff;
            width: 35px; height: 35px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; border: none; opacity: 0; transition: 0.3s;
        }

        .gallery-item:hover .delete-btn { opacity: 1; }

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
                <h2><i class="fas fa-photo-video"></i> Trade Gallery</h2>
            </div>

            <div class="filter-form">
                <form method="GET" style="display:flex; gap:10px;">
                    <select name="course_id" class="select-input" onchange="this.form.submit()">
                        <option value="">All Courses</option>
                        <?php 
                        mysqli_data_seek($courses_res, 0);
                        while($c = mysqli_fetch_assoc($courses_res)){
                            $selected = (isset($_GET['course_id']) && $_GET['course_id'] == $c['id']) ? "selected" : "";
                            echo "<option value='".$c['id']."' $selected>".$c['course_name']."</option>";
                        }
                        ?>
                    </select>
                </form>
                <a href="add_trade_images.php" class="btn-upload">
                    <i class="fas fa-plus"></i> Add More
                </a>
            </div>
        </div>

        <div class="gallery-grid">
            <?php if(mysqli_num_rows($result) > 0){ ?>
                <?php while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="gallery-item" id="item-<?php echo $row['id']; ?>">
                    <div class="image-wrapper">
                        <img src="../image/<?php echo $row['image']; ?>" alt="Gallery Image">
                        <button class="delete-btn" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                    <div class="item-info">
                        <span class="course-tag"><?php echo $row['course_name']; ?></span>
                        <p style="font-size: 11px; color: #94a3b8;"><i class="far fa-clock"></i> ID: #<?php echo $row['id']; ?></p>
                    </div>
                </div>
                <?php } ?>
            <?php } else { ?>
                <div style="grid-column: span 4; text-align: center; padding: 50px; background: #fff; border-radius: 20px;">
                    <i class="fas fa-folder-open" style="font-size: 50px; color: #cbd5e1; margin-bottom: 15px;"></i>
                    <p style="color: #64748b; font-weight: 600;">No images found in this category.</p>
                </div>
            <?php } ?>
        </div>
    </div>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Delete Image?',
            text: "Kyah aap waqai is photo ko hatana chahte hain?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#002147',
            confirmButtonText: 'Yes, Delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to a delete script for images
                window.location.href = 'delete_gallery_img.php?id=' + id;
            }
        })
    }

    // Success Toast for deletion
    <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Image removed successfully',
        showConfirmButton: false,
        timer: 3000
    });
    <?php endif; ?>
    </script>
</body>
</html>