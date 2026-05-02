<?php
include "../db.php";

$message_status = "";

if(isset($_POST['submit'])){
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    
    // Video upload logic
    $video_name = time()."_".$_FILES['video']['name'];
    $tmp = $_FILES['video']['tmp_name'];
    $folder = "../video/".$video_name;

    if(move_uploaded_file($tmp, $folder)){
        $query = "INSERT INTO trade_videos (course_id, video) VALUES ('$course_id', '$video_name')";
        if(mysqli_query($conn, $query)){
            $message_status = "success";
        } else {
            $message_status = "error";
        }
    } else {
        $message_status = "upload_fail";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Course Video | ITI Admin</title>
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #002147; /* ITI Blue */
            --accent: #fbbf24;  /* Gold */
            --bg-soft: #f4f7fe;
            --sidebar-w: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-soft); color: #1e293b; min-height: 100vh; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 40px 20px; 
            transition: all 0.3s ease;
        }

        /* --- Header Navigation --- */
        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 600px; margin: 0 auto 25px;
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 10px 18px; background: #fff; border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s;
        }

        .btn-back:hover { background: var(--primary); color: #fff; }

        /* --- Professional Upload Card --- */
        .upload-card {
            background: #fff; 
            max-width: 600px; 
            margin: 0 auto;
            padding: 40px; 
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 33, 71, 0.08);
            border-top: 6px solid var(--accent);
            position: relative;
        }

        .form-header h2 { font-size: 26px; font-weight: 800; color: var(--primary); margin-bottom: 8px; }
        .form-header p { color: #64748b; margin-bottom: 35px; font-size: 14px; }

        /* --- Form Elements --- */
        .input-group { margin-bottom: 25px; }
        .input-group label {
            display: block; font-size: 12px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%; padding: 14px 20px; border-radius: 15px;
            border: 2px solid #e2e8f0; background: #f8fafc;
            font-size: 15px; font-weight: 500; transition: 0.3s;
        }

        .form-control:focus {
            outline: none; border-color: var(--primary); background: #fff;
        }

        /* --- Video Upload Zone --- */
        .video-drop-zone {
            border: 2px dashed #cbd5e1; border-radius: 20px;
            padding: 30px; text-align: center; cursor: pointer;
            background: #f8fafc; transition: 0.3s;
        }

        .video-drop-zone:hover { border-color: var(--primary); background: #fff; }
        .video-drop-zone i { font-size: 40px; color: var(--primary); margin-bottom: 15px; }

        #videoPreview {
            width: 100%; max-height: 250px; border-radius: 15px;
            margin-top: 20px; display: none; background: #000;
        }

        /* --- Action Button --- */
        .btn-upload {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 18px; border: none; border-radius: 15px;
            font-size: 16px; font-weight: 800; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.4s; margin-top: 10px;
        }

        .btn-upload:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0, 33, 71, 0.2); }

        /* --- Responsive --- */
        @media (max-width: 1024px) {
            .main-content { margin-left: 0; padding: 25px 15px; }
            :root { --sidebar-w: 0px; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-nav">
            <a href="videos_list.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> View All Videos
            </a>
            <div style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 5px 12px; border-radius: 20px;">
                E-LEARNING PORTAL
            </div>
        </div>

        <div class="upload-card">
            <div class="form-header">
                <h2>Upload Tutorial</h2>
                <p>Select a course and upload high-quality video lectures.</p>
            </div>

            <form method="POST" enctype="multipart/form-data" id="uploadForm">
                <div class="input-group">
                    <label><i class="fas fa-graduation-cap"></i> Select Course Trade</label>
                    <select name="course_id" class="form-control" required>
                        <option value="">-- Choose Course --</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM courses");
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['course_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-video"></i> Video File</label>
                    <div class="video-drop-zone" onclick="document.getElementById('vidInput').click()">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <p style="font-weight: 600; color: #64748b;">Click to select MP4 video</p>
                        <p style="font-size: 12px; color: #94a3b8;">Max recommended size: 50MB</p>
                        <input type="file" name="video" id="vidInput" accept="video/*" style="display:none" required>
                        
                        <video id="videoPreview" controls></video>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-upload">
                    <i class="fas fa-paper-plane"></i> START UPLOAD
                </button>
            </form>
        </div>
    </div>

    <?php if($message_status == "success"): ?>
    <script>
        Swal.fire({
            title: 'Uploaded!',
            text: 'Video tutorial has been added successfully.',
            icon: 'success',
            confirmButtonColor: '#002147'
        });
    </script>
    <?php elseif($message_status == "error" || $message_status == "upload_fail"): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Failed to upload video. Please check file size or database connection.',
            icon: 'error',
            confirmButtonColor: '#002147'
        });
    </script>
    <?php endif; ?>

    <script>
        // Real-time Video Preview
        const vidInput = document.getElementById('vidInput');
        const videoPreview = document.getElementById('videoPreview');

        vidInput.onchange = function() {
            const files = this.files;
            if (files && files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    videoPreview.src = e.target.result;
                    videoPreview.style.display = 'block';
                };
                reader.readAsDataURL(files[0]);
            }
        };
    </script>

</body>
</html>