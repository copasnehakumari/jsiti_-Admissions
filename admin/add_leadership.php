<?php 
include '../db.php'; 

if(isset($_POST['submit'])){
    // Name field add kiya gaya hai
    $name = mysqli_real_escape_string($conn, $_POST['name']); 
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Image Upload Logic
    $image = $_FILES['image']['name'];
    $temp = $_FILES['image']['tmp_name'];
    $folder = "../image/" . $image;

    if(move_uploaded_file($temp, $folder)){
        // Query mein 'name' column add kiya gaya hai
        $query = "INSERT INTO leadership(name, position, description, image) VALUES('$name', '$position', '$description', '$image')";
        $res = mysqli_query($conn, $query);
        
        if($res){
            $status = "success";
        } else {
            $status = "error";
        }
    } else {
        $status = "upload_fail";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Leadership | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --text-dark: #0f172a;
            --border: #e2e8f0;
            --sidebar-width: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body {
            background-color: var(--bg-body);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        .main-content {
            padding: 40px 20px;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 600px;
            background: var(--white);
            padding: 40px;
            border-radius: 24px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        .form-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .form-header h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .form-header p {
            color: #64748b;
            font-size: 14px;
            margin-top: 5px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 8px;
            color: #475569;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: #fcfdfe;
            font-size: 15px;
            transition: 0.3s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background: #fff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .file-input-wrapper {
            position: relative;
            border: 2px dashed var(--border);
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .file-input-wrapper:hover {
            border-color: var(--primary);
            background: #f5f3ff;
        }

        .btn-submit {
            width: 100%;
            background: var(--primary);
            color: #fff;
            padding: 14px;
            border-radius: 12px;
            border: none;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
        }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; }
        }

        @media (max-width: 500px) {
            .form-container { padding: 25px; }
            .form-header h2 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

<?php include "sidebar.php" ?>

<div class="main-content">
    <div class="form-container">
        <div class="form-header">
            <h2>Add New Leader</h2>
            <p>Enter details to add a new leadership member</p>
        </div>

        <form method="post" enctype="multipart/form-data">
            
            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Full Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Arbind Kumar Singh" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-id-badge"></i> Position</label>
                <input type="text" name="position" class="form-control" placeholder="e.g. CEO, Principal, Web Developer" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-align-left"></i> Description</label>
                <textarea name="description" class="form-control" placeholder="Write a short bio or description..." required></textarea>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-image"></i> Member Image</label>
                <div class="file-input-wrapper">
                    <input type="file" name="image" id="imageInput" accept="image/*" required style="cursor:pointer;">
                    <p style="font-size: 12px; color: #94a3b8; margin-top: 5px;">JPG, PNG or WEBP (Max 2MB)</p>
                </div>
            </div>

            <button type="submit" name="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Save Member Details
            </button>

            <a href="view_leadership.php" style="display:block; text-align:center; margin-top:20px; color:#64748b; text-decoration:none; font-size:13px; font-weight:600;">
                <i class="fa-solid fa-arrow-left"></i> Back to List
            </a>

        </form>
    </div>
</div>

<?php if(isset($status)): ?>
<script>
    <?php if($status == "success"): ?>
        Swal.fire({
            icon: 'success',
            title: 'Added Successfully!',
            text: 'New leader has been added to the team.',
            confirmButtonColor: '#4f46e5'
        }).then(() => { window.location.href = 'view_leadership.php'; });
    <?php elseif($status == "error"): ?>
        Swal.fire({ icon: 'error', title: 'Oops...', text: 'Database error occurred!' });
    <?php elseif($status == "upload_fail"): ?>
        Swal.fire({ icon: 'error', title: 'Upload Failed', text: 'Please check image folder permissions.' });
    <?php endif; ?>
</script>
<?php endif; ?>

</body>
</html>