<!DOCTYPE html>

<html>
<head>
  <meta http-equiv="CONTENT-TYPE" content="text/html; charset=UTF-8">
  <title>Hello, World!</title>
  <style>
  .footer{
    background:white;
    color:#fff;
    padding-top:40px;
}

.footer-container{
    display:flex;
    flex-wrap:wrap;
    justify-content:space-around;
    padding:20px;
}

.footer-box{
    width:220px;
    margin:10px;
}

.footer-box h3{
    margin-bottom:15px;
    color:orange;
}

.footer-box p,
.footer-box a{
    font-size:14px;
    color:black;
    text-decoration:none;
}

.footer-box ul{
    list-style:none;
}

.footer-box ul li{
    margin-bottom:8px;
}

.footer-box a:hover{
    color:orange;
}

/* Bottom */
.footer-bottom{
    text-align:center;
    padding:15px;
    background:#001530;
    margin-top:20px;
}
  </style>
</head>
<body>
 <!-- Footer Start -->
<footer class="footer">

    <div class="footer-container">

        <!-- About -->
        <div class="footer-box">
            <h3>JS Pvt ITI College</h3>
            <p>
                We provide quality technical education with practical training.
                Our mission is to build skilled and job-ready students.
            </p>
        </div>

        <!-- Quick Links -->
        <div class="footer-box">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="courses.php">Courses</a></li>
                <li><a href="addmistion.php">Admission</a></li>
                <li><a href="gallery.php">Gallery</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>

        <!-- Contact -->
        <div class="footer-box">
            <h3>Contact Info</h3>
            <p>📍 Varanasi, Uttar Pradesh</p>
            <p>📞 +91 9125862055</p>
            <p>📧 jspiti1655@gmail.com</p>
        </div>

        <!-- Social Media -->
        <div class="footer-box">
            <h3>Follow Us</h3>
            <div class="social">
                <a href="#">Facebook</a><br>
                <a href="https://www.instagram.com/jsitigroup?igsh=MWY4cTdkdWk4Z2RsZQ==">Instagram</a><br>
                <a href="#">YouTube</a>
            </div>
        </div>

    </div>

    <!-- Bottom -->
    <div class="footer-bottom">
        <p>© 2026 JS Pvt ITI College | developed by copa instructor Nandkishor </p>
    </div>

</footer>
<!-- Footer End -->
</body>
</html>