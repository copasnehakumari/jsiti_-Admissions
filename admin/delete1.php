<?php
session_start();
include '../db.php';

// Check karein ki admin logged in hai (Security ke liye)
if(!isset($_SESSION['admin'])){
    header("location: index.php");
    exit();
}

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Pehle database se image ka naam fetch karein
    $fetch_sql = "SELECT image FROM leadership WHERE id = '$id'";
    $fetch_res = mysqli_query($conn, $fetch_sql);

    if(mysqli_num_rows($fetch_res) > 0){
        $row = mysqli_fetch_assoc($fetch_res);
        $image_name = $row['image'];
        
        // Sahi path set karein (Maan lijiye image '../uploads/leadership/' folder mein hai)
        // Agar aapka folder name kuch aur hai toh yahan change karein
        $file_path = "../uploads/leadership/" . $image_name;

        // 2. Folder se physical file delete karein
        if(!empty($image_name) && file_exists($file_path)){
            unlink($file_path);
        }

        // 3. Ab database se record delete karein
        $delete_query = "DELETE FROM leadership WHERE id = '$id'";
        if(mysqli_query($conn, $delete_query)){
            // Success: wapas list page par bhej dein
            header("Location: view_leadership.php?msg=deleted");
            exit();
        }
    }
}

// Agar koi error ho ya ID na mile
header("Location: view_leadership.php");
exit();
?>