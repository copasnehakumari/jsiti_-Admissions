<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Admission Portal | JS ITI Varanasi</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #ffc107;
            --secondary: #0a3ead;
            --accent: #f59e0b;
            --success: #10b981;
            --text-dark: #0f172a;
            --text-light: #64748b;
            --white: #ffffff;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background: var(--bg-gradient);
            color: var(--text-dark);
            min-height: 100vh;
            
            
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        /* --- Header --- */
        header {
            text-align: center;
            margin-bottom: 50px;
        }

        header h1 {
            font-size: clamp(2.2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--primary);
            letter-spacing: -1px;
            margin-bottom: 10px;
        }

        header p {
            font-size: 1.1rem;
            color: var(--text-light);
            font-weight: 500;
        }

        /* --- Info Cards --- */
        .box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 20px;
            
        }

        .card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
             margin-top: 10px;
        }

        .card:hover {
            transform: translateY(-8px);
            background: var(--white);
            box-shadow: 0 20px 40px rgba(30, 58, 138, 0.1);
            border-color: var(--secondary);
        }

        .card h3 {
            font-size: 1.4rem;
            color: var(--primary);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card ul { list-style: none; }
        .card li {
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        .card li i { color: var(--secondary); margin-top: 3px; }

        /* --- CTA Section --- */
        .apply-section {
            background: var(--secondary);
            color: var(--white);
            padding: 70px 30px;
            margin-bottom:50px;
            border-radius: 30px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(30, 58, 138, 0.2);
        }

        .apply-now-btn {
            background: var(--accent);
            color: var(--secondary);
            font-size: 1.1rem;
            font-weight: 800;
            padding: 16px 45px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.3s;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 20px;
            text-decoration: none;
            display: inline-block;
        }

        .apply-now-btn:hover {
            background: var(--white);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php include "navbar.php"?>

<div class="container">
    <header>
        <h1>Smart Admission Portal</h1>
        <p>Unlock your potential with professional technical training.</p>
    </header>

    <div class="box">
        <div class="card">
            <h3><i class="fas fa-route"></i> Admission Steps</h3>
            <ul>
                <li><i class="fas fa-check-circle"></i> <b>Choose Trade:</b> Select based on your career goals.</li>
                <li><i class="fas fa-check-circle"></i> <b>Campus Visit:</b> Explore our modern labs and workshop.</li>
                <li><i class="fas fa-check-circle"></i> <b>Verification:</b> Complete your document check.</li>
                <li><i class="fas fa-check-circle"></i> <b>Final Seat:</b> Pay the fee to confirm admission.</li>
            </ul>
        </div>

        <div class="card">
            <h3><i class="fas fa-user-graduate"></i> Eligibility Criteria</h3>
            <ul> 
                <li><i class="fas fa-check-circle"></i> Age should be between 16 to 25 years</li>
                <li><i class="fas fa-check-circle"></i> Minimum qualification: 10th Standard Pass</li>
                <li><i class="fas fa-check-circle"></i> Genuine interest in the selected technical trade</li>
                <li><i class="fas fa-check-circle"></i> Documents: Aadhaar Card & Marksheets</li> 
            </ul>
        </div>
    </div>

    <div class="apply-section">
        <h2>Reserve Your Seat Today</h2>
        <p>Click the button below to start your application process.</p>
        
        <a href="apply.php" class="apply-now-btn">
            <i class="fas fa-paper-plane"></i> Apply Now
        </a>
    </div>
</div>
<?php include "footer.php"?>
</body>
</html>