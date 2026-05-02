<?php
include "../db.php";
$result = mysqli_query($conn,"SELECT * FROM trades ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trades | ITI Admin</title>
    
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
            --white: #ffffff;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--bg-soft); color: #1e293b; }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 30px; 
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        .page-header {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 30px; background: var(--white); padding: 20px 30px;
            border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }

        .page-header h2 { font-size: 24px; font-weight: 800; color: var(--primary); display: flex; align-items: center; gap: 12px; }

        .btn-add {
            background: linear-gradient(135deg, #002147 0%, #004a99 100%);
            color: white; padding: 12px 24px; border-radius: 12px; text-decoration: none;
            font-weight: 700; display: flex; align-items: center; gap: 8px; transition: 0.3s;
        }

        .table-card { background: var(--white); border-radius: 25px; padding: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; min-width: 900px; }
        th { background: #f8fafc; padding: 18px 15px; text-align: left; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 11px; border-bottom: 2px solid #f1f5f9; }
        td { padding: 18px 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; vertical-align: middle; }

        .trade-img { width: 55px; height: 55px; object-fit: cover; border-radius: 12px; border: 2px solid #fff; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .id-badge { background: #f1f5f9; padding: 5px 10px; border-radius: 8px; font-weight: 800; color: var(--primary); font-size: 12px; }
        .fee-text { font-weight: 700; color: #0f172a; }

        .action-flex { display: flex; gap: 8px; }
        .btn-action { padding: 8px 14px; border-radius: 10px; border: none; cursor: pointer; font-weight: 700; font-size: 12px; display: flex; align-items: center; gap: 6px; transition: 0.3s; }
        .btn-edit { background: #e0f2fe; color: #0ea5e9; text-decoration: none; }
        .btn-delete { background: #fee2e2; color: #ef4444; }

        @media (max-width: 1024px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="page-header">
            <h2><i class="fas fa-tools"></i> ITI Trades Management</h2>
            <a href="add_trade.php" class="btn-add">
                <i class="fas fa-plus"></i> Add New Trade
            </a>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Preview</th>
                        <th>Trade Name</th>
                        <th>Course Fees</th>
                        <th>Admission Fees</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><span class="id-badge">#<?php echo $row['id']; ?></span></td>
                        <td>
                            <img src="../image/<?php echo $row['image']; ?>" class="trade-img" alt="Trade">
                        </td>
                        <td>
                            <div style="font-weight: 700; color: var(--primary);"><?php echo $row['trade_name']; ?></div>
                            <small style="color: #64748b;">Technical Department</small>
                        </td>
                        <td>
                            <span class="fee-text"><?php echo $row['fees']; ?></span>
                        </td>
                        <td>
                            <span class="fee-text"><?php echo $row['admission_fees']; ?></span>
                        </td>
                        <td>
                            <div class="action-flex">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">
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
    // Delete Confirmation
    function confirmDelete(tradeId) {
        Swal.fire({
            title: 'KYA AAP SURE HAIN?',
            text: "Trade delete hone ke baad data wapas nahi aayega!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#002147',
            cancelButtonColor: '#ef4444',
            confirmButtonText: 'HAAN, DELETE KAREIN!',
            cancelButtonText: 'CANCEL',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete.php?id=' + tradeId;
            }
        })
    }

    // Success Toast for Deletion
    <?php if(isset($_GET['status']) && $_GET['status'] == 'deleted'): ?>
        Swal.fire({
            icon: 'success',
            title: 'DELETED!',
            text: 'Trade successfully remove ho chuka hai.',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
    </script>

</body>
</html>