<?php

require "conn.php";
session_start();

if($_SESSION['userid'] ==''){
    header("location: index.html");
}
$userid = $_SESSION['userid'];

if(isset($_GET['request_type']) && $_GET['request_type']=="loadHome"){

    include "includes/loadHome.php";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadFriends"){

    echo "freinds";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadThoughts"){

    echo "Thoughts";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadAsks"){

    echo "ask me page";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadCouncelor"){

    echo "councelor";
}
elseif(isset($_GET['request_type']) && $_GET['request_type']=="loadSettings"){

    echo "setting";
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