<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

include "../db.php";

$message_status = "";

if(isset($_POST['submit'])){
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $success_count = 0;

    foreach($_FILES['images']['name'] as $key=>$value){
        $image = time()."_".$value;
        $tmp = $_FILES['images']['tmp_name'][$key];
        $path = "../image/".$image;

        if(move_uploaded_file($tmp, $path)){
            $query = mysqli_query($conn, "INSERT INTO trade_images (course_id, image) VALUES ('$course_id', '$image')");
            if($query){ $success_count++; }
        }
    }
    
    if($success_count > 0){
        $message_status = "success";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery Upload | ITI Admin</title>
    
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
        body { background: var(--bg-soft); color: #1e293b; min-height: 100vh; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 40px 20px; 
            transition: all 0.3s;
        }

        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 650px; margin: 0 auto 25px;
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 10px 18px; background: #fff; border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .upload-card {
            background: #fff; 
            max-width: 650px; 
            margin: 0 auto;
            padding: 40px; 
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 33, 71, 0.08);
            border-top: 6px solid var(--accent);
        }

        .form-header h2 { font-size: 26px; font-weight: 800; color: var(--primary); margin-bottom: 8px; }
        .form-header p { color: #64748b; margin-bottom: 35px; font-size: 14px; }

        .input-group { margin-bottom: 25px; }
        .input-group label {
            display: block; font-size: 12px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; margin-bottom: 10px; letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%; padding: 14px 20px; border-radius: 15px;
            border: 2px solid #e2e8f0; background: #f8fafc;
            font-size: 15px; transition: 0.3s;
        }

        .form-control:focus { outline: none; border-color: var(--primary); background: #fff; }

        /* --- Multi-Image Upload Area --- */
        .drop-zone {
            border: 2px dashed #cbd5e1; border-radius: 20px;
            padding: 40px 20px; text-align: center; cursor: pointer;
            background: #f8fafc; transition: 0.3s;
        }
        .drop-zone:hover { border-color: var(--primary); background: #fff; }
        .drop-zone i { font-size: 45px; color: var(--primary); margin-bottom: 15px; }

        /* --- Preview Grid --- */
        #preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 10px; margin-top: 20px;
        }
        .preview-item {
            width: 80px; height: 80px; object-fit: cover;
            border-radius: 10px; border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn-submit {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 18px; border: none; border-radius: 15px;
            font-size: 16px; font-weight: 800; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.4s; margin-top: 15px;
        }

        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0, 33, 71, 0.2); }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; }
            :root { --sidebar-w: 0px; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-nav">
            <a href="gallery_view.php" class="btn-back">
                <i class="fas fa-images"></i> View Gallery
            </a>
            <div style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 5px 12px; border-radius: 20px;">
                MULTIPLE UPLOAD
            </div>
        </div>

        <div class="upload-card">
            <div class="form-header">
                <h2>Bulk Image Upload</h2>
                <p>Select a course and upload multiple images for the trade gallery.</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="input-group">
                    <label>Select Course</label>
                    <select name="course_id" class="form-control" required>
                        <option value="">-- Choose Category --</option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM courses");
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<option value='".$row['id']."'>".$row['course_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-group">
                    <label>Gallery Photos</label>
                    <div class="drop-zone" onclick="document.getElementById('imgInput').click()">
                        <i class="fas fa-images"></i>
                        <p style="font-weight: 600; color: #64748b;">Click to select multiple photos</p>
                        <p style="font-size: 11px; color: #94a3b8;">PNG, JPG or JPEG only</p>
                        <input type="file" name="images[]" id="imgInput" multiple accept="image/*" style="display:none" required onchange="previewImages()">
                        
                        <div id="preview-grid"></div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-cloud-upload-alt"></i> UPLOAD ALL IMAGES
                </button>
            </form>
        </div>
    </div>

    <?php if($message_status == "success"): ?>
    <script>
        Swal.fire({
            title: 'Uploaded Successfully!',
            text: '<?php echo $success_count; ?> images have been added to the gallery.',
            icon: 'success',
            confirmButtonColor: '#002147'
        });
    </script>
    <?php endif; ?>

    <script>
        function previewImages() {
            const previewGrid = document.getElementById('preview-grid');
            previewGrid.innerHTML = '';
            const files = document.getElementById('imgInput').files;

            if (files) {
                [].forEach.call(files, readAndPreview);
            }

            function readAndPreview(file) {
                if (!/\.(jpe?g|png|gif)$/i.test(file.name)) return;
                
                const reader = new FileReader();
                reader.addEventListener("load", function() {
                    const img = new Image();
                    img.className = 'preview-item';
                    img.src = this.result;
                    previewGrid.appendChild(img);
                }, false);
                reader.readAsDataURL(file);
            }
        }
    </script>

</body>
</html>