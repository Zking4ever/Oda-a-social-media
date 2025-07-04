<?php

require "backend/conn.php";
session_start();

if(isset($_SESSION['userid'])){
    
    $userid = $_SESSION['userid'];
    $validate = "SELECT * from users where userid = '$userid' ";
    $checkUserValidation = $conn->query($validate);

    if($checkUserValidation->num_rows>0){
        include 'home.php';
    }
}
else{
    session_abort();
    die;
}
 
