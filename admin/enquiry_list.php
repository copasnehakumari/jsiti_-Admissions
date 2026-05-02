<?php 
include "../db.php"; 

// Data fetch karne ki query - courses table se naam bhi fetch kar rahe hain
$query = "SELECT enquiries.*, courses.course_name 
          FROM enquiries 
          LEFT JOIN courses ON enquiries.trade_id = courses.id 
          ORDER BY enquiries.id DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Enquiries | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #00285a;
            --accent: #ffc107;
        }
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #f8fafc; 
            margin: 0;
        }
        
        /* Sidebar offset for desktop */
        .main-content {
            margin-left: 280px; /* Sidebar ki width ke barabar */
            padding: 40px;
            transition: all 0.3s;
        }

        .enquiry-container { 
            background: white; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }

        h2 { 
            color: var(--primary); 
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        h2::after {
            content: '';
            flex-grow: 1;
            height: 2px;
            background: #eee;
        }

        .table { vertical-align: middle; }
        .table thead { background: var(--primary); color: white; }
        .table thead th { border: none; padding: 15px; font-weight: 500; }
        
        .badge-trade { 
            background: var(--accent); 
            color: var(--primary); 
            padding: 6px 12px; 
            border-radius: 6px; 
            font-size: 12px; 
            font-weight: 700; 
        }

        .btn-call { 
            color: #25d366; 
            text-decoration: none; 
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .action-icons a {
            font-size: 18px;
            transition: transform 0.2s;
            display: inline-block;
        }
        .action-icons a:hover { transform: scale(1.2); }

        /* --- FULL RESPONSIVE BASE ADDITIONS --- */

/* 1. Desktop & Large Screens (Standard) */
@media (min-width: 993px) {
    .main-content {
        margin-left: 280px; /* Sidebar space */
        min-height: 100vh;
    }
}

/* 2. Tablets & Small Laptops (992px and down) */
@media (max-width: 992px) {
    .main-content {
        margin-left: 0 !important;
        padding: 20px 15px; /* Side padding kam kar di */
    }
    
    .enquiry-container {
        padding: 15px;
        border-radius: 10px;
    }
    
    h2 {
        font-size: 1.5rem;
    }
}

/* 3. Mobile Phones (576px and down) */
@media (max-width: 576px) {
    .main-content {
        padding: 10px;
    }

    /* Table text adjustment */
    .table td, .table th {
        font-size: 13px; /* Chhoti screen par font thoda chhota */
        padding: 10px 5px;
    }

    .badge-trade {
        padding: 4px 8px;
        font-size: 10px;
    }

    /* Message box ko mobile par aur chhota kiya taaki scroll na karna pade */
    .text-truncate {
        max-width: 120px !important;
    }

    /* Action icons ki spacing */
    .action-icons a {
        font-size: 16px;
        margin-right: 5px !important;
    }
}

/* 4. Table Scroll bar ko clean dikhane ke liye */
.table-responsive::-webkit-scrollbar {
    height: 5px;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: var(--accent);
    border-radius: 10px;
}
/* --- END OF RESPONSIVE BASE --- */
    </style>
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="main-content">
    <div class="enquiry-container">
        <h2><i class="fas fa-user-graduate text-warning"></i> Student Enquiries</h2>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Applied Trade</th>
                        <th>Contact info</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo ucwords($row['name']); ?></div>
                                    <small class="text-muted"><?php echo $row['email']; ?></small>
                                </td>
                                <td>
                                    <span class="badge-trade">
                                        <?php echo $row['course_name'] ?? 'Trade ID: '.$row['trade_id']; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="tel:<?php echo $row['mobile']; ?>" class="btn-call">
                                        <i class="fas fa-phone-alt"></i> <?php echo $row['mobile']; ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?php echo $row['message']; ?>">
                                        <?php echo $row['message']; ?>
                                    </div>
                                </td>
                                <td class="action-icons">
                                    <a href="mailto:<?php echo $row['email']; ?>" class="text-primary me-2" title="Send Email">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                    <a href="https://wa.me/91<?php echo $row['mobile']; ?>" target="_blank" class="text-success" title="WhatsApp Chat">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center py-5 text-muted'>No enquiries found in the records.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>