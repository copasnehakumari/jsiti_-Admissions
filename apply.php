<?php
include "db.php";

$trade_id = isset($_GET['trade_id']) ? mysqli_real_escape_string($conn, $_GET['trade_id']) : '';
$success_msg = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO enquiries (trade_id, name, mobile, email, message) 
              VALUES ('$trade_id', '$name', '$mobile', '$email', '$message')";
    
    if(mysqli_query($conn, $query)){
        $success_msg = "Application Submitted Successfully!";
    }
}
?>

<?php include "navbar.php"; ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --primary:  #ffc107;
     --primarye: #1e3a8a; /* Deep Institutional Blue */
        --secondary: #2563eb; /* Modern Action Blue */
        --accent: #f59e0b; /* Professional Gold/Amber */
        --white: #ffffff;
        --text-dark: #0f172a;
        --text-muted: #64748b;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    body { 
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        color: var(--text-dark);
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .enquiry-wrapper {
        padding: 80px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .form-container {
        max-width: 650px;
        width: 100%;
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        padding: 50px;
        border-radius: 32px;
        box-shadow: var(--shadow-premium);
        border: 1px solid rgba(255, 255, 255, 0.7);
        position: relative;
    }

    /* Top branding bar */
    .form-container::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 8px;
        background: linear-gradient(90deg, var(--primarye), var(--secondary));
        border-radius: 32px 32px 0 0;
    }

    .form-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .form-header h2 {
        color: var(--primarye);
        font-size: 2.2rem;
        font-weight: 800;
        letter-spacing: -1px;
        margin-bottom: 12px;
    }

    .form-header p {
        color: var(--text-muted);
        font-size: 1rem;
        font-weight: 500;
    }

    .input-group {
        margin-bottom: 25px;
        position: relative;
    }

    .input-group i {
        position: absolute;
        left: 20px;
        top: 18px;
        color: var(--secondary);
        font-size: 1.1rem;
        transition: 0.3s;
        z-index: 10;
    }

    input, textarea {
        width: 100%;
        padding: 16px 20px 16px 55px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        font-size: 1rem;
        background: #fdfdfd;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-weight: 500;
        box-sizing: border-box;
    }

    input:focus, textarea:focus {
        border-color: var(--secondary);
        background: var(--white);
        outline: none;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }

    textarea {
        height: 140px;
        resize: none;
    }

    /* Icon animation on focus */
    .input-group input:focus + i, 
    .input-group textarea:focus + i {
        color: var(--primarye);
        transform: scale(1.1);
    }

    .submit-btn {
        width: 100%;
        background: var(--primarye);
        color: var(--white);
        padding: 20px;
        border: none;
        border-radius: 16px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 12px;
        margin-top: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .submit-btn:hover {
        background: var(--secondary);
        transform: translateY(-4px);
        box-shadow: 0 15px 30px rgba(37, 99, 235, 0.25);
    }

    .submit-btn:active {
        transform: translateY(0);
    }

    .alert {
        padding: 18px;
        background: #ecfdf5;
        color: #065f46;
        border-radius: 16px;
        margin-bottom: 30px;
        text-align: center;
        font-weight: 700;
        border: 1px solid #a7f3d0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        animation: fadeInDown 0.5s ease;
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .form-container {
            padding: 35px 25px;
            margin: 0 10px;
        }
        .form-header h2 { font-size: 1.8rem; }
    }
</style>

<div class="enquiry-wrapper">
    <div class="form-container">
        <div class="form-header">
            <h2>ITI Admission Enquiry</h2>
            <p>Secure your future with technical excellence. Fill your details below.</p>
        </div>

        <?php if($success_msg): ?>
            <div class="alert">
                <i class="fas fa-check-circle"></i> <?php echo $success_msg; ?>
            </div>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Submitted!',
                    text: 'Your admission enquiry has been sent successfully.',
                    confirmButtonColor: '#1e3a8a'
                });
            </script>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user-graduate"></i>
                <input type="text" name="name" placeholder="Student's Full Name" required>
            </div>

            <div class="input-group">
                <i class="fas fa-phone-alt"></i>
                <input type="text" name="mobile" placeholder="Parent/Student Mobile Number" required>
            </div>

            <div class="input-group">
                <i class="fas fa-envelope-open-text"></i>
                <input type="email" name="email" placeholder="Email Address (Optional)">
            </div>

            <div class="input-group">
                <i class="fas fa-tools" style="top: 20px;"></i>
                <textarea name="message" placeholder="Which trade are you interested in? (e.g. Electrician, Fitter, etc.)"></textarea>
            </div>

            <button type="submit" name="submit" class="submit-btn">
                Submit Admission Request <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<?php include "footer.php"; ?>