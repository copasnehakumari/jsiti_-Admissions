<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Navbar Start -->
<style>
/* Navbar */
.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 40px;
    background:#ffffff;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    position:sticky;
    top:0;
    z-index:1000;
}

/* Logo */
.logo-area{
    display:flex;
    align-items:center;
}

.logo-area img{
    width:45px;
    height:45px;
    margin-right:10px
    bodar-radius:50%
}

.logo-area h2{
    color:#002147;
    font-size:20px;
}

/* Menu */
nav ul{
    display:flex;
    list-style:none;
}

nav ul li{
    margin-left:25px;
}

nav ul li a{
    text-decoration:none;
    color:#002147;
    font-weight:500;
    transition:0.3s;
}

nav ul li a:hover{
    color:#007bff;
}

/* Mobile Button */
.menu-toggle{
    display:none;
    font-size:25px;
    cursor:pointer;
}

/* Responsive */
@media(max-width:768px){

    nav{
    

        position:absolute;
        top:70px;
        right:0;
        width:100%;
        background:#ffffff;
        display:none;
        flex-direction:column;
        text-align:center;
    }

    nav ul{
        flex-direction:column;
    }

    nav ul li{
        margin:15px 0;
    }

    .menu-toggle{
        display:block;
    }

    nav.active{
        display:flex;
    }
}
 /* Top Bar */
        .top-bar {
            background: var(--primary);
            text-align: center;
            padding: 12px;
            font-weight: bold;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
</style>
</head>
<body>
<?php
    // Current saal nikalne ke liye
    $currentYear = date('Y');
    
    // Agla saal nikalne ke liye (2027)
    $nextYear = $currentYear + 1;
    
    // Format: 2026-2027
    $displaySession = $currentYear . "-" . $nextYear;
?>

<div class="top-bar">
    <i class="fas fa-bullhorn"></i> 
    Admissions Open <?php echo $displaySession; ?> | Limited Seats Available
</div>



<header class="navbar">

    <!-- Logo + Name -->
    <div class="logo-area">
        <img src="image/WhatsApp Image 2026-04-12 at 10.04.14 PM.jpeg" alt="Logo">
        <h2>JS Pvt ITI College</h2><br>
      
    </div>

    <!-- Mobile Menu -->
    <div class="menu-toggle" onclick="toggleMenu()">☰</div>

    <!-- Navigation -->
    <nav id="nav-menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Us</a></li>
            <li><a href="courses.php">Courses</a></li>
            <li><a href="addmistion.php">Admission</a></li>
            <li><a href="facility.php">Facilities</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>

</header>

<script>
function toggleMenu(){
    document.getElementById("nav-menu").classList.toggle("active");
}
</script>
<!-- Navbar End -->


    
</body>
</html>