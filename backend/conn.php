<?php

$conn = new mysqli('localhost','root','',"incredible future");

if($conn->connect_error){
    echo "Error while connecting to server...";
    die;
}
?>