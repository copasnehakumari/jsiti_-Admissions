<?php 
include '../db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Team | Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --danger: #e11d48;
            --bg-body: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --sidebar-width: 260px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            overflow-x: hidden;
        }

        .main-content {
            padding: 40px 20px;
            margin-left: var(--sidebar-width);
            transition: all 0.3s ease;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 15px;
        }

        .page-title h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.5px;
        }

        .btn-add {
            background: var(--primary);
            color: #fff;
            padding: 12px 24px;
            border-radius: 14px;
            text-decoration: none;
            font-weight: 700;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.25);
        }

        .btn-add:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.35);
        }

        .card {
            background: #fff;
            border-radius: 24px;
            padding: 25px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        }

        .table-responsive { width: 100%; overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        th {
            background: #f1f5f9;
            padding: 18px;
            text-align: left;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--text-muted);
            letter-spacing: 1px;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 18px;
            border-bottom: 1px solid #f8fafc;
            font-size: 14px;
            vertical-align: middle;
        }

        .leader-img-wrapper {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #e2e8f0;
        }

        .leader-img { width: 100%; height: 100%; object-fit: cover; }

        .btn-delete {
            background: #fff1f2;
            color: var(--danger);
            padding: 8px 16px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #fee2e2;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background: var(--danger);
            color: #fff;
            box-shadow: 0 5px 15px rgba(225, 29, 72, 0.3);
        }

        @media (max-width: 1024px) {
            .main-content { margin-left: 0; padding: 30px 15px; }
        }

        @media (max-width: 768px) {
            .page-header { flex-direction: column; align-items: stretch; text-align: center; }
            table, thead, tbody, th, td, tr { display: block; }
            thead { display: none; }
            tr {
                margin-bottom: 20px;
                border: 1px solid #e2e8f0;
                border-radius: 18px;
                background: #fff;
                overflow: hidden;
            }
            td {
                text-align: right;
                padding: 12px 20px;
                position: relative;
                border-bottom: 1px solid #f1f5f9;
            }
            td::before {
                content: attr(data-label);
                position: absolute;
                left: 20px;
                font-weight: 800;
                color: var(--text-muted);
                text-transform: uppercase;
                font-size: 11px;
            }
            td:last-child { border-bottom: none; text-align: center; padding: 20px; }
            .leader-img-wrapper { margin-left: auto; }
        }
    </style>
</head>
<body>

<?php include "sidebar.php" ?>

<div class="main-content">
    <div class="container">
        
        <div class="page-header">
            <div class="page-title">
                <h2>Leadership Team</h2>
            </div>
            <a href="add_leadership.php" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add Member
            </a>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th> <th>Position</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th style="text-align: center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM leadership ORDER BY id DESC";
                        $result = mysqli_query($conn, $query);

                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                            <td data-label="ID">
                                <span style="background:#eef2ff; color:var(--primary); padding:4px 10px; border-radius:6px; font-weight:700; font-size:12px;">
                                    #<?php echo $row['id']; ?>
                                </span>
                            </td>
                            <td data-label="Name"><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
                            
                            <td data-label="Position"><span class="badge" style="background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;"><?php echo htmlspecialchars($row['position']); ?></span></td>
                            
                            <td data-label="Description"><?php echo substr(htmlspecialchars($row['description']), 0, 50) . '...'; ?></td>
                            
                            <td data-label="Image">
                                <div class="leader-img-wrapper">
                                    <img src="../image/<?php echo $row['image']; ?>" class="leader-img" alt="leader">
                                </div>
                            </td>
                            
                            
                            <td data-label="Action" style="text-align: center; gap: 10px; display: flex; justify-content: center;">
    <a href="edit_leadership.php?id=<?php echo $row['id']; ?>" class="btn-delete" style="background: #eff6ff; color: #2563eb; border-color: #dbeafe;">
        <i class="fa-solid fa-pen-to-square"></i> Edit
    </a>
    
    <a href="delete1.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirmDelete(event, this.href)">
        <i class="fa-solid fa-trash-can"></i> Delete
    </a>
</td>
                        </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' style='text-align:center; padding: 40px; color:var(--text-muted);'>No team members found.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(event, url) {
        event.preventDefault();
        Swal.fire({
            title: 'Kyu, Pakka delete karein?',
            text: "Delete hone ke baad ye wapas nahi milega!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Haan, Uda do!',
            cancelButtonText: 'Nahi, Rehne do'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        })
    }
</script>

</body>
</html>