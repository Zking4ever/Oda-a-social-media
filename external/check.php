<?php

require "backend/conn.php";
session_start();

 $userid = $_GET['you_id'];
 $validate = "SELECT * from users where userid = '$userid' ";
 $checkUserValidation = $conn->query($validate);

    if($checkUserValidation->num_rows>0){
        $userdata = $checkUserValidation->fetch_assoc();
        $_SESSION['userid'] = $userdata['userid'];
        include 'home.php';
    }
