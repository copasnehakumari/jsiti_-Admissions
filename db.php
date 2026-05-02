<?php

$conn = mysqli_connect(
"localhost",
"root",
"",
"iti_db"
);

if(!$conn){
die("Database Connection Failed");
}

?>