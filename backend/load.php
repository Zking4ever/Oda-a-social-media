<?php
require "conn.php";
session_start();

if($_SESSION['userid'] ==''){
    header("location: index.html");
}
$userid = $_SESSION['userid'];

$data = [];
#loading the profile
$queryForUser= "SELECT * from users where userid= '$userid'";
$lookUser = $conn->query($queryForUser);
if($lookUser){
    $userData = $lookUser->fetch_assoc();
    $data['userinfo']=$userData;
}

#loading the posts
$query = "SELECT * from posts";
$result = $conn->query($query);

$post = "";
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        
        #here another query to find out the sende
        
        $queryForSenders = "SELECT * from users";
        $senders = $conn->query($queryForSenders);

        
        if($senders){
            while($sender = $senders->fetch_assoc()){

                if($sender["userid"] == $row['sender']){

                    $post.="<div class='post'>
                        <div class='sender'>
                            <img src='backend/".$sender['profile_source']."'>
                            <div class='detail'>
                                <h3 style='position:absolute;transform: translateY(-7px);'>".$sender['firstname']." ".$sender['lastname']."</h3>
                                <span style='font-size:12px;margin-left:7px;position:absolute;transform: translateY(10px);'>username</span>
                            </div>
                        </div>
                        <div class='img_container'>
                            <img src='backend/".$row['source']."'>
                        </div>
                        <div class='reactions'> 
                            <div class='react like'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                    <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                </svg>
                            </div>
                        </div>
                        <span class='caption'>".$row['caption']."</span>
                    </div>";
                    
                  }
                }
            }
        }
}
$data['posts']=$post;


#loading stories
$queryForSenders = "SELECT * from users";
$senders = $conn->query($queryForSenders);

$loadedStories ="";
if($senders->num_rows>0){
    while($sender = $senders->fetch_assoc()){
        
        #here another query to find out the senders stories
        
        $queryForStory = "SELECT * from stories";
        $stories = $conn->query($queryForStory);
            
        $id = $sender['userid'];
        $groupedStories = [];

        if($stories->num_rows>0){
            //group them by id to specify the sender
            while($story= $stories->fetch_assoc()){
              if($sender['userid'] == $story['sender']){

                    if(isset($groupedStories[$id])){
                        $groupedStories[$id] .= "<img src='backend/".$story['source']."' class='".$story['sender']."'>";
                    }else{
                        $groupedStories[$id] = "<img src='backend/".$story['source']."' class='".$story['sender']."'>";
                    }
                }
            }
            //stories of that user grouped now so send them
            if(!empty($groupedStories[$id])){
                    $loadedStories .= "<div class='story' onclick='see_story(event)' id=".$sender['userid'].">".$groupedStories[$id]."
                                       <span>".$sender['firstname']."</span>
                                     </div>";
            }

        }

    }
}
$data['stories'] = $loadedStories;

echo json_encode($data) ;

?>