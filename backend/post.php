<?php
require "conn.php";

$caption = "";
$destination = "";
$sender = "unknown";
$like = 0;

if(isset($_POST)){
    $caption = $_POST['caption'];
}

if(isset($_FILES) && !empty($_FILES)){

    if($_FILES['file']['name']!='' && $_FILES['file']['error']==0){
             $folder = "uploades/";
             if(!file_exists($folder)){
                mkdir($folder,0777,true);
             }
             $destination = $folder. $_FILES['file']['name'];
             move_uploaded_file($_FILES['file']['tmp_name'],$destination);
    }
}

if($caption!= '' || $destination != ''){
    $postid = createRand(25);
    $query = "INSERT into posts (postid,sender,caption,likes,source) values ('$postid','$sender','$caption','$like','$destination')";
    $conn->query($query);

    $info = "Posted";
}
else{
    $info = "No input detected";
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