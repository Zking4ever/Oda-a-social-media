<?php
require "backend/conn.php";
session_start();
    if(isset($_POST) && isset($_POST['userinfo'])){
        $userData = json_decode($_POST['userinfo']);
        if($_POST['type']=="sign_up"){
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_DEFAULT);
            $profile = "Profiles/user.PNG"; //default user image
        $stmt =$conn->prepare('INSERT into users (userid,email,username,name,password,source) values(?,?,?,?,?,?)');
        $stmt->bind_param('ssssss',$userData->sub,$userData->email,$username,$userData->name,$password,$profile);
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
    }elseif(isset($_POST['type']) && $_POST['type']=="telegramAuth"){
        $userid = $_POST['id'];
        $query = "SELECT id from users where userid = '$userid'";
        $excute = $conn->query($query);
            if($excute && $excute->num_rows>0){
                $_SESSION['userid'] = $userid;
                echo "done";
                die;
            }
            elseif($excute){
                $username = $_POST['username'];
                $name = $_POST['name'];
                $profile = "Profiles/user.PNG"; //default user image
                $stmt = $conn->prepare("INSERT into users(userid,name,username,source) values(?,?,?,?)");
                $stmt->bind_param("ssss",$userid,$name,$username,$profile);
                $stmt->execute();
                if($stmt->affected_rows >0){
                    $_SESSION['userid'] =  $userid;
                    echo "done";
                }
            }
    }