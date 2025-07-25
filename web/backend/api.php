<?php

require "conn.php";
session_start();

if($_SESSION['userid'] =='' || !isset($_SESSION['userid'])){
    header("location: loged out.php");
}
$userid = $_SESSION['userid'];

if(isset($_GET['request_type']) && $_GET['request_type']=="loadHome"){

    include "includes/loadHome.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadFriends"){

    include "includes/loadFriends.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadThoughts"){
    
    include "includes/thoughts.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="askAI"){

    include "includes/askAI.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadCouncelor"){

    echo "councelor";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadSettings"){

    include "includes/loadSetting.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="add_post"){
    
    include "includes/post.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="add_story"){
    
    include "includes/post_story.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="get_stories"){
    
    include "includes/getStories.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="differentiate"){
    
    include "includes/differentiateStories.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="see_story"){
    
    include "includes/differentiateStories.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="resonse_to_suggestion"){
    
    include "includes/responseRequest.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="setting"){
    include "includes/change_setting.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="chat"){
    include "includes/chat.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="thought"){
    include "includes/thoughts.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="post_reaction"){
    include "includes/reactToPost.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="profile"){

    include "includes/loadProfile.php";
}
if(isset($_GET['request_type']) && $_GET['request_type']=="fetch_post"){

    include "includes/fetch_posts.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="fetch_thought"){

    include "includes/fetch_thoughts.php";
}
elseif(isset($_POST) && isset($_POST['request_type']) && $_POST['request_type']=="logout"){

    session_destroy();
    echo "loged out";
}


#-----------functions-----


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



function subtractArray($firstArray,$secondArray){
    $answer = array();
    foreach ($firstArray as $key => $f) {
        $counter = 0;
        foreach ($secondArray as $key => $s) {
            if($s!=$f){
                $counter++;
            }
        }
        if($counter==count($secondArray)){
                array_push($answer,$f);
        }
    }
    return $answer;
}