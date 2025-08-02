<?php

session_start();
$userData;

if(isset($_SESSION['userData'])){
   $userData = $_SESSION['userData'];
}

if(isset($_SESSION['userid'])){
    
    require "backend/conn.php";
    
    $userid = $_SESSION['userid'];
    $userExist = "SELECT id from users where userid = '$userid' ";
    $checkUserExistance = $conn->query($userExist);

    if($checkUserExistance->num_rows>0){
        header('loacation home.php');
    }else{
        session_destroy();
        header("location: loged out.php");
        die;
    }
}
else{
    session_destroy();
    header("location: loged out.php");
    die;
}
 