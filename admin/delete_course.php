<?php
session_start();
include "../db.php";

// 1. Security Check: Sirf logged-in admin hi delete kar sake
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();    
}

// 2. ID Validation
if(isset($_GET['id']) && !empty($_GET['id'])){
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Pehle image ka naam fetch karein
    $get = mysqli_query($conn, "SELECT image FROM courses WHERE id='$id'");
    
    if(mysqli_num_rows($get) > 0){
        $row = mysqli_fetch_assoc($get);
        $image_name = $row['image'];
        $file_path = "../image/" . $image_name;

        // 4. Folder se file delete karein (Checks ke saath)
        if(!empty($image_name) && file_exists($file_path) && is_file($file_path)){
            unlink($file_path);
        }

        // 5. Database se record delete karein
        $delete = mysqli_query($conn, "DELETE FROM courses WHERE id='$id'");

        if($delete){
            // Success: wapas list page par bhejein
            header("Location: view_courses.php?msg=deleted");
            exit();
        } else {
            echo "Database Error: " . mysqli_error($conn);
        }
    } else {
        // Agar ID database mein nahi hai
        header("Location: view_courses.php");
        exit();
    }
} else {
    // Agar ID provide nahi ki gayi
    header("Location: view_courses.php");
    exit();
}
?>