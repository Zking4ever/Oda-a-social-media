<?php

$conn = new mysqli('localhost','root','',"astawus's practice");

if($conn->connect_error){
    echo "Error while connecting to server...";
    die;
}
?>