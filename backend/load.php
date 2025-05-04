<?php
require "conn.php";
session_start();

if($_SESSION['userid'] ==''){
    header("location: index.html");
}
$userid = $_SESSION['userid'];

$data = [];
#loading the profile
$queryForUser= "SELECT * from users where userid= '$userid'";
$lookUser = $conn->query($queryForUser);
if($lookUser){
    $userData = $lookUser->fetch_assoc();
    $data['userinfo']=$userData;
}

#loading the posts
$query = "SELECT * from posts";
$result = $conn->query($query);

$post = "";
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        
        $post.="<div class='post'>
            <img src='backend/".$row['source']."'>
            <span class='caption'>".$row['caption']."</span>
            <div class='reactions'> 
                <div class='react like'></div>
            </div>
        </div>";
    }
    $data['posts']=$post;
}

echo json_encode($data);

?>