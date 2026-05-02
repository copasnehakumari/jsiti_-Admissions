<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | JS ITI Varanasi</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #ffc107;
            --primarye: #1e3a8a;
            --secondary: #2563eb;
            --accent: #f59e0b;
            --bg-light: #f8fafc;
            --text-main: #334155;
            --shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }

        /* Footer ko hamesha bottom me rakhne ke liye Flex layout */
        html, body {
            height: 100%;
        }

        body {
            background-color: var(--bg-light);
            color: var(--text-main);
            line-height: 1.6;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* --- HERO SECTION --- */
        .hero { padding: 60px 20px; background: linear-gradient(135deg, #e0e7ff 0%, #f8fafc 100%); }
        .hero-box {
            max-width: 1200px; margin: auto; display: flex; align-items: center; gap: 50px;
            background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(15px);
            border-radius: 24px; padding: 40px; box-shadow: var(--shadow); border: 1px solid rgba(255,255,255,0.3);
        }
        .hero-content { flex: 1; }
        .hero-img { flex: 1; position: relative; }
        .hero-img img { width: 100%; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); transition: transform 0.3s ease; }
        .hero-img img:hover { transform: scale(1.02); }
        .hero-content h1 { font-size: clamp(2rem, 5vw, 2.8rem); color: var(--primarye); line-height: 1.2; margin-bottom: 20px; font-weight: 800; }
        .tagline { display: inline-block; background: #dbeafe; color: var(--secondary); padding: 5px 15px; border-radius: 50px; font-weight: 700; font-size: 14px; margin-top: 20px; text-transform: uppercase; }

        /* --- MAIN CONTENT WRAPPER --- */
        .main-wrapper {
            flex: 1 0 auto; /* Yeh content ko push karega footer tak */
        }

        /* --- GENERAL SECTION STYLES --- */
        .section { max-width: 1200px; margin: auto; padding: 60px 20px; }
        .section-title { text-align: center; margin-bottom: 50px; }
        .section-title h2 { font-size: 32px; color: var(--primarye); font-weight: 700; margin-bottom: 10px; }
        .underline { width: 60px; height: 4px; background: var(--secondary); margin: auto; border-radius: 10px; }

        /* --- GRID LAYOUT --- */
        .grid-container { display: grid; grid-template-columns: 1.5fr 1fr; gap: 30px; }
        .card { background: #fff; padding: 40px; border-radius: 20px; box-shadow: var(--shadow); transition: 0.3s; }
        .intro-card { border-top: 5px solid var(--secondary); }
        .info-card { background: var(--primarye); color: white; display: flex; flex-direction: column; justify-content: center; }
        .info-card h3 { color: #fff; margin-bottom: 20px; }
        .info-list { list-style: none; }
        .info-list li { display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(255,255,255,0.1); }

        /* --- MISSION VISION --- */
        .mv-container { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin: 40px 0; }
        .mv-card { text-align: center; padding: 40px; background: white; border-radius: 20px; box-shadow: var(--shadow); }
        .icon-circle { width: 60px; height: 60px; background: #eff6ff; color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 24px; }

        /* --- LEADERSHIP SLIDER --- */
      
.slider-container {
    width: 100%;
    overflow: hidden;
    padding: 30px 0;
    position: relative;
    background: transparent;
}

.slider-track {
    display: flex;
    width: max-content; /* Ye apne aap saare cards ki width le lega */
    animation: scroll 40s linear infinite; /* Speed yahan se adjust karein */
}

@keyframes scroll {
    0% {
        transform: translateX(0);
    }
    100% {
        /* Kyunki humne items double kiye hain, toh -50% par loop repeat hoga */
        transform: translateX(-50%);
    }
}

.slider-track:hover {
    animation-play-state: paused; /* Mouse le jane par ruk jayega */
}

.member-card {
    flex-shrink: 0; /* Card ko dabne se rokta hai */
    width: 320px;
    margin: 0 15px;
    /* Baaki purani styling... */
}


        .member-card { 
            width: 320px;min-height:  320px;background: #f9fbfd; border-radius: 20px; margin: 0 15px; padding: 30px; 
            display: flex; flex-direction: column; align-items: center; text-align: center; 
            box-shadow: var(--shadow); flex-shrink: 0; border: 1px solid #edf2f7; transition: transform 0.3s ease; 
        }
        .member-card:hover { transform: translateY(-5px); }
        .member-img { width: 160px; height: 160px; border-radius: 50%; object-fit: cover; border: 5px solid #eff6ff; outline: 3px solid var(--secondary); margin-bottom: 20px; }
        .member-info h4 { color: var(--primarye); font-size: 20px; margin-bottom: 8px; font-weight: 700; }
        .member-info p { color: #64748b; font-size: 14px; line-height: 1.4; }

        /* --- FOOTER FIX --- */
        footer {
            flex-shrink: 0; /* Footer hamesha apni original height maintain karega */
            width: 100%;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 992px) {
            .hero-box { flex-direction: column-reverse; text-align: center; padding: 30px; }
            .grid-container, .mv-container { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

<div class="main-wrapper">
    <div class="hero">
        <div class="hero-box">
            <div class="hero-content">
                <span class="tagline">Leading Technical Education</span>
                <h1>Welcome to <br><span style="color: var(--secondary);">JS ITI Varanasi</span></h1>
                <p>Empowering the next generation of technicians with hands-on training and industry-standard skills. We don't just teach; we build careers.</p>
            </div>
            <div class="hero-img">
                <img src="image/WhatsApp Image 2026-04-12 at 10.17.41 PM.jpeg" alt="JS ITI Campus">
            </div>
        </div>
    </div>

    <section class="section">
        <div class="section-title">
            <h2>About Our Institute</h2>
            <div class="underline"></div>
        </div>

        <div class="grid-container">
            <div class="card intro-card">
                <h3 style="color: var(--primary); margin-bottom: 20px;">
                    <i class="fas fa-graduation-cap"></i> Shaping Futures Since 2007
                </h3>
                <p>JS ITI Varanasi was established with a vision to provide quality technical education to the youth of Uttar Pradesh. We specialize in transforming beginners into skilled professionals through a mix of rigorous theory and intensive practical sessions.</p>
                <br>
                <p>Our labs are equipped with the latest machinery, ensuring that students are familiar with the tools used in modern industries. We focus on discipline, work ethics, and technical excellence.</p>
            </div>

            <div class="card info-card">
                <h3><i class="fas fa-list-check"></i> Quick Summary</h3>
                <ul class="info-list">
                    <li><span>Established</span> <strong>2007</strong></li>
                    <li><span>Category</span> <strong>Technical / ITI</strong></li>
                    <li><span>Affiliation</span> <strong>NCVT / SCVT</strong></li>
                    <li><span>Location</span> <strong>Varanasi, UP</strong></li>
                </ul>
            </div>
        </div>

        <div class="mv-container">
            <div class="mv-card">
                <div class="icon-circle"><i class="fas fa-bullseye"></i></div>
                <h3>Our Mission</h3>
                <p>To deliver accessible and industry-relevant vocational training that enables every student to secure a dignified professional life.</p>
            </div>
            <div class="mv-card">
                <div class="icon-circle"><i class="fas fa-eye"></i></div>
                <h3>Our Vision</h3>
                <p>To become the most trusted name in skill development, fostering a community of innovative and globally competitive technicians.</p>
            </div>
        </div>

        <?php include 'db.php'; ?>

      <section>
    <div class="section-title" style="margin-top: 40px;">
        <h2>Our Leadership</h2>
        <div class="underline"></div>
    </div>

    <div class="slider-container">
       <div class="slider-track">
    <?php
    $query = "SELECT * FROM leadership";
    $result = mysqli_query($conn, $query);
    
    // Pehle saara data ek array mein le lo
    $members = [];
    while($row = mysqli_fetch_assoc($result)) {
        $members[] = $row;
    }

    // Ab loop ko 2 baar chalao (taaki slider kabhi khali na dikhe)
    for ($i = 0; $i < 2; $i++) {
        foreach($members as $row) {
    ?>
            <div class="member-card">
                <img src="image/<?php echo $row['image']; ?>" class="member-img" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="member-info">
                    <h4 style="color: #2a20e4; font-size: 1.1rem; margin-bottom: 5px; font-weight: 900; text-transform: uppercase;">
                        <?php echo htmlspecialchars($row['position']); ?>
                    </h4>
                    <h5 style="margin-bottom: 10px; color: #1e293b; font-weight: 600; font-size: 1rem;">
                        <?php echo htmlspecialchars($row['name']); ?>
                    </h5>
                    <p style="font-size: 0.85rem; color: #64748b; line-height: 1.5; font-weight: 400;">
                        <?php echo htmlspecialchars($row['description']); ?>
                    </p>
                </div>
            </div>
    <?php 
        }
    } 
    ?>
</div>
    </div>
</section>
</div> <?php include "footer.php"; ?>

</body>
</html>