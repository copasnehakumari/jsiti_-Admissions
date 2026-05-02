<?php

session_start();
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();
}
include"../db.php";





// 3. Courses count
$course_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM courses");
$course_count = ($course_result) ? $course_result->fetch_assoc()['total'] : 0;

// 4. Trades count
$trade_result = mysqli_query($conn, "SELECT COUNT(*) as total FROM trades");
$trade_count = ($trade_result) ? $trade_result->fetch_assoc()['total'] : 0;

// 5. Media count (Images + Videos)
$img_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM trade_images");
$vid_res = mysqli_query($conn, "SELECT COUNT(*) as total FROM trade_videos");

$img_count = ($img_res) ? $img_res->fetch_assoc()['total'] : 0;
$vid_count = ($vid_res) ? $vid_res->fetch_assoc()['total'] : 0;

$media_count = $img_count + $vid_count;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Admin Hub | JS ITI Varanasi</title>
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
            --card-shadow: 0 10px 30px rgba(0, 33, 71, 0.05);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { 
            background: var(--bg-soft); 
            color: #1e293b; 
            overflow-x: hidden;
        }

        /* Smooth Transition for all elements */
        * { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }

        .main-content { 
            margin-left: var(--sidebar-w); 
            padding: 30px; 
            min-height: 100vh;
        }

        /* --- Modern Header --- */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            padding: 20px 30px;
            border-radius: 24px;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: var(--card-shadow);
            margin-bottom: 35px;
            border: 1px solid rgba(255, 255, 255, 0.6);
        }

        .welcome-msg h2 {
            font-size: 26px;
            font-weight: 800;
            background: var(--gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* --- Stats Cards (Glass Effect) --- */
        .summary-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px; 
            margin-bottom: 45px;
        }

        .summary-card {
            background: #ffffff; 
            padding: 28px; 
            border-radius: 24px;
            display: flex; 
            justify-content: space-between; 
            align-items: center;
            box-shadow: var(--card-shadow);
            border: 1px solid transparent;
        }

        .summary-card:hover {
            border-color: var(--accent);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 33, 71, 0.1);
        }

        .stat-info h3 { font-size: 32px; font-weight: 800; color: var(--primary); }
        .stat-icon {
            width: 60px; height: 60px;
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
        }

        /* --- Action Hub Cards --- */
        .action-grid {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .action-card {
            background: #ffffff;
            padding: 45px 30px;
            border-radius: 35px;
            text-decoration: none;
            text-align: center;
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 1px solid #edf2f7;
        }

        .card-icon-img {
            width: 100px; height: 100px;
            margin-bottom: 25px;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.08));
        }

        .action-card::after {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: var(--gradient); z-index: -1;
            transform: translateY(100%);
            transition: 0.5s cubic-bezier(0.7, 0, 0.3, 1);
        }

        .action-card:hover::after { transform: translateY(0); }
        
        .action-card:hover .card-icon-img { 
            transform: scale(1.1) rotate(5deg) translateY(-5px); 
            filter: brightness(0) invert(1);
        }

        .action-card h4 { color: var(--primary); font-size: 22px; font-weight: 700; margin-bottom: 12px; }
        .action-card p { color: #64748b; font-size: 15px; line-height: 1.6; }
        
        .action-card:hover h4 { color: #fff; }
        .action-card:hover p { color: rgba(255,255,255,0.8); }

        /* --- Responsive Design --- */
        @media (max-width: 1100px) {
            :root { --sidebar-w: 80px; }
            .welcome-msg p { display: none; }
            .main-content { padding: 20px; }
        }

        @media (max-width: 768px) {
            :root { --sidebar-w: 0px; }
            .main-content { margin-left: 0; padding: 15px; padding-top: 80px; }
            
            .dashboard-header { 
                flex-direction: column; 
                gap: 15px; 
                text-align: center; 
                border-radius: 0 0 20px 20px;
                position: fixed; top: 0; left: 0; right: 0; z-index: 999;
                margin-bottom: 0;
            }

            .summary-grid { grid-template-columns: 1fr; }
            .action-grid { grid-template-columns: 1fr; }
            
            .action-card { padding: 35px 20px; }
        }

        /* Progress Bar style hint for Admin */
        .live-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #10b981;
            background: #ecfdf5;
            padding: 4px 12px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <header class="dashboard-header">
            <div class="welcome-msg">
                <h2>Campus Control Center</h2>
                <div class="live-indicator">
                    <i class="fas fa-circle fa-xs"></i> System Live: <?php echo date('H:i'); ?>
                </div>
            </div>
            
            <div style="display: flex; gap: 15px; align-items: center;">
                <div style="text-align: right;" class="welcome-msg">
                    <p style="font-size: 12px; color: #64748b; margin-bottom: 2px;">Logged in as</p>
                    <p style="font-weight: 700; color: var(--primary);">Super Admin</p>
                </div>
                <div style="background: var(--gradient); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-shield-halved"></i>
                </div>
            </div>
        </header>

        <div class="summary-grid">
            <div class="summary-card">
                <div class="stat-info">
                    <p style="color: #64748b; font-weight: 600; margin-bottom: 5px;">Academic Courses</p>
                    <h3><?php echo $course_count; ?></h3>
                </div>
                <div class="stat-icon" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fas fa-graduation-cap"></i>
                </div>
            </div>

            <div class="summary-card">
                <div class="stat-info">
                    <p style="color: #64748b; font-weight: 600; margin-bottom: 5px;">Available Trades</p>
                    <h3><?php echo $trade_count; ?></h3>
                </div>
                <div class="stat-icon" style="background: #ecfdf5; color: #10b981;">
                    <i class="fas fa-microchip"></i>
                </div>
            </div>

            <div class="summary-card">
                <div class="stat-info">
                    <p style="color: #64748b; font-weight: 600; margin-bottom: 5px;">Media Assets</p>
                    <h3><?php echo $media_count; ?></h3>
                </div>
                <div class="stat-icon" style="background: #fffbeb; color: #f59e0b;">
                    <i class="fas fa-images"></i>
                </div>
            </div>
        </div>

        <h3 style="margin-bottom: 30px; color: var(--primary); font-weight: 800; display: flex; align-items: center; gap: 10px;">
            <span style="width: 8px; height: 25px; background: var(--accent); border-radius: 4px;"></span>
            Management Hub
        </h3>

        <div class="action-grid">
            <a href="add_course.php" class="action-card">
                <img src="https://cdn-icons-png.flaticon.com/512/3429/3429149.png" class="card-icon-img" alt="Courses">
                <h4>Course Manager</h4>
                <p>Configure academic certifications, duration, and eligibility criteria.</p>
            </a>

            <a href="add_trade.php" class="action-card">
                <img src="https://cdn-icons-png.flaticon.com/512/902/902744.png" class="card-icon-img" alt="Trades">
                <h4>Trade Settings</h4>
                <p>Manage ITI workshop trades, departmental data, and lab heads.</p>
            </a>

            <a href="add_trade_images.php" class="action-card">
                <img src="https://cdn-icons-png.flaticon.com/512/833/833281.png" class="card-icon-img" alt="Gallery">
                <h4>Smart Gallery</h4>
                <p>Upload and organize high-resolution campus and event photographs.</p>
            </a>

            <a href="add_trade_videos.php" class="action-card">
                <img src="https://cdn-icons-png.flaticon.com/512/4406/4406124.png" class="card-icon-img" alt="Videos">
                <h4>Video Hub</h4>
                <p>Host workshop demonstrations, virtual tours, and student testimonials.</p>
            </a>
        </div>
    </div>

</body>

<script type="text/javascript">
    // Jab user back button dabayega, ye page reload kar dega
    window.onpageshow = function(event) {
        if (event.persisted) {
            window.location.reload(); 
        }
    };
</script>
</html>