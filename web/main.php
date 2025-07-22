<?php

session_start();
$userData;

if(isset($_SESSION['userData'])){
   $userData = $_SESSION['userData'];
}

if (isset($_GET['code'])) {
    
    require_once 'vendor/autoload.php';
    require "backend/config.php";
    $client = new Google_Client();
    $client->setClientId(CLIENT_ID);
    $client->setClientSecret(CLIENT_SECRET);
    $client->setRedirectUri('http://localhost/mywork/incredible%20future/web/main.php');

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);
    
    // Get user profile
    $oauth2 = new Google_Service_Oauth2($client);
    $userinfo = $oauth2->userinfo->get();
    
    $userData = [
        'id' => $userinfo->id,
        'email' => $userinfo->email,
        'name' => $userinfo->name,
        'picture' => $userinfo->picture,
    ];

    $_SESSION['userid'] =$userData['id'];
    $_SESSION['userData'] = $userData;

}
if(isset($_SESSION['userid'])){
    
    require "backend/conn.php";
    
    $userid = $_SESSION['userid'];
    $userExist = "SELECT id from users where userid = '$userid' ";
    $checkUserExistance = $conn->query($userExist);

    if($checkUserExistance->num_rows>0){
        include 'home.php';
    }else{
        
        if($userid==$userData['id']){
        //here registration occurs and then sign in automatically
        //before that let them create password and username
            if( !( isset($_GET['username']) || isset($_GET['password']) ) ) {
                include "registration.php";
                die;
            }
            
            $username = $_GET['username'];
            $password = $_GET['password'];
            $query = "INSERT into users (userid,email,username,name,password,source) values('$userData[id]','$userData[email]','$username','$userData[name]','$password','$userData[picture]')";
            $excute = $conn->query($query);
            if($excute){
                include 'home.php';
            }

        }
    }
}
else{
    session_destroy();
    header("location: loged out.php");
    die;
}
 