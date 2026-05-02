<?php
include "../db.php";
$result = mysqli_query($conn,"SELECT * FROM courses ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses | Admin Hub</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary: #002147;
            --accent: #fbbf24;
            --gradient: linear-gradient(135deg, #002147 0%, #004a99 100%);
            --sidebar-w: 280px;
            --bg-soft: #f4f7fe;
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-soft); color: #1e293b; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 30px; 
            min-height: 100vh;
            transition: all 0.3s;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; background: var(--white); padding: 20px 30px;
            border-radius: 20px; box-shadow: 0 10px 30px rgba(0,33,71,0.05);
        }

        .page-header h2 { font-size: 24px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 12px; }

        .btn-add {
            background: var(--gradient); color: white; padding: 12px 25px;
            border-radius: 12px; text-decoration: none; font-weight: 600;
            display: flex; align-items: center; gap: 8px; box-shadow: 0 10px 20px rgba(0,33,71,0.2); transition: 0.3s;
        }

        .table-container { background: var(--white); border-radius: 24px; padding: 20px; box-shadow: 0 10px 30px rgba(0,33,71,0.05); overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 800px; }
        th { padding: 18px 15px; text-align: left; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 12px; }
        td { padding: 20px 15px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; font-size: 14px; color: #1e293b; }

        .course-img { width: 60px; height: 60px; object-fit: cover; border-radius: 12px; border: 2px solid #fff; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .id-badge { background: #f1f5f9; padding: 5px 10px; border-radius: 8px; font-weight: 700; color: var(--primary); }

        .action-btns { display: flex; gap: 10px; }
        .btn-action { padding: 8px 15px; border-radius: 10px; border: none; cursor: pointer; font-weight: 600; font-size: 13px; display: flex; align-items: center; gap: 5px; transition: 0.3s; }

        .btn-edit { background: #e0f2fe; color: #0ea5e9; text-decoration: none; }
        .btn-edit:hover { background: #0ea5e9; color: white; }

        .btn-delete { background: #fee2e2; color: #ef4444; border: none; }
        .btn-delete:hover { background: #ef4444; color: white; }

        @media (max-width: 1024px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-graduation-cap"></i> Academic Courses</h2>
            <a href="add_course.php" class="btn-add">
                <i class="fas fa-plus"></i> Add New Course
            </a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Course Details</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><span class="id-badge">#<?php echo $row['id']; ?></span></td>
                        <td>
                            <img src="../image/<?php echo $row['image']; ?>" class="course-img" alt="Course">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--primary);"><?php echo $row['course_name']; ?></div>
                            <small style="color: #64748b;">Active Program</small>
                        </td>
                        <td>
                            <p style="max-width: 300px; color: #64748b; line-height: 1.5;">
                                <?php echo substr($row['description'], 0, 80); ?>...
                            </p>
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="edit_course.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <button type="button" class="btn-action btn-delete" onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
    function confirmDelete(courseId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "Course delete hone ke baad wapas nahi aayega!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#002147', // ITI Blue
            cancelButtonColor: '#ef4444', // Red
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete.php with ID
                window.location.href = 'delete_course.php?id=' + courseId;
            }
        })
    }

    // Success Toast after redirection
    <?php if(isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });

        Toast.fire({
            icon: 'success',
            title: 'Course deleted successfully'
        });
    <?php endif; ?>
    </script>

</body>
</html>