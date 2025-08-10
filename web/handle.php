<?php
require "backend/conn.php";
session_start();
    if(isset($_POST) && isset($_POST['userinfo'])){
        $userData = json_decode($_POST['userinfo']);
        if($_POST['type']=="sign_up"){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);
        $stmt =$conn->prepare('INSERT into users (userid,email,username,name,password) values(?,?,?,?,?)');
        $stmt->bind_param('sssss',$userData->sub,$userData->email,$username,$userData->name,$password);
        $stmt->execute();

            if($stmt->affected_rows >0){
                $_SESSION['userid'] = $userData->sub;
                echo "done";
            }
        }else{
            $query = "SELECT id from users where userid = '$userData->sub'";
            $excute = $conn->query($query);
            if($excute){
                    if($excute->num_rows>0){
                            $_SESSION['userid'] = $userData->sub;
                            echo "done";
                            die;
                        }
                }
            }
    }