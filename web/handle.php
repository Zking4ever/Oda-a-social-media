<?php
require "backend/conn.php";
    if(isset($_POST) && isset($_POST['userinfo'])){
        $userData = json_decode($_POST['userinfo']);
        $username = $_POST['username'];
        $password = $_POST['password'];
            $query = "INSERT into users (userid,email,username,name,password,source) values('$userData->sub','$userData->email','$username','$userData->name','$password','$userData->picture')";
            $excute = $conn->query($query);
            if($excute){
                 $_SESSION['userid'] = $userData->sub;
                 echo "done";
            }
    }