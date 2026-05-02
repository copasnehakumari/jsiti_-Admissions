<?php
include "../db.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);
$data = mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM trades WHERE id='$id'"));

$update_status = false;

if(isset($_POST['update'])){
    $short = mysqli_real_escape_string($conn, $_POST['short_desc']);
    $full = mysqli_real_escape_string($conn, $_POST['full_desc']);
    $duration = mysqli_real_escape_string($conn, $_POST['duration']);
    $eligibility = mysqli_real_escape_string($conn, $_POST['eligibility']);
    $fees = mysqli_real_escape_string($conn, $_POST['fees']);
    $admission_fees = mysqli_real_escape_string($conn, $_POST['admission_fees']);

    $q = "UPDATE trades SET 
          short_desc='$short',
          full_desc='$full',
          duration='$duration',
          eligibility='$eligibility',
          fees='$fees',
          admission_fees='$admission_fees'
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
    <title>Edit Trade | ITI Admin Panel</title>
    
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
            padding: 40px 20px; 
            transition: all 0.3s;
        }

        .top-nav {
            display: flex; align-items: center; justify-content: space-between;
            max-width: 600px; margin: 0 auto 20px;
        }

        .btn-back {
            text-decoration: none; color: var(--primary); font-weight: 700;
            display: flex; align-items: center; gap: 8px; font-size: 13px;
            padding: 8px 15px; background: #fff; border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05); transition: 0.3s;
        }

        .form-card {
            background: #fff; 
            max-width: 600px; 
            margin: 0 auto;
            padding: 35px; 
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 33, 71, 0.06);
            border-top: 5px solid var(--accent);
        }

        .form-header h2 { font-size: 24px; font-weight: 800; color: var(--primary); margin-bottom: 5px; }
        .form-header p { color: #64748b; margin-bottom: 30px; font-size: 14px; }

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

        .grid-inputs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .btn-update {
            width: 100%; background: linear-gradient(135deg, #002147 0%, #004a99 100%); 
            color: #fff; padding: 16px; border: none; border-radius: 12px;
            font-size: 15px; font-weight: 800; cursor: pointer;
            transition: 0.3s; margin-top: 10px;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        .btn-update:hover { transform: translateY(-2px); filter: brightness(1.1); }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; }
            :root { --sidebar-w: 0px; }
            .grid-inputs { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="top-nav">
            <a href="admin_view.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <span style="font-size: 11px; font-weight: 800; color: var(--accent); background: var(--primary); padding: 4px 12px; border-radius: 15px;">
                EDIT MODE
            </span>
        </div>

        <div class="form-card">
            <div class="form-header">
                <h2>Modify Trade</h2>
                <p>Update information for ID #<?php echo $id; ?></p>
            </div>

            <form method="POST">
                <div class="input-group">
                    <label>Short Description</label>
                    <textarea name="short_desc" class="form-control" style="min-height: 80px; resize: none;"><?php echo $data['short_desc']; ?></textarea>
                </div>

                <div class="input-group">
                    <label>Full Description</label>
                    <textarea name="full_desc" class="form-control" style="min-height: 120px; resize: none;"><?php echo $data['full_desc']; ?></textarea>
                </div>

                <div class="grid-inputs">
                    <div class="input-group">
                        <label>Duration</label>
                        <input type="text" name="duration" class="form-control" value="<?php echo $data['duration']; ?>">
                    </div>
                    <div class="input-group">
                        <label>Eligibility</label>
                        <input type="text" name="eligibility" class="form-control" value="<?php echo $data['eligibility']; ?>">
                    </div>
                </div>

                <div class="grid-inputs">
                    <div class="input-group">
                        <label>Course Fees (₹)</label>
                        <input type="text" name="fees" class="form-control" value="<?php echo $data['fees']; ?>">
                    </div>
                    <div class="input-group">
                        <label>Admission Fees (₹)</label>
                        <input type="text" name="admission_fees" class="form-control" value="<?php echo $data['admission_fees']; ?>">
                    </div>
                </div>

                <button name="update" class="btn-update">
                    <i class="fas fa-save"></i> UPDATE CHANGES
                </button>
            </form>
        </div>
    </div>

    <?php if($update_status): ?>
    <script>
        Swal.fire({
            title: 'Updated!',
            text: 'Trade details have been saved successfully.',
            icon: 'success',
            confirmButtonColor: '#002147'
        }).then(() => {
            window.location.href = 'admin_view.php';
        });
    </script>
    <?php endif; ?>

</body>
</html>