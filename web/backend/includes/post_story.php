<?php


if(isset($_POST) && $_POST['type'] == "get_path"){

  #to get file path to prview
    $checkedResponse = '';
    
    if($_FILES['file']['name']!='' && $_FILES['file']['error']==0){
             $folder2 = "Previews/";
             if(!file_exists($folder2)){
                mkdir($folder2,0777,true);
             }
        $checkedResponse = $folder2. $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'],$checkedResponse);
    }

    echo $checkedResponse;
    die;
    
}

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
             if(!file_exists($destination)){    //avoid uploading existing file
                move_uploaded_file($_FILES['file']['tmp_name'],$destination);
             }
    }
}

if($destination != ''){
    $storyid = createRand(25);
    $query = "INSERT into stories (storyid,sender,caption,likes,seen,source) values ('$storyid','$sender','$caption','$like','$seen','$destination')";
    $post = $conn->query($query);

    if($post==true){
       $info = "Posted";
    }
}

echo $info;


?>