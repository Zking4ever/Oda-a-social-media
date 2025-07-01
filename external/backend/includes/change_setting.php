<?php

$destin ="";

if($_POST['request_type']=="change_profile_picture" && $_FILES['profile_image']['name']!=""){
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
            echo "Profile changed successfuly";
        }
    }
   
}
  