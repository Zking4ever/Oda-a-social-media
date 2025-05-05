<?php
require "conn.php";
session_start();
/*
if(isset($_POST) && $_POST['type']== "get_path"){
  #to get file path to prview
    $checkedResponse = $_FILES['file']['tmp_name'];

    echo $checkedResponse;
    
}
die;
*/

$caption = "";
$destination = "";
$sender = $_SESSION['userid'];
$like = 0;
$seen =0;

if(isset($_POST)){
    $caption = $_POST['caption'];
}

if(isset($_FILES) && !empty($_FILES)){

    if($_FILES['file']['name']!='' && $_FILES['file']['error']==0){
             $folder = "stories/";
             if(!file_exists($folder)){
                mkdir($folder,0777,true);
             }
             $destination = $folder. $_FILES['file']['name'];
             move_uploaded_file($_FILES['file']['tmp_name'],$destination);
    }
}

if($caption!= '' || $destination != ''){
    $storyid = createRand(25);
    $query = "INSERT into stories (storyid,sender,caption,likes,seen,source) values ('$storyid','$sender','$caption','$like','$seen','$destination')";
    $post = $conn->query($query);

    if($post==true){
       $info = "Posted";
    }
}

echo $info;

function createRand($size){
    $alphas = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','0','1','2','3','4','5','6','7','8','9');
    $length = rand(10,$size);

    $randWord = '';

    for($i=0;$i<$length;$i++){
        $r = rand(0,61);
        $randWord .= $alphas[$r];
    }
    return $randWord;
}
?>