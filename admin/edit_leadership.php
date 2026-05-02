<?php 
include '../db.php'; 

// ID get karna URL se aur data fetch karna
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM leadership WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);

    if(!$data) {
        header("Location: index.php"); // Agar ID galat ho toh wapas bhej do
        exit();
    }
}

// Update Logic
if(isset($_POST['update'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $position = mysqli_real_escape_string($conn, $_POST['position']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    // Image handling logic
    if($_FILES['image']['name'] != "") {
        $image = time() . '_' . $_FILES['image']['name']; // Unique name dene ke liye time() add kiya
        $temp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($temp_name, "../image/$image");
        $img_query = ", image='$image'";
    } else {
        $img_query = ""; // Nayi image nahi hai toh purani rehne do
    }

    $update_query = "UPDATE leadership SET name='$name', position='$position', description='$description' $img_query WHERE id=$id";
    
    if(mysqli_query($conn, $update_query)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Updated!',
                    text: 'Member details have been updated successfully.',
                    icon: 'success',
                    confirmButtonColor: '#4f46e5'
                }).then(() => { window.location.href = 'view_leadership.php'; });
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Member | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #4f46e5;
            --sidebar-width: 260px;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #0f172a;
        }

        /* Sidebar ke saath alignment fixed karne ke liye */
        .main-content {
            padding: 40px 20px;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: 35px;
            max-width: 700px;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }

        .form-label {
            font-weight: 700;
            color: #64748b;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e2e8f0;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-update {
            background: var(--primary);
            color: #fff;
            border-radius: 14px;
            padding: 14px;
            width: 100%;
            border: none;
            font-weight: 700;
            font-size: 15px;
            margin-top: 20px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
        }

        .btn-update:hover {
            background: #4338ca;
            transform: translateY(-2px);
        }

        .current-img-wrapper {
            margin-top: 10px;
            padding: 10px;
            border: 1px dashed #cbd5e1;
            border-radius: 16px;
            display: inline-block;
        }

        .current-img {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
        }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; }
        }
    </style>
</head>
<body>

<?php include "sidebar.php" ?>

<div class="main-content">
    <div class="container">
        <div class="form-card">
            <div class="mb-4">
                <h2 style="font-weight: 800; color: #0f172a; letter-spacing: -1px;">Edit Member</h2>
                <p style="color: #64748b; font-size: 14px;">Update information for <b><?php echo htmlspecialchars($data['name']); ?></b></p>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($data['name']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Position / Title</label>
                        <input type="text" name="position" class="form-control" value="<?php echo htmlspecialchars($data['position']); ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Biography / Description</label>
                    <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($data['description']); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Change Profile Image</label>
                    <input type="file" name="image" class="form-control">
                    
                    <div class="current-img-wrapper mt-3">
                        <p class="mb-2" style="font-size: 11px; font-weight: 800; color: #94a3b8;">CURRENT PHOTO</p>
                        <img src="../image/<?php echo $data['image']; ?>" class="current-img" alt="current">
                    </div>
                </div>

                <button type="submit" name="update" class="btn-update">
                    <i class="fa-solid fa-check-circle me-2"></i> Save Changes
                </button>
                
                <a href="view_leadership.php" style="display: block; text-align: center; margin-top: 20px; color: #64748b; text-decoration: none; font-size: 13px; font-weight: 600;">
                    <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </form>
        </div>
    </div>
</div>

</body>
</html>