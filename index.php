<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JS Pvt ITI College | Varanasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ffc107;
            --primary-gradient: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            --secondary: #00285a;
            --dark: #1a1a1a;
            --light: #f8f9fa;
            --whatsapp: #25d366;
            --call: #007bff;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0; padding: 0; box-sizing: border-box;font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body { background-color: #fff; color: #333; line-height: 1.6; }

        /* HERO SECTION */
        .hero {
            height: 100vh;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        .slide {
            position: absolute;
            width: 100%; height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transition: opacity 0.8s ease-in-out; 
            z-index: -1;
        }

        .slide.active { opacity: 1; }

        .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 40, 90, 0.9), rgba(5, 5, 5, 0.3));
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            color: white;
            padding: 0 10%;
            max-width: 900px;
        }

        .badge {
            background: var(--primary);
            color: var(--dark);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 800;
            display: inline-block;
            margin-bottom: 20px;
        }

        .title {
            font-size: clamp(32px, 5vw, 56px);
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.1;
        }

        .subtitle {
            font-size: 18px;
            margin-bottom: 35px;
            color: rgba(255,255,255,0.9);
            max-width: 600px;
        }

        .hero-btns .btn {
            padding: 15px 35px;
            border-radius: 5px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: var(--transition);
            border: none;
            cursor: pointer;
        }

        .btn-primary { background: var(--primary); color: var(--dark); margin-right: 15px; }
        .btn-primary:hover { background: #e5ac00; transform: translateY(-3px); }

        .btn-secondary { 
            background: rgba(255,255,255,0.1); 
            color: white; 
            border: 1px solid white !important;
            backdrop-filter: blur(5px);
        }

        /* SECTIONS GENERAL */
        .section { padding: 80px 10%; text-align: center; }
        .section-title { font-size: 36px; margin-bottom: 15px; position: relative; padding-bottom: 15px; }
        .section-title::after {
            content: ''; width: 80px; height: 4px; background: var(--primary);
            position: absolute; bottom: 0; left: 50%; transform: translateX(-50%);
        }

        /* GRID CONTAINER */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .feature-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: var(--transition);
            text-align: left;
            border: 1px solid #eee;
        }

        .feature-card:hover { transform: translateY(-10px); box-shadow: 0 15px 40px rgba(0,0,0,0.1); }

        .feature-img-box { width: 100%; height: 180px; overflow: hidden; position: relative; }
        .feature-img-box img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .feature-card:hover .feature-img-box img { transform: scale(1.1); }

        .feature-info { padding: 25px; }
        .feature-info i { font-size: 24px; color: var(--primary); margin-bottom: 10px; display: block; }
        .feature-info h3, .feature-info h4 { font-size: 20px; margin-bottom: 10px; color: var(--secondary); }
        .feature-info p { color: #666; font-size: 14.5px; }

        /* COURSE CARDS */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 50px;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: left;
            transition: var(--transition);
        }

        .course-card:hover { transform: translateY(-5px); }
        .course-img-wrapper { width: 100%; height: 220px; overflow: hidden; position: relative; }
        .course-card img { width: 100%; height: 100%; object-fit: cover; transition: 0.5s; }
        .course-card:hover img { transform: scale(1.1); }
        .course-info { padding: 25px; }

        /* ADMISSION SECTION */
        .admission {
            background: linear-gradient(rgba(0, 40, 90, 0.85), rgba(0, 40, 90, 0.85)), url('image/iti2.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            padding: 80px 10%;
            text-align: center;
            border-radius: 20px;
            margin: 60px 10%;
        }

        .admission-btns {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .adm-btn {
            padding: 15px 30px;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            font-size: 16px;
        }

        .adm-apply { background: var(--primary); color: var(--dark); }
        .adm-call { background: var(--call); color: white; }
        .adm-wa { background: var(--whatsapp); color: white; }
        .adm-btn:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.3); }

        .view-all-btn {
            display: inline-block;
            padding: 14px 40px;
            background: var(--secondary);
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            border-radius: 50px;
            transition: var(--transition);
            border: 2px solid var(--secondary);
            font-size: 16px;
            box-shadow: 0 10px 20px rgba(0, 40, 90, 0.15);
        }

        .view-all-btn:hover {
            background: transparent;
            color: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0, 40, 90, 0.2);
        }

        /* MODAL CSS - GLASSMORPHISM */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-box {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 40px;
            border-radius: 24px;
            max-width: 450px;
            width: 90%;
            position: relative;
            text-align: center;
            color: white;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            transform: scale(0.8);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
/* MODAL LOGO STYLING - PERFECT CIRCLE */
.modal-logo {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100px; /* Gole ka size */
    height: 100px; /* Gole ka size */
    background: white; /* Logo ke piche ka background */
    margin: 0 auto 20px auto; /* Center alignment aur niche se gap */
    border-radius: 50%; /* Isse gola banega */
    padding: 10px; /* Logo aur border ke bich ki jagah */
    box-shadow: 0 8px 20px rgba(0,0,0,0.2); /* Shadow effect */
    border: 3px solid var(--primary); /* Gold border jo primary color se match kare */
    overflow: hidden; /* Taki image gole se bahar na nikle */
}

.modal-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* Isse logo stretch nahi hoga aur gole me fit rahega */
}     .modal-overlay.active .modal-box {
            transform: scale(1);
        }

        .close-modal-btn {
            position: absolute;
            top: 15px; right: 20px;
            background: none; border: none;
            color: white; font-size: 30px;
            cursor: pointer; line-height: 1;
            opacity: 0.7;
        }
        .close-modal-btn:hover { opacity: 1; }

        .modal-content h2 {
            font-size: 32px;
            color: var(--primary);
            margin-bottom: 15px;
            font-weight: 800;
        }

        /* NEW PROFESSIONAL APPLY BUTTON */
        .modal-apply-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            margin-top: 25px;
            padding: 18px 25px;
            background: var(--primary-gradient);
            color: #000;
            text-decoration: none;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            border-radius: 12px;
            font-size: 16px;
            box-shadow: 0 10px 20px rgba(255, 193, 7, 0.3);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            border: none;
        }

        .modal-apply-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(255, 193, 7, 0.5);
        }

        /* Shine Animation */
        .modal-apply-btn::after {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.4) 50%, rgba(255,255,255,0) 100%);
            transform: skewX(-25deg);
            transition: 0.7s;
        }

        .modal-apply-btn:hover::after {
            left: 150%;
        }

        .modal-close-txt {
            display: block;
            margin-top: 20px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            transition: 0.3s;
        }
        .modal-close-txt:hover { color: #fff; }

        @media (max-width: 768px) {
            .hero-content { padding: 0 5%; text-align: center; }
            .section { padding: 60px 5%; }
            .admission { margin: 40px 5%; }
            .admission-btns { flex-direction: column; }
            .adm-btn { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

<?php include "db.php"; ?>
<?php include "navbar.php"?>

<section class="hero">
    <?php
    $slider_query = mysqli_query($conn, "SELECT * FROM slider_images ORDER BY id DESC");
    $active_class = "active"; 
    
    if(mysqli_num_rows($slider_query) > 0) {
        while($slide = mysqli_fetch_assoc($slider_query)) {
            ?>
            <div class="slide <?php echo $active_class; ?>" 
                 style="background-image:url('<?php echo $slide['image_path']; ?>');">
            </div>
            <?php
            $active_class = ""; 
        }
    } else {
        echo '<div class="slide active" style="background-image:url(\'image/default-banner.jpg\');"></div>';
    }
    ?>
    
    <div class="overlay"></div>

    <div class="hero-content">
       <span class="badge">
            Session <?php echo $fullSession ?? (date("Y") . "-" . (date("Y") + 1)); ?>
       </span>
        <h1 class="title">Practical ITI Training That Transforms Students Into Professionals</h1>
        <p class="subtitle">Join Varanasi's leading ITI and gain job-ready skills through high-tech workshops and expert faculty guidance.</p>
        
        <div class="hero-btns">
            <a href="apply.php" class="btn btn-primary">Apply Now</a>
            <a href="courses.php" class="btn btn-secondary">View Courses</a>
        </div>
    </div>
</section>

<section class="section about" style="background: var(--light);">
    <h2 class="section-title">About JS Pvt ITI College</h2>
    <p style="max-width:800px; margin: 0 auto; font-size: 18px; color: #555;">
        Located in Palhipatti, Varanasi, JS Pvt ITI College is dedicated to providing excellence in technical education, bridging the gap between classroom learning and industrial requirements.
    </p>
</section>

<section class="section">
    <h2 class="section-title">Why Choose JS Pvt ITI?</h2>
    <div class="grid-container">
        <div class="feature-card">
            <div class="feature-img-box"><img src="image/P1126792-min.jpeg" alt="Expert Faculty"></div>
            <div class="feature-info">
                <i class="fas fa-chalkboard-teacher"></i>
                <h3>Expert Trainers</h3>
                <p>Our faculty members bring years of real-world industrial expertise to ensure professional learning.</p>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-img-box"><img src="image/P1126782-min.jpeg" alt="Modern Labs"></div>
            <div class="feature-info">
                <i class="fas fa-microchip"></i>
                <h3>Modern Labs</h3>
                <p>Equipped with state-of-the-art machinery and tools for high-end practical sessions.</p>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-img-box"><img src="image/WhatsApp Image 2026-04-16 at 2.19.17 AM.jpeg"></div>
            <div class="feature-info">
                <i class="fas fa-briefcase"></i>
                <h3>Placement Support</h3>
                <p>We provide 100% placement assistance to help students start careers in top manufacturing firms.</p>
            </div>
        </div>
        <div class="feature-card">
            <div class="feature-img-box"><img src="image/WhatsApp Image 2026-04-16 at 2.20.32 AM.jpeg" alt="Fees"></div>
            <div class="feature-info">
                <i class="fas fa-wallet"></i>
                <h3>Affordable Fees</h3>
                <p>We offer quality technical education at the most competitive and student-friendly fee structure.</p>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background: #fdfdfd;">
    <h2 class="section-title">Professional Courses</h2>
    <div class="course-grid">
        <?php
        $result = mysqli_query($conn, "SELECT * FROM courses LIMIT 3");
        while($row = mysqli_fetch_assoc($result)){
        ?>
        <div class="course-card">
            <div class="course-img-wrapper">
                <img src="image/<?php echo $row['image']; ?>" alt="Course Image">
            </div>
            <div class="course-info">
                <h3><?php echo $row['course_name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <a href="trade_details.php?id=<?php echo $row['id']; ?>" style="color: var(--secondary); font-weight: bold; text-decoration: none;">
                    Learn More <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php } ?>
    </div>
    <div style="margin-top: 50px;">
        <a href="courses.php" class="view-all-btn">View All Courses <i class="fas fa-th-list"></i></a>
    </div>
</section>

<div id="admissionPopup" class="modal-overlay">
    <div class="modal-box">
        <button class="close-modal-btn" onclick="toggleModal()">&times;</button>
   <div class="modal-logo">
    <img src="image/WhatsApp Image 2026-04-12 at 10.04.14 PM.jpeg" alt="College Logo">
</div>
            <div class="badge" style="background: #fff; color: #000;">Session 2026-27</div>
            <h2>ADMISSIONS OPEN</h2>
            <p>Take the first step towards your career. Practical training with high-tech labs at JS Pvt ITI Varanasi.</p>
            
            <a href="apply.php" class="modal-apply-btn">
                Apply Online Now <i class="fas fa-paper-plane" style="margin-left: 10px;"></i>
            </a>
            
            <span class="modal-close-txt" onclick="toggleModal()">Not now, continue to website</span>
        </div>
    </div>
</div>

<section class="admission">
    <h2 style="font-size: 38px; margin-bottom: 15px;">Admissions Open 2026</h2>
    <p style="font-size: 18px; opacity: 0.9;">Take the first step towards a successful technical career. Limited seats available for the upcoming session.</p>
    <div class="admission-btns">
        <a href="tel:+91XXXXXXXXXX" class="adm-btn adm-call"><i class="fas fa-phone-alt"></i> Call Now</a>
        <a href="apply.php" class="adm-btn adm-apply"><i class="fas fa-paper-plane"></i> Apply Online</a>
        <a href="https://wa.me/91XXXXXXXXXX" class="adm-btn adm-wa"><i class="fab fa-whatsapp"></i> WhatsApp</a>
    </div>
</section>

<?php include "footer.php"?>

<script>
    // Slider Logic
    let slides = document.querySelectorAll(".slide");
    let index = 0;
    function changeSlide(){
        if(slides.length > 0) {
            slides[index].classList.remove("active");
            index = (index + 1) % slides.length;
            slides[index].classList.add("active");
        }
    }
    setInterval(changeSlide, 3500);

    // Modal Logic
    function toggleModal() {
        const modal = document.getElementById('admissionPopup');
        modal.classList.toggle('active');
    }

    // Page load ke 1.5s baad modal dikhega
    window.onload = function() {
        setTimeout(toggleModal, 1500);
    };

    // Outside click close
    window.onclick = function(event) {
        const modal = document.getElementById('admissionPopup');
        if (event.target == modal) {
            toggleModal();
        }
    }
</script>

</body>
</html>