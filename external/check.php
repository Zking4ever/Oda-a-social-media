<?php

session_start();
$user;

if (isset($_GET['code'])) {
    
    require "backend/config.php";
    $client = new Google_Client();
    $client->setClientId(CLIENT_ID);
    $client->setClientSecret(CLIENT_SECRET);
    $client->setRedirectUri('http://localhost/auth%20practice/redirect.php');

    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);
    
    // Get user profile
    $oauth2 = new Google_Service_Oauth2($client);
    $userinfo = $oauth2->userinfo->get();
    
    $user = [
        'id' => $userinfo->id,
        'email' => $userinfo->email,
        'name' => $userinfo->name,
        'picture' => $userinfo->picture,
    ];

    //here registration occurs and then sign in automatically
    //before that let them create password and username

}
if(isset($_SESSION['userid'])){
    
    require "backend/conn.php";
    
    $userid = $_SESSION['userid'];
    $validate = "SELECT * from users where userid = '$userid' ";
    $checkUserValidation = $conn->query($validate);

    if($checkUserValidation->num_rows>0){
        include 'home.php';
    }
}
else{
    session_destroy();
    header("location: loged out.php");
    die;
}
 