<?php

require "backend/conn.php";

echo "check";
 $userid = $_GET['you_id'];
 $validate = "SELECT * from users where userid = '$userid' ";
 $checkUserValidation = $conn->query($validate);

    if($checkUserValidation->num_rows>0){
        $userdata = $checkUserValidation->fetch_assoc();
        session_start();
        $_SESSION['userid'] = $userdata['userid'];
        header('location: home.php');
    }
