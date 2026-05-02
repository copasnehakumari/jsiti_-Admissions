<?php
include "../db.php";

$message_status = "";

if(isset($_POST['submit'])){
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $short = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $full = mysqli_real_escape_string($conn, $_POST['full_desc']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $fees = mysqli_real_escape_string($conn, $_POST['fees']);
    $admission_fees = mysqli_real_escape_string($conn, $_POST['admission_fees']);

    /* Course Name Fetch */
    $getCourse = mysqli_query($conn,"SELECT course_name FROM courses WHERE id='$course_id'");
    $courseData = mysqli_fetch_assoc($getCourse);
    $trade_name = $courseData['course_name'];

    /* Image Upload Logic */
    $image = time()."_".$_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    
    if(move_uploaded_file($tmp,"../image/".$image)){
        $query = mysqli_query($conn,
        "INSERT INTO trades 
        (course_id,trade_name,short_desc,full_desc,duration,eligibility,fees,admission_fees,image)
        VALUES
        ('$course_id','$trade_name','$short','$full','$duration','$eligibility','$fees','$admission_fees','$image')"
        );

        if($query){ $message_status = "success"; }
        else { $message_status = "error"; }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Trade | ITI Admin</title>
    
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

        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 800px; margin: 0 auto 20px;
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 10px 18px; background: #fff; border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }

        /* --- Form Container --- */
        .form-card {
            background: #fff; 
            max-width: 800px; 
            margin: 0 auto;
            padding: 45px; 
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0, 33, 71, 0.06);
            border-top: 6px solid var(--accent);
        }

        .form-header h2 { font-size: 28px; font-weight: 800; color: var(--primary); }
        .form-header p { color: #64748b; margin-bottom: 35px; }

        .input-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .input-group { margin-bottom: 20px; }
        .input-group.full { grid-column: span 2; }

        .input-group label {
            display: block; font-size: 11px; font-weight: 800; color: var(--primary);
            text-transform: uppercase; margin-bottom: 8px; letter-spacing: 0.5px;
        }

        .form-control {
            width: 100%; padding: 14px 18px; border-radius: 12px;
            border: 2px solid #e2e8f0; background: #f8fafc;
            font-size: 14px; font-weight: 500; transition: 0.3s;
        }

        .form-control:focus { outline: none; border-color: var(--primary); background: #fff; }

        /* --- Custom Upload Area --- */
        .upload-box {
            border: 2px dashed #cbd5e1; border-radius: 15px;
            padding: 20px; text-align: center; cursor: pointer;
            background: #f8fafc; transition: 0.3s;
        }
        .upload-box:hover { border-color: var(--accent); background: #fffbeb; }
        
        #preview {
            width: 120px; height: 120px; object-fit: cover;
            margin-top: 15px; border-radius: 12px; display: none;
            border: 3px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn-submit {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 18px; border: none; border-radius: 15px;
            font-size: 16px; font-weight: 800; cursor: pointer;
            transition: 0.3s; margin-top: 20px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        .btn-submit:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,33,71,0.2); }

        @media (max-width: 768px) {
            .main-content { margin-left: 0; }
            :root { --sidebar-w: 0px; }
            .input-grid { grid-template-columns: 1fr; }
            .input-group.full { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-nav">
            <a href="admin_view.php" class="btn-back">
                <i class="fas fa-chevron-left"></i> Back to Trades
            </a>
            <span style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 5px 15px; border-radius: 20px;">
                NEW REGISTRATION
            </span>
        </div>

        <div class="form-card">
            <div class="form-header">
                <h2>Add Trade Details</h2>
                <p>Register a new technical trade under an existing course.</p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="input-grid">
                    <div class="input-group full">
                        <label>Target Course Category</label>
                        <select name="course_id" class="form-control" required>
                            <option value="">-- Choose Category --</option>
                            <?php
                            $result = mysqli_query($conn,"SELECT * FROM courses");
                            while($row = mysqli_fetch_assoc($result)){
                                echo "<option value='".$row['id']."'>".$row['course_name']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="input-group full">
                        <label>Short Overview (Small Card Text)</label>
                        <textarea name="short_desc" class="form-control" style="height: 80px; resize: none;" placeholder="Enter brief highlights..." required></textarea>
                    </div>

                    <div class="input-group full">
                        <label>Full Detailed Description</label>
                        <textarea name="full_desc" class="form-control" style="height: 120px; resize: none;" placeholder="Enter complete trade modules and details..." required></textarea>
                    </div>

                    <div class="input-group">
                        <label>Trade Duration</label>
                        <input type="text" name="duration" class="form-control" placeholder="e.g. 2 Years" required>
                    </div>

                    <div class="input-group">
                        <label>Minimum Eligibility</label>
                        <input type="text" name="eligibility" class="form-control" placeholder="e.g. 10th Pass" required>
                    </div>

                    <div class="input-group">
                        <label>Total Fees (₹)</label>
                        <input type="text" name="fees" class="form-control" placeholder="Annual Fees" required>
                    </div>

                    <div class="input-group">
                        <label>Admission Fees (₹)</label>
                        <input type="text" name="admission_fees" class="form-control" placeholder="One-time fee" required>
                    </div>

                    <div class="input-group full">
                        <label>Trade Representative Image</label>
                        <div class="upload-box" onclick="document.getElementById('fileInput').click()">
                            <i class="fas fa-cloud-upload-alt" style="font-size: 30px; color: var(--primary); margin-bottom: 10px;"></i>
                            <p style="font-size: 13px; font-weight: 600; color: #64748b;">Click to upload trade banner</p>
                            <input type="file" name="image" id="fileInput" accept="image/*" style="display:none" onchange="previewImg(this)" required>
                            <center><img id="preview" src="#" alt="Preview"></center>
                        </div>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn-submit">
                    <i class="fas fa-plus-circle"></i> PUBLISH NEW TRADE
                </button>
            </form>
        </div>
    </div>

    <?php if($message_status == "success"): ?>
    <script>
        Swal.fire({
            title: 'Successfully Added!',
            text: 'New trade record has been published.',
            icon: 'success',
            confirmButtonColor: '#002147'
        }).then(() => { window.location.href = 'admin_view.php'; });
    </script>
    <?php elseif($message_status == "error"): ?>
    <script>
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            icon: 'error',
            confirmButtonColor: '#002147'
        });
    </script>
    <?php endif; ?>

    <script>
        function previewImg(input) {
            const preview = document.getElementById('preview');
            const [file] = input.files;
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        }
    </script>
</body>
</html>