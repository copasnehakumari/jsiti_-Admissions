<?php
include "db.php";

if(!isset($_GET['id'])){ die("Invalid Trade ID"); }
$id = mysqli_real_escape_string($conn, $_GET['id']);

// Query fetch all trade columns including short_desc
$result = mysqli_query($conn, 
"SELECT trades.*, courses.course_name 
FROM trades 
LEFT JOIN courses 
ON trades.course_id = courses.id 
WHERE trades.course_id='$id'");

if(!$result){ die("Query Failed: ".mysqli_error($conn)); }
$trade = mysqli_fetch_assoc($result);
if(!$trade){ die("Trade Not Found"); }
?>

<?php include "navbar.php"; ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/all.min.css">

<style>
    :root {
        --primary: #ffc107;
        --secondary: #00285a;
        --accent: #f8fafc;
        --white: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --shadow: 0 10px 30px rgba(0,0,0,0.08);
        --radius: 20px;
        font-family: 'Inter', system-ui, sans-serif;
    }

    body { background-color: #f1f5f9; color: var(--text-dark); margin: 0; }
    .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }

    /* --- Header Card --- */
    .course-header {
        background: var(--white);
        border-radius: var(--radius);
        overflow: hidden;
        box-shadow: var(--shadow);
        margin-bottom: 40px;
        display: flex;
        flex-direction: row;
        min-height: 450px;
    }

    .header-img { flex: 1; position: relative; overflow: hidden; }
    .header-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s; }
    .header-img:hover img { transform: scale(1.05); }

    .header-content { flex: 1.2; padding: 50px; display: flex; flex-direction: column; justify-content: center; }
    .category-tag { 
        background: #fff9e6; color: #b48a00; padding: 6px 15px; 
        border-radius: 50px; font-weight: 700; font-size: 13px; 
        width: fit-content; margin-bottom: 15px; text-transform: uppercase;
    }

    .header-content h1 { font-size: 40px; color: var(--secondary); margin: 0 0 10px 0; line-height: 1.2; font-weight: 800; }
    
    /* New styling for Short Description */
    .short-description {
        font-size: 16px;
        color: var(--text-muted);
        margin-bottom: 25px;
        line-height: 1.6;
    }

    /* --- Info Tiles --- */
    .info-grid { 
        display: grid; 
        grid-template-columns: repeat(4, 1fr); 
        gap: 12px; 
        margin-bottom: 35px; 
    }
    .info-tile { background: var(--accent); padding: 15px; border-radius: 15px; text-align: center; border: 1px solid #e2e8f0; }
    .info-tile i { color: var(--secondary); font-size: 22px; margin-bottom: 8px; display: block; }
    .info-tile span { display: block; font-size: 11px; text-transform: uppercase; color: var(--text-muted); font-weight: 700; }
    .info-tile strong { color: var(--secondary); font-size: 14px; display: block; margin-top: 2px; }

    .apply-now-btn {
        background: var(--secondary); color: var(--white); padding: 18px 40px; 
        border-radius: 12px; text-decoration: none; font-weight: 700;
        text-align: center; font-size: 18px; transition: 0.3s;
        box-shadow: 0 8px 20px rgba(0,40,90,0.15); width: fit-content;
    }
    .apply-now-btn:hover { background: var(--primary); color: var(--secondary); transform: translateY(-3px); }

    .details-section { 
        background: var(--white); padding: 45px; border-radius: var(--radius); 
        box-shadow: var(--shadow); margin-bottom: 40px; 
    }
    .section-title { 
        font-size: 28px; color: var(--secondary); margin-bottom: 30px; 
        border-left: 6px solid var(--primary); padding-left: 20px; font-weight: 800; 
    }

    .trade-desc ul { list-style: none; padding: 0; margin: 0; }
    .trade-desc li {
        position: relative; padding-left: 35px; margin-bottom: 18px;
        font-size: 17px; line-height: 1.7; color: #475569;
    }
    .trade-desc li::before {
        content: "\f058"; font-family: "Font Awesome 6 Free"; font-weight: 900;
        position: absolute; left: 0; color: #10b981; font-size: 20px;
    }

    .career-scope-heading {
        display: block; font-size: 26px; color: var(--secondary); 
        margin: 50px 0 25px 0; font-weight: 800; border-bottom: 3px solid var(--primary);
        width: fit-content; padding-bottom: 5px;
    }

    /* --- Media Grid for Unlimited Items --- */
.media-grid { 
    display: grid; 
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Ye auto-adjust karega */
    gap: 20px; 
    padding: 10px 0;
}

.media-item { 
    border-radius: 15px; 
    overflow: hidden; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
    background: #f1f5f9; 
    height: 200px; /* Sabhi images ek size ki dikhengi */
    transition: transform 0.3s ease;
}

.media-item img { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; /* Image kategi nahi, area cover karegi */
}

.media-item:hover { 
    transform: translateY(-5px); 
}

.video-item video { 
    width: 100%; 
    height: 100%; 
    object-fit: cover; /* Video preview sahi dikhega */
    background: #000;
}
    @media (max-width: 992px) { .course-header { flex-direction: column; } .info-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 600px) { .info-grid { grid-template-columns: 1fr; } .header-content h1 { font-size: 30px; } }
</style>

<div class="container">
    <div class="course-header">
        <div class="header-img">
            <img src="image/<?php echo $trade['image']; ?>" alt="Course Image">
        </div>
        <div class="header-content">
            <span class="category-tag"><?php echo $trade['course_name']; ?></span>
            <h1><?php echo $trade['trade_name']; ?></h1>
            
            <p class="short-description">
                <?php echo $trade['short_desc']; ?>
            </p>
            
            <div class="info-grid">
                <div class="info-tile">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Duration</span>
                    <strong><?php echo $trade['duration']; ?></strong>
                </div>
                <div class="info-tile">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Eligibility</span>
                    <strong><?php echo $trade['eligibility']; ?></strong>
                </div>
                <div class="info-tile">
                    <i class="fas fa-indian-rupee-sign"></i>
                    <span>Monthly Fees</span>
                    <strong><?php echo $trade['fees']; ?></strong>
                </div>
                <div class="info-tile">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Admission Fee</span>
                    <strong><?php echo $trade['admission_fees']; ?></strong>
                </div>
            </div>

            <a href="apply.php?trade_id=<?php echo $trade['id']; ?>" class="apply-now-btn">
                Apply Online Now <i class="fas fa-arrow-right" style="margin-left:12px"></i>
            </a>
        </div>
    </div>

    <div class="details-section">
        <h2 class="section-title">Trade Overview & Training Scope</h2>
        <div class="trade-desc">
            <ul>
            <?php 
                $desc = $trade['full_desc'];
                $desc = str_replace(
                    "CAREER SCOPE & OUTCOMES (SCO)", 
                    "</ul><span class='career-scope-heading'><i class='fas fa-briefcase' style='margin-right:12px'></i>CAREER SCOPE & OUTCOMES (SCO)</span><ul>", 
                    $desc
                );

                $points = explode('.', $desc);
                foreach($points as $point) {
                    $trimmed = trim($point);
                    if(!empty($trimmed)) {
                        if (strpos($trimmed, 'career-scope-heading') !== false) {
                            echo $trimmed; 
                        } else {
                            echo "<li>" . $trimmed . ".</li>";
                        }
                    }
                }
            ?>
            </ul>
        </div>
    </div>

    <div class="details-section">
    <h2 class="section-title">Practical Workshop Gallery</h2>
    <div class="media-grid">
        <?php
        // Yahan 'id' aapka trade id hai jo GET se aa raha hai
        $img_query = mysqli_query($conn, "SELECT * FROM trade_images WHERE course_id='$id' ORDER BY id DESC");
        
        if(mysqli_num_rows($img_query) > 0){
            while($row = mysqli_fetch_assoc($img_query)){
        ?>
            <div class="media-item">
                <a href="image/<?php echo $row['image']; ?>" target="_blank">
                    <img src="image/<?php echo $row['image']; ?>" alt="Workshop Training" loading="lazy">
                </a>
            </div>
        <?php 
            }
        } else { 
            echo "<p class='text-muted'>No training images found for this trade.</p>"; 
        }
        ?>
    </div>
</div>

    <div class="details-section">
    <h2 class="section-title">Lab Demonstrations</h2>
    <div class="media-grid">
        <?php
        $vid_query = mysqli_query($conn, "SELECT * FROM trade_videos WHERE course_id='$id' ORDER BY id DESC");
        
        if($vid_query && mysqli_num_rows($vid_query) > 0){
            while($v = mysqli_fetch_assoc($vid_query)){
        ?>
            <div class="media-item video-item">
                <video controls preload="metadata">
                    <source src="video/<?php echo $v['video']; ?>" type="video/mp4">
                    Your browser does not support video.
                </video>
            </div>
        <?php 
            }
        } else { 
            echo "<p class='text-muted'>Workshop videos are being processed.</p>"; 
        }
        ?>
    </div>
</div>
</div>

<?php include "footer.php"; ?>