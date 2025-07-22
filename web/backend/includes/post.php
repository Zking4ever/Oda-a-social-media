<?php


$caption = "";
$destination = "";
$sender = $_SESSION['userid'];
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
    $post = $conn->query($query);

    if($post==true){
       $info = "Posted";
    }
}
else{
    $info = "No input detected";
}


echo $info;

?>