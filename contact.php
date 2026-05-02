<?php 
include "db.php"; 

$show_alert = false;

if(isset($_POST['send_msg'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $sql = "INSERT INTO contact_queries (name, email, phone, subject, message) 
            VALUES ('$name', '$email', '$phone', '$subject', '$message')";
    
    if(mysqli_query($conn, $sql)){
        $show_alert = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | JS Private ITI Varanasi</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --primary: #ffc107;
            --primarye: #042954;
            --accent: #FFC107;
            --secondary: #3b82f6;
            --bg-light: #fdfdfd;
            --glass: rgba(255, 255, 255, 0.95);
            --card-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Plus Jakarta Sans', sans-serif; }
        
        body { 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            color: #334155;
            min-height: 100vh;
        }

        /* Hero Section */
        .hero {
            padding: 80px 20px 120px;
            text-align: center;
            background: linear-gradient(to bottom, #ffffff, transparent);
        }

        .hero span {
            color: var(--secondary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 13px;
        }

        .hero h1 {
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            font-weight: 800;
            color: var(--primarye);
            margin-top: 10px;
            letter-spacing: -1.5px;
        }

        .hero .divider {
            width: 60px; height: 5px; background: var(--accent);
            margin: 20px auto; border-radius: 10px;
        }

        /* Layout */
        .container {
            max-width: 1200px;
            margin: -60px auto 80px;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 40px;
        }

        /* Form Styling */
        .form-card {
            background: var(--glass);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 35px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(255,255,255,0.5);
        }

        .form-group { margin-bottom: 25px; }

        .form-group label {
            display: block; margin-bottom: 10px;
            font-weight: 700; font-size: 14px; color: var(--primarye);
        }

        .form-control {
            width: 100%; padding: 16px 20px;
            border-radius: 16px; border: 2px solid #e2e8f0;
            outline: none; transition: all 0.3s ease;
            background: #f8fafc; font-size: 15px;
        }

        .form-control:focus {
            border-color: var(--secondary);
            background: #fff;
            box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1);
        }

        .btn-submit {
            background: var(--primarye);
            color: white; border: none; padding: 20px;
            border-radius: 18px; font-weight: 800;
            width: 100%; cursor: pointer;
            font-size: 17px; transition: 0.4s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(4, 41, 84, 0.25);
            background: #063e7a;
        }

        /* Info Panel */
        .info-panel { display: flex; flex-direction: column; gap: 20px; }

        .contact-item {
            background: white; padding: 30px; border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            display: flex; gap: 20px; align-items: flex-start;
            transition: 0.3s ease; border: 1px solid #f1f5f9;
        }

        .contact-item:hover { transform: scale(1.03); }

        .icon-circle {
            min-width: 55px; height: 55px;
            background: #eff6ff; border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            color: var(--primarye); font-size: 22px;
        }

        .contact-item h4 { color: var(--primarye); font-weight: 700; margin-bottom: 5px; }
        .contact-item p { color: #64748b; font-size: 14px; font-weight: 500; }

        .map-container {
            border-radius: 30px; overflow: hidden; height: 320px;
            border: 10px solid white; box-shadow: var(--card-shadow);
        }

       /* --- RESPONSIVE ADJUSTMENTS START --- */

/* Mobile par layout ko single column karne ke liye */
@media (max-width: 1024px) {
    .container {
        grid-template-columns: 1fr; /* Form aur Info Panel upar-neeche ho jayenge */
        margin-top: -40px;
    }
}

@media (max-width: 768px) {
    .hero {
        padding: 60px 15px 80px;
    }
    
    .hero h1 {
        font-size: 2.2rem; /* Mobile par heading thodi chhoti */
    }

    .form-card {
        padding: 25px; /* Mobile par padding kam takki space bache */
        border-radius: 25px;
    }

    .grid-2 {
        grid-template-columns: 1fr !important; /* Email aur Phone mobile par ek ke niche ek */
        gap: 0;
    }

    .contact-item {
        padding: 20px;
        border-radius: 20px;
    }
}

@media (max-width: 480px) {
    .hero h1 {
        font-size: 1.8rem;
    }
    
    .form-control {
        padding: 12px 15px; /* Input fields mobile ke liye comfortable size */
    }

    .btn-submit {
        padding: 15px;
        font-size: 16px;
    }
    
    .map-container {
        height: 250px; /* Chhoti screen par map ki height kam */
    }
}

/* Image/Iframe responsiveness fix */
iframe {
    width: 100% !important;
}

/* --- RESPONSIVE ADJUSTMENTS END --- */
    </style>
</head>
<body>

    <?php include "navbar.php"; ?>

    <section class="hero">
        <span>Connect With Us</span>
        <h1>How Can We Help You?</h1>
        <div class="divider"></div>
    </section>

    <div class="container">
        <div class="form-card">
            <form action="" method="POST">
                <div class="form-group">
                    <label>YOUR FULL NAME</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g. Neha Maurya" required>
                </div>

                <div class="grid-2" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>EMAIL ADDRESS</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                    </div>
                    <div class="form-group">
                        <label>PHONE NUMBER</label>
                        <input type="text" name="phone" class="form-control" placeholder="+91 00000 00000" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>SUBJECT</label>
                    <input type="text" name="subject" class="form-control" placeholder="e.g. Admission Query 2026">
                </div>

                <div class="form-group">
                    <label>YOUR MESSAGE</label>
                    <textarea name="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                </div>

                <button type="submit" name="send_msg" class="btn-submit">
                    Send Message <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>

        <div class="info-panel">
            <div class="contact-item">
                <div class="icon-circle"><i class="fa-solid fa-location-dot"></i></div>
                <div>
                    <h4>Campus Location</h4>
                    <p>JS Private ITI, Palahi Patti, Sindhora Road, Varanasi, UP - 221202</p>
                </div>
            </div>

            <div class="contact-item">
                <div class="icon-circle"><i class="fa-solid fa-phone-volume"></i></div>
                <div>
                    <h4>Quick Contact</h4>
                    <p>+91 98765 43210<br>info@jspvtiti.com</p>
                </div>
            </div>

            <div class="map-container">
                <iframe 
                     src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3602.3459935899305!2d82.95220537457848!3d25.460119777542626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x398e2a599218b8d5%3A0xc58ffc64489326c0!2sJ.S.%20Private%20Industrial%20Training%20Institute%20PalhiPatti%2C%20Varanasi%20221208!5e0!3m2!1sen!2sin!4v1776011895183!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <?php if($show_alert): ?>
    <script>
        Swal.fire({
            title: '<strong>Success!</strong>',
            icon: 'success',
            html: 'Your message has been sent successfully. <br> Our team will contact you in <b>24 hours</b>.',
            showCloseButton: true,
            confirmButtonText: 'Great!',
            confirmButtonColor: '#042954',
            customClass: {
                popup: 'rounded-30'
            }
        });
    </script>
    <?php endif; ?>

</body>
</html>