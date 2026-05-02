<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css">

<style>
    :root {
        --primary: #002147;      /* Oxford Blue */
        --accent: #ffc107;       /* Amber Gold */
        --bg-light: #f8fafc;
        --sidebar-w: 280px;
        --topbar-h: 70px;
        --text-muted: rgba(255,255,255,0.5);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }

    body { background-color: var(--bg-light); }

    /* Sidebar Styling */
    .sidebar {
        width: var(--sidebar-w);
        height: 100vh;
        background: var(--primary);
        color: white;
        position: fixed;
        left: 0; top: 0;
        transition: var(--transition);
        z-index: 1100;
        box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        overflow-y: auto;
    }

    .sidebar.collapsed { left: calc(-1 * var(--sidebar-w)); }

    .sidebar-header {
        padding: 25px 20px;
        background: rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid rgba(255,255,255,0.05);
    }

    .logo-box {
        background: var(--accent);
        color: var(--primary);
        font-weight: 800;
        padding: 8px 12px;
        border-radius: 10px;
        font-size: 18px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .brand-text .main-name { display: block; font-weight: 700; font-size: 16px; letter-spacing: 0.5px; }
    .brand-text .location { font-size: 10px; color: var(--accent); text-transform: uppercase; font-weight: 600; }

    .nav-label {
        padding: 25px 25px 10px;
        font-size: 11px;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 1.5px;
        font-weight: 600;
    }

    .nav-links { list-style: none; padding: 0; margin: 0; }
    .nav-links a {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 14px 25px;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: var(--transition);
        border-left: 4px solid transparent;
    }

    .nav-links a i { width: 20px; text-align: center; font-size: 18px; }

    .nav-links a:hover, .nav-links a.active {
        background: rgba(255,255,255,0.08);
        color: white;
        border-left-color: var(--accent);
    }

    .logout-section { 
        margin-top: 20px; 
        border-top: 1px solid rgba(255,255,255,0.05);
        padding-bottom: 30px;
    }
    
    .logout-section a:hover { color: #ff5e57; border-left-color: #ff5e57; }

    /* Top Bar Styling */
    .top-bar {
        height: var(--topbar-h);
        background: white;
        margin-left: var(--sidebar-w);
        padding: 0 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 1000;
        transition: var(--transition);
    }

    .top-bar.full-width { margin-left: 0; }

    .toggle-btn { 
        cursor: pointer; 
        font-size: 20px; 
        color: var(--primary); 
        background: #f1f5f9;
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 8px;
    }

    .top-bar-right { display: flex; align-items: center; gap: 20px; }
    
    .college-tag {
        font-size: 13px;
        font-weight: 600;
        color: #64748b;
        background: #f1f5f9;
        padding: 6px 15px;
        border-radius: 50px;
    }

    .user-profile {
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
    }

    .user-profile img {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        border: 2px solid var(--accent);
    }

    @media (max-width: 992px) {
        .sidebar { left: -280px; }
        .sidebar.active { left: 0; }
        .top-bar { margin-left: 0 !important; }
    }

    .sidebar::-webkit-scrollbar { width: 0; }
</style>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-box">JS</div>
        <div class="brand-text">
            <span class="main-name">JS PVT ITI</span>
            <span class="location">Varanasi, UP</span>
        </div>
    </div>
    
    <ul class="nav-links">
        <li class="nav-label">Overview</li>
        <li>
            <a href="dashboard.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Admin Dashboard</span>
            </a>
        </li>
        
        <li class="nav-label">College Management</li>
        <li>
            <a href="view_courses.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'view_courses.php') ? 'active' : ''; ?>">
                <i class="fas fa-graduation-cap"></i>
                <span>Manage Courses</span>
            </a>
        </li>
        <li>
            <a href="admin_view.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'admin_view.php') ? 'active' : ''; ?>">
                <i class="fas fa-users-cog"></i>
                <span>Trade Records</span>
            </a>
        </li>
        
        <li class="nav-label">Digital Assets</li>
        <li>
            <a href="add_trade_images.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'add_trade_images.php') ? 'active' : ''; ?>">
                <i class="fas fa-images"></i>
                <span>Photo Gallery</span>
            </a>
        </li>
        <li>
            <a href="add_trade_videos.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'add_trade_videos.php') ? 'active' : ''; ?>">
                <i class="fas fa-video"></i>
                <span>Video Tutorials</span>
            </a>
        </li>

        <li class="nav-label">Communication</li>
        <li>
            <a href="admin_queries.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'admin_queries.php') ? 'active' : ''; ?>">
                <i class="fas fa-envelope-open-text"></i>
                <span>Contact Enquiries</span>
            </a>
        </li>
        <li>
            <a href="enquiry_list.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'enquiry_list.php') ? 'active' : ''; ?>">
                <i class="fas fa-user-graduate"></i>
                <span>Student Enquiries</span>
            </a>
        </li>
        <li>
            <a href="view_leadership.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'view_leadership.php') ? 'active' : ''; ?>">
                <i class="fas fa-user-tie"></i>
                <span>Leadership Team</span>
            </a>
        </li>

        <li class="nav-label">Site Settings</li>
        <li>
            <a href="manage_slider.php" class="<?= (basename($_SERVER['PHP_SELF']) == 'manage_slider.php') ? 'active' : ''; ?>">
                <i class="fas fa-sliders-h"></i> 
                <span>Manage Sliders</span> 
            </a>
        </li>

        <li class="logout-section">
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                <span>Secure Logout</span>
            </a>
        </li>
    </ul>
</div>

<div class="top-bar" id="topbar">
    <div class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="top-bar-right">
        <div class="college-tag">
            <i class="fas fa-university"></i> JS ITI Varanasi
        </div>
        <div class="user-profile">
            <div style="text-align: right; line-height: 1">
                <span style="display:block; font-size:14px; font-weight:600; color:var(--primary)">Admin Panel</span>
                <small style="font-size:11px; color:#64748b">Verified Manager</small>
            </div>
            <img src="https://ui-avatars.com/api/?name=JS+ITI&background=002147&color=fff" alt="Admin">
        </div>
    </div>
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const main = document.querySelector('.main-content') || document.querySelector('.main-wrapper');
        
        if (window.innerWidth > 992) {
            sidebar.classList.toggle('collapsed');
            topbar.classList.toggle('full-width');
            
            if (sidebar.classList.contains('collapsed')) {
                topbar.style.marginLeft = "0";
                if(main) main.style.marginLeft = "0";
            } else {
                topbar.style.marginLeft = "280px";
                if(main) main.style.marginLeft = "280px";
            }
        } else {
            sidebar.classList.toggle('active');
        }
    }
</script>