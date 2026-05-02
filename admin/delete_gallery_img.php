<?php
session_start();
include "../db.php";

// 1. Security Check: Sirf logged-in admin hi delete kar sake
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();
}

// 2. ID Check karein
if(isset($_GET['id']) && !empty($_GET['id'])){
    
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. Pehle database se image ka naam fetch karein
    $query = mysqli_query($conn, "SELECT image FROM trade_images WHERE id = '$id'");
    
    if(mysqli_num_rows($query) > 0){
        $row = mysqli_fetch_assoc($query);
        $image_name = $row['image'];
        
        // Sahi rasta (path) set karein
        $file_path = "../image/" . $image_name;

        // 4. Folder se physical file ko delete karein
        // file_exists check karta hai ki file hai, aur is_file check karta hai ki wo folder nahi hai
        if(!empty($image_name) && file_exists($file_path) && is_file($file_path)){
            unlink($file_path);
        }

        // 5. Database se record delete karein
        $delete = mysqli_query($conn, "DELETE FROM trade_images WHERE id = '$id'");

        if($delete){
            // Success: Gallery page par bhejein
            header("Location: gallery_view.php?msg=deleted");
            exit();
        } else {
            echo "Database error: " . mysqli_error($conn);
        }
    } else {
        // Agar ID database mein nahi mili
        header("Location: gallery_view.php");
        exit();
    }
} else {
    // Agar link mein ID hi nahi hai
    header("Location: gallery_view.php");
    exit();
}
?>