<?php
require "backend/conn.php";

if(isset($_POST) && !empty($_POST)){
            
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        $checkForEmail = "SELECT * from users where email = '$email'";
        $checkResponse = $conn->query($checkForEmail);

        if($checkResponse->num_rows >0){
            echo "Email already exist";
            die;
        }
        
        $userid = createRand(25);

        $query = "INSERT into users(firstname,lastname,email,password,userid) values('$fname','$lname','$email','$password','$userid')";
        $response = $conn->query($query);
        if($response == true){
            echo "sign up completed";
        }
}
elseif(isset($_GET) && !empty($_GET)){
    $email = $_GET['email'];
    $password = $_GET['password'];

    $checkForUser = "SELECT * from users where email = '$email' && password = '$password'";
    $checkUserResponse = $conn->query($checkForUser);

    if($checkUserResponse->num_rows>0){
        session_start();
        $userdata = $checkUserResponse->fetch_assoc();
        $_SESSION['userid'] = $userdata['userid'];
        header('location: home.php');
    }
    else{
        echo "incorrect email or password";
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