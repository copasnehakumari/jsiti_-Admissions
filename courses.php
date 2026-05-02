<?php
// Database Connection
include "db.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Courses | JS Pvt ITI College</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        :root {
            --primary: #ffc107; /* Gold/Warning */
            --secondary: #00285a; /* Professional Navy Blue */
            --accent: #0056b3;
            --text-main: #2d3436;
            --text-muted: #636e72;
            --bg-body: #f4f7f6;
            --white: #ffffff;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-body);
            color: var(--text-main);
            line-height: 1.6;
        }

        .section {
            padding: 80px 10%;
            text-align: center;
        }

        .section-title {
            font-size: 38px;
            margin-bottom: 50px;
            color: var(--secondary);
            font-weight: 800;
            position: relative;
            display: inline-block;
        }

        /* Title Underline Effect */
        .section-title::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 4px;
            background: var(--primary);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        /* Course Grid */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 35px;
            margin-top: 20px;
        }

        /* Modern Course Card */
        .course-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(0, 0, 0, 0.03);
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        /* Image Wrapper */
        .course-img-wrapper {
            height: 230px;
            overflow: hidden;
            position: relative;
        }

        .course-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .course-card:hover .course-img-wrapper img {
            transform: scale(1.1);
        }

        /* Floating Badge */
        .course-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--primary);
            color: #000;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 800;
            border-radius: 50px;
            text-transform: uppercase;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            z-index: 2;
        }

        /* Content Area */
        .course-info {
            padding: 25px;
            text-align: left;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .course-info h3 {
            font-size: 22px;
            color: var(--secondary);
            margin-bottom: 12px;
            font-weight: 700;
        }

        .course-info p {
            color: var(--text-muted);
            font-size: 14.5px;
            margin-bottom: 25px;
            height: 65px; /* Description consistency */
            overflow: hidden;
        }

        /* Premium Buttons */
        .learn-more {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 20px;
            background: var(--secondary);
            color: #fff;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 15px;
            transition: var(--transition);
            gap: 8px;
        }

        .learn-more:hover {
            background: var(--primary);
            color: var(--secondary);
        }

        /* View All Courses Link */
        .view-all-container {
            margin-top: 60px;
        }

        .view-all-btn {
            display: inline-block;
            padding: 15px 45px;
            background: var(--white);
            color: var(--secondary);
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid var(--secondary);
            transition: var(--transition);
        }

        .view-all-btn:hover {
            background: var(--secondary);
            color: var(--white);
            transform: scale(1.05);
        }

        /* Responsive Mobile Fixes */
        @media (max-width: 768px) {
            .section {
                padding: 60px 5%;
            }
            .section-title {
                font-size: 30px;
            }
            .course-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            .course-img-wrapper {
                height: 200px;
            }
        }
    </style>
</head>

<body>

    <?php include "navbar.php"; ?>

    <section class="section">
        <h2 class="section-title">Explore Our Professional Trades</h2>

        <div class="course-grid">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM courses LIMIT 6");

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="course-card">
                        <span class="course-badge">NCVT Approved</span>
                        
                        <div class="course-img-wrapper">
                            <img src="image/<?php echo $row['image']; ?>" alt="<?php echo $row['course_name']; ?>">
                        </div>

                        <div class="course-info">
                            <h3><?php echo $row['course_name']; ?></h3>
                            <p>
                                <?php echo substr($row['description'], 0, 110); ?>...
                            </p>

                           <a href="trade_details.php?id=<?php echo $row['id']; ?>" class="learn-more">
    View Details <i class="fas fa-arrow-right"></i>
</a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div style='grid-column: 1/-1;'><p>No courses available at the moment.</p></div>";
            }
            ?>
        </div>

        <div class="view-all-container">
            <a href="courses.php" class="view-all-btn">
                Browse All Courses
            </a>
        </div>
    </section>

    <?php include "footer.php"; ?>

</body>
</html>