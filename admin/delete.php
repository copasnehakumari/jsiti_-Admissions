<?php
session_start();
include "../db.php";

// Admin login check (Security ke liye zaroori hai)
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Database se image ka naam fetch karein
    $get_data = mysqli_query($conn, "SELECT image FROM trades WHERE id='$id'");
    
    if(mysqli_num_rows($get_data) > 0){
        $row = mysqli_fetch_assoc($get_data);
        $file_name = $row['image'];
        
        // Sahi path check karein (Aapke folder structure ke hisab se)
        $full_path = "../image/" . $file_name;

        // 2. Folder se file delete karein
        // Hum check kar rahe hain ki file khali na ho, file exist karti ho, aur wo koi folder na ho
        if(!empty($file_name) && file_exists($full_path) && is_file($full_path)){
            if(unlink($full_path)){
                // File delete ho gayi
            }
        }

        // 3. Database se record delete karein
        $delete_query = mysqli_query($conn, "DELETE FROM trades WHERE id='$id'");

        if($delete_query){
            header("Location: admin_view.php?msg=deleted");
            exit();
        } else {
            // Agar database error ho
            header("Location: admin_view.php?msg=db_error");
            exit();
        }
    }
}

// Default redirect
header("Location: admin_view.php");
exit();
?>