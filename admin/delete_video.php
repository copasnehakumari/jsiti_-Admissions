<?php
session_start();
include "../db.php";

// Check karein ki admin logged in hai ya nahi
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Pehle video ka file name fetch karein taaki folder se delete kar sakein
    $fetch_sql = "SELECT video FROM trade_videos WHERE id = '$id'";
    $fetch_res = mysqli_query($conn, $fetch_sql);

    if(mysqli_num_rows($fetch_res) > 0){
        $row = mysqli_fetch_assoc($fetch_res);
        $video_file = $row['video'];
        $file_path = "../video/" . $video_file;

        // 2. Folder se file delete karein agar exist karti hai
        if(file_exists($file_path)){
            unlink($file_path); 
        }

        // 3. Database se record delete karein
        $delete_sql = "DELETE FROM trade_videos WHERE id = '$id'";
        if(mysqli_query($conn, $delete_sql)){
            // Success: Wapas video page par bhejein msg ke saath
            header("location:videos_list.php?msg=deleted");
            exit();
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // Agar ID database mein nahi milti
        header("location:videos_list.php");
        exit();
    }
} else {
    // Agar direct access karne ki koshish ki jaye bina ID ke
    header("location: videos_list.php");
    exit();
}
?>