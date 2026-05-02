<?php
include "../db.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);

$data = mysqli_fetch_assoc(
    mysqli_query($conn,"SELECT * FROM courses WHERE id='$id'")
);

$update_status = false;

if(isset($_POST['update'])){
    $name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);

    $q = "UPDATE courses SET 
          course_name='$name',
          description='$desc'
          WHERE id='$id'";

    if(mysqli_query($conn, $q)){
        $update_status = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course | ITI Admin Panel</title>
    
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
            transition: all 0.3s ease;
        }

        /* --- Navigation --- */
        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 550px; margin: 0 auto 25px;
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 10px 18px; background: #fff; border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: 0.3s;
        }

        .btn-back:hover { background: var(--primary); color: #fff; transform: translateX(-5px); }

        /* --- Professional Compact Card --- */
        .form-card {
            background: #fff; 
            max-width: 550px; 
            margin: 0 auto;
            padding: 40px; 
            border-radius: 30px;
            box-shadow: 0 25px 50px -12px rgba(0, 33, 71, 0.08);
            border: 1px solid rgba(0,0,0,0.02);
            position: relative; overflow: hidden;
        }

        /* ITI Decorative Accent */
        .form-card::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 6px;
            background: var(--accent);
        }

        .form-header h2 { font-size: 26px; font-weight: 800; color: var(--primary); margin-bottom: 8px; }
        .form-header p { color: #64748b; margin-bottom: 35px; font-size: 14px; }

        /* --- Inputs --- */
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
            box-shadow: 0 10px 20px rgba(0,33,71,0.05);
        }

        /* --- Update Button --- */
        .btn-update {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 18px; border: none; border-radius: 15px;
            font-size: 16px; font-weight: 800; cursor: pointer;
            box-shadow: 0 15px 30px rgba(0, 33, 71, 0.2);
            display: flex; align-items: center; justify-content: center; gap: 10px;
            transition: 0.4s;
        }

        .btn-update:hover {
            transform: translateY(-3px);
            box-shadow: 0 20px 40px rgba(0, 33, 71, 0.3);
            filter: brightness(1.15);
        }

        /* --- Responsive --- */
        @media (max-width: 1024px) {
            .main-content { margin-left: 0; padding: 25px 15px; }
            :root { --sidebar-w: 0px; }
            .form-card { padding: 30px 20px; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-nav">
            <a href="view_courses.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Courses
            </a>
            <div style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 5px 12px; border-radius: 20px;">
                EDITING COURSE #<?php echo $id; ?>
            </div>
        </div>

        <div class="form-card">
            <div class="form-header">
                <h2>Update Course</h2>
                <p>Modify course name and syllabus details.</p>
            </div>

            <form method="POST">
                <div class="input-group">
                    <label><i class="fas fa-book-open"></i> Course Name</label>
                    <input type="text" name="course_name" class="form-control" value="<?php echo $data['course_name']; ?>" required>
                </div>

                <div class="input-group">
                    <label><i class="fas fa-align-left"></i> Description</label>
                    <textarea name="description" class="form-control" style="min-height: 150px; resize: none;" required><?php echo $data['description']; ?></textarea>
                </div>

                <button type="submit" name="update" class="btn-update">
                    <i class="fas fa-sync-alt"></i> SAVE CHANGES
                </button>
            </form>
        </div>
    </div>

    <?php if($update_status): ?>
    <script>
        Swal.fire({
            title: 'Updated Successfully!',
            text: 'The course information has been saved.',
            icon: 'success',
            confirmButtonColor: '#002147',
            timer: 2000,
            timerProgressBar: true
        }).then(() => {
            window.location.href = 'view_courses.php';
        });
    </script>
    <?php endif; ?>

</body>
</html>