<?php

$destin ="";

if($_POST['data_type']=="change_profile_picture" && $_FILES['profile_image']['name']!=""){
    if($_FILES['profile_image']['error'] ==0){
        $folder = "Profiles";
        if(!file_exists($folder)){
            mkdir($folder,0777,true);
        }
        $destin = $folder.'/'.$_FILES['profile_image']['name'];
       
        move_uploaded_file($_FILES['profile_image']['tmp_name'],$destin);
    } 

    if($destin!=""){
        $query = "UPDATE users set source = '$destin' where userid = '$userid' ";
        $excute = $conn->query($query);

        if($excute){
            echo "done";
            #echo "Profile changed successfuly";
        }
    }
   
}

if(isset($_POST['data_type']) && $_POST['data_type']=="save_setting"){
    
    $username = $_POST['username'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT username,userid from users");
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            if($username == $row['username'] && $userid != $row['userid']){
                echo "username already taken choose another one";
                die;
            }
        }
    }

    $excute = $conn->query("UPDATE users set username = '$username',firstname= '$firstname',lastname = 'lastame',password='$password' where userid = '$userid' ");
    if($excute){
        echo "setting saved successfully";
        die;
    }
    echo ("something went wrong..setting not saved");
}
  