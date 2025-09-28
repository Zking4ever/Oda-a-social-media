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
    $name = $_POST['name'];
    $password = $_POST['password'];
    if($password==''){ 
        //if empty then save the old one
        $query = "SELECT password from users where userid = '$userid' limit 1";
        $excute = $conn->query($query);
        $row = $excute->fetch_assoc();
        $password = $row['password'];
    }else{
        $password = password_hash($password, PASSWORD_DEFAULT);
    }

    $result = $conn->query("SELECT username,userid from users");
    if($result->num_rows>0){
        while($row = $result->fetch_assoc()){
            if($username == $row['username'] && $userid != $row['userid']){
                echo "username already taken choose another one";
                die;
            }
        }
    }

    $excute = $conn->query("UPDATE users set username = '$username',name= '$name',password='$password' where userid = '$userid' ");
    if($excute){
        echo "setting saved successfully";
        die;
    }
    echo ("something went wrong..setting not saved");
}
  