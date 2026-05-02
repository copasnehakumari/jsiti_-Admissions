<?php
include "../db.php"; 

// Delete Query Logic
if (isset($_GET['delete_id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM contact_queries WHERE id = $id");
    header("Location: admin_queries.php"); 
    exit();
}

$sql = "SELECT * FROM contact_queries ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Student Enquiries</title>
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #042954;
            --main-bg: #f4f7fe;
            --text-muted: #64748b;
            --sidebar-width: 280px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background: var(--main-bg); color: #1e293b; min-height: 100vh; }

        .main-wrapper { margin-left: var(--sidebar-width); padding: 40px; }

        .admin-card {
            background: #fff; padding: 25px; border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #f1f5f9;
        }

        .table-responsive { overflow-x: auto; border-radius: 12px; }
        .query-table { width: 100%; border-collapse: separate; border-spacing: 0; min-width: 1000px; }
        
        .query-table th {
            text-align: left; padding: 16px 20px; background: #f8fafc;
            color: var(--primary); font-size: 13px; font-weight: 700;
            text-transform: uppercase; border-bottom: 2px solid #edf2f7;
        }

        .query-table td { padding: 18px 20px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }

        .btn-delete {
            background: #fff1f2; color: #ef4444; border: 1px solid #fee2e2;
            padding: 8px 16px; border-radius: 10px; font-size: 13px;
            font-weight: 700; cursor: pointer; display: inline-flex;
            align-items: center; gap: 8px; transition: 0.3s all; text-decoration: none;
        }

        .btn-delete:hover {
            background: #ef4444; color: #fff; transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(239, 68, 68, 0.3); animation: shake 0.4s ease-in-out;
        }

        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            50% { transform: translateX(4px); }
            75% { transform: translateX(-4px); }
            100% { transform: translateX(0); }
        }

        .msg-content {
            background: #f9fafb; padding: 10px 15px; border-radius: 10px;
            border-left: 3px solid #e2e8f0; font-size: 14px;
        }

        .phone-badge {
            background: #ecfdf5; color: #059669; padding: 4px 10px;
            border-radius: 6px; font-size: 13px; font-weight: 700;
            display: inline-block; text-decoration: none;
        }

        @media (max-width: 1024px) { .main-wrapper { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

    <?php include "sidebar.php" ?>

    <main class="main-wrapper">
        <header style="margin-bottom: 30px;">
            <h1 style="color: var(--primary); font-weight: 800; font-size: 28px;">Enquiry Management</h1>
            <p style="color: var(--text-muted);">Manage student queries with real-time actions.</p>
        </header>

        <div class="admin-card">
            <div class="table-responsive">
                <table class="query-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Student Details</th>
                            <th>Phone Number</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th style="text-align: center;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo isset($row['date_sent']) ? date('d M, Y', strtotime($row['date_sent'])) : 'N/A'; ?></td>
                                
                                <td>
                                    <strong><?php echo htmlspecialchars($row['name']); ?></strong><br>
                                    <small style="color: var(--text-muted);"><?php echo htmlspecialchars($row['email']); ?></small>
                                </td>

                                <td>
                                    <a href="tel:<?php echo $row['phone']; ?>" class="phone-badge">
                                        <i class="fa-solid fa-phone" style="font-size: 11px;"></i> 
                                        <?php echo htmlspecialchars($row['phone']); ?>
                                    </a>
                                </td>

                                <td>
                                    <span style="background:#fff8e1; color:#d97706; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:700;">
                                    <?php echo htmlspecialchars($row['subject']); ?></span>
                                </td>

                                <td><div class="msg-content"><?php echo htmlspecialchars($row['message']); ?></div></td>

                                <td style="text-align: center;">
                                    <button onclick="confirmDelete(<?php echo $row['id']; ?>)" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center; padding: 50px;">No messages found.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Kyu, pakka delete karna hai?',
            text: "Delete hone ke baad ye wapas nahi aayega!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Haan, uda do!',
            cancelButtonText: 'Nahi, rehne do'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "admin_queries.php?delete_id=" + id;
            }
        })
    }
    </script>

</body>
</html>