<?php
session_start();
include "../db.php";

if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");

    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password'];

        if(password_verify($password, $hashed_password)){
            $_SESSION['admin'] = $username;
            header("location:dashboard.php");
            exit();
        } else {
            $error = "Invalid Username or Password";
        }
    } else {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secured Admin Access | JS Pvt ITI College</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/dist/css/all.min.css">
    
    <style>
        :root {
            --primary-blue: #002147;
            --accent-gold: #ffc107;
            --white: #ffffff;
            --text-gray: #7f8c8d;
            --error-red: #eb4d4b;
        }

        * { box-sizing: border-box; transition: all 0.3s ease; }

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px; 
            background: linear-gradient(rgba(0, 33, 71, 0.88), rgba(0, 21, 41, 0.92)), 
                        url('image/WhatsApp Image 2026-04-12 at 10.04.14 PM.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .login-card {
            background: var(--white);
            width: 100%;
            /* Card size ko chota aur professional kiya gaya hai */
            max-width: 400px; 
            padding: 35px 30px;
            border-radius: 20px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.5);
            text-align: center;
            position: relative;
            animation: fadeInDown 0.8s ease-out;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 5px;
            background: var(--accent-gold);
            border-radius: 20px 20px 0 0;
        }

        .logo-section { margin-bottom: 20px; }

        .logo-section img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #f1f2f6;
            padding: 4px;
            background: #fff;
        }

        h2 {
            color: var(--primary-blue);
            font-weight: 700;
            margin: 5px 0;
            font-size: 22px;
        }

        .subtitle {
            color: var(--text-gray);
            font-size: 13px;
            margin-bottom: 25px;
        }

        .input-group {
            position: relative;
            margin-bottom: 18px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #b2bec3;
            font-size: 14px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1.5px solid #f1f2f6;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            background: #fdfdfd;
        }

        .input-group input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 4px 12px rgba(0,33,71,0.1);
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: var(--primary-blue);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 10px;
        }

        .login-button:hover {
            background: #003366;
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,33,71,0.2);
        }

        .auth-footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #f1f2f6;
        }

        .register-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 12px;
            font-size: 13px;
            color: var(--text-gray);
        }

        .register-box a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 700;
        }

        .forgot-link {
            font-size: 12px;
            color: var(--text-gray);
            text-decoration: none;
        }

        .forgot-link:hover { color: var(--error-red); text-decoration: underline; }

        .error-alert {
            background: #fff5f5;
            color: var(--error-red);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            border-left: 3px solid var(--error-red);
            display: flex;
            align-items: center;
            gap: 8px;
            text-align: left;
        }

        .footer-credit {
            margin-top: 25px;
            font-size: 10px;
            color: #bdc3c7;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Full Responsive Tweaks */
        @media (max-width: 400px) {
            .login-card { padding: 25px 20px; }
            h2 { font-size: 20px; }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-section">
        <img src="../image/WhatsApp Image 2026-04-12 at 10.04.14 PM.jpeg" alt="Logo">
    </div>
    
    <h2>Admin Login</h2>
    <div class="subtitle">Enter your credentials to manage portal</div>

    <?php if(isset($error)): ?>
        <div class="error-alert">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" name="login" class="login-button">
            Sign In <i class="fas fa-sign-in-alt"></i>
        </button>
    </form>

    <div class="auth-footer">
      
        <a href="forgot_password.php" class="forgot-link">
            <i class="fas fa-key"></i> Forgot Password?
        </a>
    </div>

    <div class="footer-credit">
        JS Pvt ITI &bull; Secured Portal &bull; 2026
    </div>
</div>

</body>
</html>