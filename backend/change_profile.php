<?php
require "conn.php";
session_start();

$userid = $_SESSION['userid'];
$destination ="";

if(isset($_FILES) && !empty($_FILES)){
    if($_FILES['file']['name'] != "" && $_FILES['file']['error'] == 0){
        $folder = "Profiles/";
        if(!file_exists($folder)){
            mkdir($folder,0777,true);
        }
        $destination = $folder. $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'],$destination);
    }
}
if($destination!=""){

    $query = "UPDATE users set profile_source = '$destination' where userid = '$userid'";
    $update = $conn->query($query);
    
    if($update){
        echo "Profile changed";
    }
}
?>