<?php
include "../db.php";

// Image Upload Logic (Professional Handling)
if(isset($_POST['upload_slider'])) {
    $target_dir = "../image/slider/";
    if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
    
    $file_extension = pathinfo($_FILES["slider_image"]["name"], PATHINFO_EXTENSION);
    $file_name = "slider_" . time() . "." . $file_extension;
    $target_file = $target_dir . $file_name;

    // Check if it's an actual image
    $check = getimagesize($_FILES["slider_image"]["tmp_name"]);
    if($check !== false) {
        if (move_uploaded_file($_FILES["slider_image"]["tmp_name"], $target_file)) {
            $db_path = "image/slider/" . $file_name;
            // Using prepared statements for security
            $stmt = $conn->prepare("INSERT INTO slider_images (image_path) VALUES (?)");
            $stmt->bind_param("s", $db_path);
            $stmt->execute();
            $success = "Slider image uploaded successfully!";
        }
    } else {
        $error = "File is not an image.";
    }
}

// Delete Logic with Confirmation
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("SELECT image_path FROM slider_images WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($row = $result->fetch_assoc()) {
        $full_path = "../".$row['image_path'];
        if(file_exists($full_path)) { unlink($full_path); }
        
        $del_stmt = $conn->prepare("DELETE FROM slider_images WHERE id=?");
        $del_stmt->bind_param("i", $id);
        $del_stmt->execute();
        header("location: manage_slider.php?msg=deleted");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Slider - JS ITI</title>
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --primary: #002147; --accent: #ffc107; }
        body { background: #f4f7f6; font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.3s; }
        
        /* Sidebar spacing adjustment */
        .main-wrapper { margin-left: 280px; transition: 0.3s; padding: 20px; }
        
        @media (max-width: 992px) { .main-wrapper { margin-left: 0; } }

        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden; }
        .upload-box { background: #fff; padding: 30px; margin-bottom: 30px; border-top: 4px solid var(--primary); }
        .slider-img { width: 120px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
        .btn-delete { color: #dc3545; background: #fff1f2; border: none; padding: 10px; border-radius: 8px; transition: 0.3s; display: inline-block; text-decoration: none; }
        .btn-delete:hover { background: #dc3545; color: white; transform: translateY(-2px); }
        .table thead th { background: var(--primary); color: white; border: none; padding: 15px; font-weight: 500; }
        .table { vertical-align: middle; }
        .text-primary { color: var(--primary) !important; }
        .btn-primary { background: var(--primary); border: none; }
        .btn-primary:hover { background: #001630; }
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-wrapper">
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="fw-bold text-primary m-0"><i class="fas fa-images me-2"></i>Slider Management</h3>
                    <a href="dashboard.php" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>

                <div class="card upload-box mb-4">
                    <h5 class="mb-3 fw-semibold">Upload New Slider Image</h5>
                    
                    <?php if(isset($success)): ?>
                        <script>Swal.fire('Success', '<?= $success ?>', 'success');</script>
                    <?php endif; ?>
                    
                    <?php if(isset($error)): ?>
                        <script>Swal.fire('Error', '<?= $error ?>', 'error');</script>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data" class="row g-3">
                        <div class="col-md-9">
                            <input type="file" name="slider_image" class="form-control form-control-lg" accept="image/*" required>
                            <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i> Recommended: 1920x600px | Formats: JPG, PNG, WEBP</div>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="submit" name="upload_slider" class="btn btn-primary btn-lg">
                                <i class="fas fa-cloud-upload-alt me-2"></i>Upload Now
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th width="150">Preview</th>
                                    <th>File Path</th>
                                    <th width="100" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sliders = mysqli_query($conn, "SELECT * FROM slider_images ORDER BY id DESC");
                                if(mysqli_num_rows($sliders) > 0) {
                                    while($row = mysqli_fetch_assoc($sliders)) {
                                        echo "<tr>
                                                <td>
                                                    <a href='../{$row['image_path']}' target='_blank'>
                                                        <img src='../{$row['image_path']}' class='slider-img shadow-sm'>
                                                    </a>
                                                </td>
                                                <td>
                                                    <code class='text-primary small'>{$row['image_path']}</code>
                                                </td>
                                                <td class='text-center'>
                                                    <button onclick=\"confirmDelete({$row['id']})\" class='btn-delete'>
                                                        <i class='fas fa-trash-alt'></i>
                                                    </button>
                                                </td>
                                              </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='3' class='text-center py-5 text-muted'>
                                            <i class='fas fa-folder-open fa-3x mb-3 d-block'></i>
                                            No slider images found.
                                          </td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// SweetAlert Delete Confirmation
function confirmDelete(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '?delete=' + id;
        }
    })
}

// Handle msg from URL
const urlParams = new URLSearchParams(window.location.search);
if(urlParams.get('msg') === 'deleted') {
    Swal.fire('Deleted!', 'Slider image has been removed.', 'success');
    // Remove msg from URL without refreshing
    window.history.replaceState({}, document.title, window.location.pathname);
}
</script>

</body>
</html>