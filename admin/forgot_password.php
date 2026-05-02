<?php
session_start();
include "../db.php";
include "../mail_config.php"; 

$message = "";
$msg_class = "";

/* STEP 1 — Send OTP */
if(isset($_POST['send_otp'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $result = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");

    if(mysqli_num_rows($result) > 0){
        $otp = rand(100000, 999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_time'] = time();
        $_SESSION['reset_email'] = $email;

        if(sendOTP($email, $otp)){
            $message = "✨ Magic Link Sent! Check your inbox.";
            $msg_class = "success-glow";
        } else {
            $message = "🚀 Mission Failed! SMTP connection error.";
            $msg_class = "error-glow";
        }
    } else {
        $message = "🔍 Ghost Email! This ID is not in our system.";
        $msg_class = "error-glow";
    }
}

/* STEP 2 — Verify OTP */
if(isset($_POST['verify_otp'])){
    $user_otp = $_POST['otp'];
    $current_time = time();
    
    if(isset($_SESSION['otp_time'])){
        if(($current_time - $_SESSION['otp_time']) > 120){
            $message = "⏰ Time's Up! Your OTP turned into a pumpkin.";
            $msg_class = "error-glow";
            unset($_SESSION['otp']);
            unset($_SESSION['otp_time']);
        } else {
            if($user_otp == $_SESSION['otp']){
                $_SESSION['otp_verified'] = true;
                $message = "🔓 Access Granted! Create a strong secret.";
                $msg_class = "success-glow";
            } else {
                $message = "❌ Wrong Code! Try again, spy.";
                $msg_class = "error-glow";
            }
        }
    }
}

/* STEP 3 — Reset Password */
if(isset($_POST['reset_password'])){
    $new_pass = $_POST['new_password'];
    $conf_pass = $_POST['confirm_password'];

    if($new_pass === $conf_pass){
        $email = $_SESSION['reset_email'];
        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);
        
        $update = mysqli_query($conn, "UPDATE admin SET password='$hashed_password' WHERE email='$email'");
        
        if($update){
            $message = "🎊 Boom! Password Updated. Teleporting you now...";
            $msg_class = "success-glow";
            session_destroy();
            echo "<script>setTimeout(()=>{ window.location.href='index.php'; }, 3000);</script>";
        }
    } else {
        $message = "⚠️ Mismatch! Passwords aren't twins.";
        $msg_class = "error-glow";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rescue Account | JS ITI</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css">
    <style>
        :root { --primary: #002147; --accent: #ffc107; --neon-success: #00ff88; --neon-error: #ff4d4d; }
        * { box-sizing: border-box; transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            margin: 0; display: flex; align-items: center; justify-content: center; min-height: 100vh;
            background: #0a0e14; overflow: hidden;
        }

        /* Animated Background */
        body::before {
            content: ""; position: absolute; width: 200%; height: 200%;
            background: radial-gradient(circle, #1a3a5f 0%, #0a0e14 70%);
            animation: moveBg 10s linear infinite; z-index: -1;
        }
        @keyframes moveBg { from { transform: translate(-25%, -25%); } to { transform: translate(0%, 0%); } }

        .forgot-card {
            background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255,255,255,0.1);
            backdrop-filter: blur(20px); width: 100%; max-width: 400px; padding: 40px; border-radius: 30px;
            box-shadow: 0 40px 100px rgba(0,0,0,0.5); text-align: center; color: white;
        }

        /* Custom Alert Styling */
        .alert { 
            padding: 15px; border-radius: 15px; margin-bottom: 25px; font-size: 14px; font-weight: 700;
            animation: slideDown 0.5s ease;
        }
        .success-glow { background: rgba(0, 255, 136, 0.1); color: var(--neon-success); border: 1px solid var(--neon-success); box-shadow: 0 0 15px rgba(0, 255, 136, 0.2); }
        .error-glow { background: rgba(255, 77, 77, 0.1); color: var(--neon-error); border: 1px solid var(--neon-error); box-shadow: 0 0 15px rgba(255, 77, 77, 0.2); }

        @keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

        .input-box { position: relative; margin-bottom: 20px; }
        .input-box i { position: absolute; left: 15px; top: 18px; color: var(--accent); }
        input { 
            width: 100%; padding: 15px 15px 15px 45px; border: 1px solid rgba(255,255,255,0.2); 
            border-radius: 15px; background: rgba(255,255,255,0.05); color: white; outline: none;
        }
        input:focus { border-color: var(--accent); background: rgba(255,255,255,0.1); box-shadow: 0 0 10px rgba(255, 193, 7, 0.3); }

        button { 
            width: 100%; padding: 15px; background: var(--accent); color: var(--primary); 
            border: none; border-radius: 15px; font-weight: 800; cursor: pointer; letter-spacing: 1px;
        }
        button:hover { transform: scale(1.03); box-shadow: 0 5px 20px rgba(255, 193, 7, 0.4); }

        .timer-box { font-size: 18px; font-weight: 800; color: var(--neon-error); margin: 15px 0; display: block; }
        .back-link { display: block; margin-top: 25px; color: #aaa; text-decoration: none; font-size: 13px; }
        .back-link:hover { color: white; }
    </style>
</head>
<body>

<div class="forgot-card">
    <div class="icon-header">
        <i class="fas fa-shield-alt" style="font-size: 60px; color: var(--accent); margin-bottom: 10px;"></i>
    </div>
    <h2 style="margin-bottom: 5px;">Secure Recovery</h2>
    <p style="color: #aaa; margin-bottom: 30px;">Let's get you back in!</p>

    <?php if($message != ""): ?>
        <div class="alert <?php echo $msg_class; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if(!isset($_SESSION['otp'])): ?>
    <form method="POST">
        <div class="input-box">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder="Your Admin Email" required>
        </div>
        <button type="submit" name="send_otp">INITIALIZE RECOVERY</button>
    </form>
    <?php endif; ?>

    <?php if(isset($_SESSION['otp']) && !isset($_SESSION['otp_verified'])): ?>
    <form method="POST" id="otpForm">
        <div class="input-box">
            <i class="fas fa-key"></i>
            <input type="text" name="otp" placeholder="6-Digit Code" required>
        </div>
        <div class="timer-box">
            <i class="fas fa-hourglass-half"></i> <span id="countdown">02:00</span>
        </div>
        <button type="submit" name="verify_otp">VERIFY IDENTITY</button>
    </form>

    <script>
        // JS Live Timer Logic
        let timeLeft = 120; // 2 minutes in seconds
        const display = document.querySelector('#countdown');
        
        const timer = setInterval(() => {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            
            seconds = seconds < 10 ? '0' + seconds : seconds;
            display.innerHTML = `0${minutes}:${seconds}`;
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                alert('OTP Expired! Page will reload.');
                window.location.reload();
            }
            timeLeft--;
        }, 1000);
    </script>
    <?php endif; ?>

    <?php if(isset($_SESSION['otp_verified'])): ?>
    <form method="POST">
        <div class="input-box">
            <i class="fas fa-lock"></i>
            <input type="password" name="new_password" placeholder="New Secret Password" required>
        </div>
        <div class="input-box">
            <i class="fas fa-check-double"></i>
            <input type="password" name="confirm_password" placeholder="Repeat Secret" required>
        </div>
        <button type="submit" name="reset_password">UPGRADE SECURITY</button>
    </form>
    <?php endif; ?>

    <a href="index.php" class="back-link">← Abandon Mission</a>
</div>

</body>
</html>