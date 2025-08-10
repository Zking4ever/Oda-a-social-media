<?php

require "backend/conn.php";

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare('SELECT name,password from admin where email = ?');
$stmt->bind_param('s',$email);
$stmt->execute();
$result = $stmt->get_result();


if($row = $result->fetch_assoc()){
    if(password_verify($password, $row['password'])){
        session_start();
        $_SESSION['userid'] = $row['name'];
        include "admin.php";
    }
}

else{
    echo "Incorrect email or password";
}