<?php
include "../db.php";

$message_type = ""; 
$message_text = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $image = time()."_".$_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    if(move_uploaded_file($tmp,"../image/".$image)){
        $query = "INSERT INTO courses (course_name,description,image) VALUES ('$name','$desc','$image')";
        if(mysqli_query($conn, $query)){
            $message_type = "success";
            $message_text = "Course Added Successfully!";
        } else {
            $message_type = "error";
            $message_text = "Database Error: " . mysqli_error($conn);
        }
    } else {
        $message_type = "error";
        $message_text = "Failed to upload image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITI Admin | Add New Course</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #002147;
            --accent: #fbbf24;
            --sidebar-w: 280px;
            --bg-soft: #f4f7fe;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-soft); color: #1e293b; min-height: 100vh; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 40px 20px; 
            transition: all 0.3s;
        }

        /* --- Compact Top Navigation --- */
        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 550px; margin: 0 auto 20px; /* Reduced width */
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 8px 15px; background: #fff; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s;
        }

        .btn-back:hover { background: var(--primary); color: #fff; }

        /* --- Smaller Form Card --- */
        .form-card {
            background: #fff; 
            max-width: 550px; /* SIZE REDUCED HERE */
            margin: 0 auto;
            padding: 35px; /* Reduced padding for compact look */
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 33, 71, 0.06);
            border: 1px solid rgba(0,0,0,0.02);
            position: relative; overflow: hidden;
        }

        .form-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 5px;
            background: var(--accent);
        }

        .form-header h2 { font-size: 24px; font-weight: 800; color: var(--primary); margin-bottom: 5px; }
        .form-header p { color: #64748b; margin-bottom: 30px; font-size: 14px; }

        /* --- Compact Inputs --- */
        .input-group { margin-bottom: 20px; }
        .input-group label {
            display: block; font-size: 11px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%; padding: 12px 18px; border-radius: 12px;
            border: 2px solid #e2e8f0; background: #f8fafc;
            font-size: 14px; transition: 0.3s;
        }

        .form-control:focus { outline: none; border-color: var(--primary); background: #fff; }

        /* --- Small File Area --- */
        .file-drop-area {
            border: 2px dashed #cbd5e1; border-radius: 15px;
            padding: 20px; text-align: center; cursor: pointer;
            background: #f8fafc;
        }

        .file-drop-area i { font-size: 30px; color: var(--primary); margin-bottom: 10px; }

        #preview {
            width: 100px; height: 100px; object-fit: cover;
            margin-top: 15px; border-radius: 10px; display: none;
            border: 2px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-submit {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 15px; border: none; border-radius: 12px;
            font-size: 15px; font-weight: 800; cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover { transform: translateY(-2px); filter: brightness(1.1); }

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
            <a href="view_courses.php" class="btn-back">
                <i class="fas fa-chevron-left"></i> Back
            </a>
            <span style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 4px 12px; border-radius: 15px;">
                NEW TRADE
            </span>
        </div>

        <div class="form-card">
            <div class="form-header">
                <h2>Add Course</h2>
                <p>Enter trade details below.</p>
            </div>

            <form method="POST" enctype="multipart/form-data" id="courseForm">
                <div class="input-group">
                    <label>Course Name / Trade</label>
                    <input type="text" name="course_name" class="form-control" placeholder="e.g. ITI COPA" required>
                </div>

                <div class="input-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" style="min-height: 100px; resize: none;" placeholder="Syllabus overview..." required></textarea>
                </div>

                <div class="input-group">
                    <label>Course Banner</label>
                    <div class="file-drop-area" onclick="document.getElementById('imgInp').click()">
                        <i class="fas fa-image"></i>
                        <p style="font-size: 13px; font-weight: 600; color: #64748b;">Click to upload image</p>
                        <input type="file" name="image" id="imgInp" accept="image/*" style="display:none" required>
                        <center><img id="preview" src="#" alt="Preview"></center>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    PUBLISH COURSE
                </button>
            </form>
        </div>
    </div>

    <?php if($message_type != ""): ?>
    <script>
        Swal.fire({
            title: '<?php echo ($message_type == "success") ? "Success!" : "Error!"; ?>',
            text: '<?php echo $message_text; ?>',
            icon: '<?php echo $message_type; ?>',
            confirmButtonColor: '#002147'
        }).then((result) => {
            if ('<?php echo $message_type; ?>' === 'success') {
                window.location.href = 'view_courses.php';
            }
        });
    </script>
    <?php endif; ?>

    <script>
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                preview.src = URL.createObjectURL(file)
                preview.style.display = 'block'
            }
        }
    </script>

</body>
</html>