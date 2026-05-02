<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Facilities - JS ITI Varanasi</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #ffc107;
            primarye: #002e5b;
            --accent: #ff9f1c;
            --accent-hover: #e68a00;
            --text-main: #334155;
            --text-light: #64748b;
            --bg-body: #f8fafc;
            --white: #ffffff;
            --shadow-sm: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            margin: 0;
            color: var(--text-main);
            line-height: 1.6;
        }

        /* Professional Header with Glassmorphism Overlay */
        header {
            background: linear-gradient(rgba(0, 46, 91, 0.85), rgba(0, 20, 40, 0.9)), 
                        url('image/maxresdefault.jpg') center/cover;
            color: white;
            padding: clamp(80px, 15vh, 120px) 20px;
            text-align: center;
            clip-path: polygon(0 0, 100% 0, 100% 90%, 0% 100%);
            margin-bottom: 40px;
        }

        header h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            font-weight: 800;
            margin: 0 auto 15px;
            text-transform: uppercase;
            letter-spacing: -1px;
            max-width: 900px;
        }

        header p {
            font-size: clamp(1rem, 2vw, 1.25rem);
            opacity: 0.9;
            font-weight: 300;
        }

        .container {
            max-width: 1200px;
            margin: -80px auto 60px;
            padding: 0 20px;
        }

        /* Improved Grid for Better Responsiveness */
        .facility-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }

        .facility-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            border: 1px solid rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }

        .facility-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .img-container {
            height: 240px;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s ease;
        }

        .facility-card:hover .img-container img {
            transform: scale(1.1);
        }

        .icon-badge {
            position: absolute;
            bottom: -20px;
            right: 25px;
            width: 55px;
            height: 55px;
            background: var(--accent);
            color: white;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 8px 15px rgba(255, 159, 28, 0.4);
            z-index: 2;
            border: 3px solid var(--white);
        }

        .content {
            padding: 35px 25px 25px;
            flex-grow: 1;
        }

        .content h2 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primarye);
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .content p {
            font-size: 0.95rem;
            color: var(--text-light);
            margin: 0;
        }

        /* CTA Box Optimization */
        .cta-box {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-radius: 24px;
            padding: clamp(40px, 8vw, 60px) 30px;
            text-align: center;
            color: var(--white);
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow-lg);
            margin-top: 40px;
        }

        .cta-box h2 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
            margin-bottom: 20px;
            font-weight: 800;
            line-height: 1.2;
        }

        .cta-box span {
            color: var(--accent);
        }

        .cta-box p {
            font-size: clamp(1rem, 1.5vw, 1.15rem);
            color: #cbd5e1;
            max-width: 750px;
            margin: 0 auto 35px;
        }

        .btn-apply {
            background: var(--accent);
            color: var(--white);
            padding: 16px 38px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            transition: var(--transition);
            font-size: 1.05rem;
            border: none;
            cursor: pointer;
        }

        .btn-apply:hover {
            background: var(--accent-hover);
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(255, 159, 28, 0.4);
        }

        /* Tablet & Mobile Tweaks */
        @media (max-width: 768px) {
            header {
                clip-path: polygon(0 0, 100% 0, 100% 95%, 0% 100%);
                padding: 60px 20px 80px;
            }
            .container {
                margin-top: -40px;
            }
            .facility-grid {
                grid-template-columns: 1fr; /* Single column for mobile */
                gap: 20px;
            }
            .icon-badge {
                width: 50px;
                height: 50px;
                font-size: 20px;
            }
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

<header>
    <h1>Campus Infrastructure</h1>
    <p>JS ITI Pvt Palahipatti, Varanasi - Best-in-class Facilities</p>
</header>

<div class="container">
    <div class="facility-grid">
        
        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 20267-04-15 at 1.49.43 AM.jpeg" alt="Digital Classroom">
                <div class="icon-badge"><i class="fas fa-chalkboard-user"></i></div>
            </div>
            <div class="content">
                <h2>Digital Classrooms</h2>
                <p>Our classrooms make learning interesting with interactive smart boards and modern visual aids.</p>
            </div>
        </div>

        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 2026-04-15 at 1.49.10 AM.jpeg" alt="Computer Lab">
                <div class="icon-badge"><i class="fas fa-laptop-code"></i></div>
            </div>
            <div class="content">
                <h2>Advanced Computer Lab</h2>
                <p>Equipped with high-speed internet and the latest software, our lab helps students upgrade their technical skills.</p>
            </div>
        </div>

        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 2026-04-15 at 1.50.19 AM.jpeg" alt="Workshop">
                <div class="icon-badge"><i class="fas fa-tools"></i></div>
            </div>
            <div class="content">
                <h2>Modern Workshop</h2>
                <p>Our workshops provide hands-on practical experience using industrial-grade tools and equipment.</p>
            </div>
        </div>

        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 2026-04-15 at 1.49.43 AM.jpeg" alt="Library">
                <div class="icon-badge"><i class="fas fa-book-reader"></i></div>
            </div>
            <div class="content">
                <h2>Central Library</h2>
                <p>We offer a vast collection of thousands of technical books and digital e-learning resources to support research.</p>
            </div>
        </div>

        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 2026-04-15 at 1.49.09 AM.jpeg" alt="Skill Lab">
                <div class="icon-badge"><i class="fas fa-lightbulb"></i></div>
            </div>
            <div class="content">
                <h2>Specialized Skill Labs</h2>
                <p>Dedicated labs for every field, including Beautician and Technical labs, providing real-world industry training.</p>
            </div>
        </div>

        <div class="facility-card">
            <div class="img-container">
                <img src="image/WhatsApp Image 2026-04-15 at 1.50.05 AM.jpeg" alt="Campus">
                <div class="icon-badge"><i class="fas fa-building"></i></div>
            </div>
            <div class="content">
                <h2>Campus</h2>
                <p>A lush green modern campus designed with a focus on student security and overall comfort.</p>
            </div>
        </div>

    </div> <div class="cta-box">
        <h2>Don't Just Dream of Success, <span>Build It.</span></h2>
        <p>
            At <b>JS Pvt ITI College</b>, we don't just provide certificates; we forge skills that last a lifetime. 
            Join a community of innovators and expert technicians. Your future is in your hands—start shaping it today!
        </p>
        <a href="addmistion.php" class="btn-apply">
            Start Your Admission  <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<?php include "footer.php"; ?>

</body>
</html>