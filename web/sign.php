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

function createRand($size){
    $alphas = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
    $length = rand(10,$size);

    $randWord = '';

    for($i=0;$i<$length;$i++){
        $r = rand(0,61);
        $randWord .= $alphas[$r];
    }
    return $randWord;
}
?>