<?php
require "backend/conn.php";
session_start();

 $data;

if(isset($_POST) && !empty($_POST) && $_POST['type']=="log_in" ){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $checkForUser = "SELECT userid from users where email = '$email' && password = '$password'";
    $checkUserResponse = $conn->query($checkForUser);

    
    if($checkUserResponse->num_rows>0){
        $userdata = $checkUserResponse->fetch_assoc();
        $data['result'] = "log in";
        $data['status'] = "great";
        $_SESSION['userid'] = $userdata['userid'];

        //header("location : check.php");
        echo json_encode( $data );
    }
    else{
        $data['result'] = "incorrect email or password";
        $data['status'] = "bad";

        echo json_encode( $data );
    }

}


?>