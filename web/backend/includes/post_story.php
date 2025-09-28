<?php
session_start();

if(isset($_POST) && $_POST['type'] == "get_path"){

  #to get file path to prview
    $checkedResponse = '';
    
    if($_FILES['file']['name']!='' && $_FILES['file']['error']==0){
             $folder2 = "Previews/";
             if(!file_exists($folder2)){
                mkdir($folder2,0777,true);
             }
        $checkedResponse = $folder2.$_FILES['file']['name'];
        if(!file_exists($checkedResponse)){
             move_uploaded_file($_FILES['file']['tmp_name'],$checkedResponse);
        }
    }

    $_SESSION['destination'] = $checkedResponse;
    echo $checkedResponse;
    die;
    
}

$caption = "";
$destination = $_SESSION['destination'];
$sender = $_SESSION['userid'];
$like = 0;
$seen =0;

if(isset($_POST)){
    $caption = $_POST['caption'];
}

if($destination != ''){
    $storyid = createRand(25);
    global $conn;
    $query = "INSERT INTO stories (storyid,sender,caption,likes,seen,source) values ('$storyid','$sender','$caption','$like','$seen','$destination')";
    $post = $conn->query($query);

    if($post==true){
       $info = "Posted";
    }
}

echo $info;


?>