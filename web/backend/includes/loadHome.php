<?php

$data = [];

if(!isset($_SESSION['seen_today'])){
    $_SESSION['seen_today'] = [];
}
#loading the posts
//already seen Posts?
$seenPosts= [];
$queryForSeenPosts = "SELECT seenPostData from seenposts where userid = '$userid' ";
$excute = $conn->query($queryForSeenPosts);
if($excute->num_rows>0){
    $seenPostData = $excute->fetch_assoc()['seenPostData'];//get the data
    $seenPosts = json_decode($seenPostData);//change back to array the returned data
}

    $valuesForQuery = '(';
    foreach ($seenPosts as $key => $value) {
        # code...
            $valuesForQuery .= $value.',';
    }
    $valuesForQuery .= ')';

$fetchedPost = [];

$query = "SELECT postid from posts";
$result = $conn->query($query);

if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        array_push($fetchedPost,$row['postid']);
    }
}

$response = subtractArray($fetchedPost,$seenPosts);

$post = "";

if(count($response)>0){
    //new post(not seen);
    $limit=0;
    foreach ($response as $key => $value) {
        # code...
        $limit++;
        if($limit==3){
            break;
        }
        $query = "SELECT * from posts where postid = '$value' ";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        //to avoid doublication on session variable lets check before adding a new value
            $search = array_search($row['postid'],$_SESSION['seen_today']);
            if(!$search && $search !== 0){
                $_SESSION['seen_today'][] = $row['postid'];
            }
        #here another query to find out the sender
            $queryForSenders = "SELECT userid,name,userid,username,source from users where userid = '$row[sender]' ";
            
            $sender = $conn->query($queryForSenders)->fetch_assoc();
                        $post.="<div class='post' onpointerenter='Post_seen(event)' onmousewheel='Post_seen(event)'>
                            <div class='sender' id=".$sender['userid']." onclick='get_profile(event)'>
                                <img src='backend/".$sender['source']."'>
                                <div class='detail'>
                                    <h3 style='position:absolute;transform: translateY(-7px);'>".$sender['name']."</h3>
                                    <span style='font-size:12px;margin-left:7px;position:absolute;transform: translateY(10px);'>@".$sender['username']."</span>
                                </div>
                            </div>
                            <div class='img_container'>
                                <img src='backend/".$row['source']."'>
                            </div>
                            <div class='reactions'>";

                            $queryforReaction = "SELECT * from postreaction where userid = '$userid' and postid = '$row[postid]' ";
                            $reactionStatus = $conn->query($queryforReaction)->fetch_assoc();

                            $post.="<div ".(!empty($reactionStatus) && $reactionStatus['liked']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,1)'>
                                    <svg width='30' height='25' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                        <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                        <path class='filled' fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>
                                    </svg>
                                    <span>".$row['likes']."</span>
                                </div>
                                <div ".(!empty($reactionStatus) && $reactionStatus['commented']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='postComments(event)'>
                                    <svg  width='30' height='25' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                                        <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                                        <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                    </svg>
                                    <span>".$row['comments']."</span>
                                </div>
                                <div ".(!empty($reactionStatus) && $reactionStatus['reposted']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,2)'>
                                    <svg width='30' height='25' fill='currentColor' class='bi bi-repeat' viewBox='0 0 16 16'>
                                        <path d='M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z'/>
                                    </svg>
                                    <span>".$row['reposts']."</span>
                                </div>
                            </div>
                            <span class='caption'>".$row['caption']."</span>
                        </div>";
    }
}else{
    //not seen today
    $filtered = subtractArray($fetchedPost,$_SESSION['seen_today']);
    if(count($filtered)>0){
        $limit=0; //for efficency only 3 posts are going to be loadded at a times
        foreach ($filtered as $key => $value) {
            # code...
        $limit++;
        if($limit==3){
            break;
        }
        $query = "SELECT * from posts where postid = '$value' ";
        $result = $conn->query($query);
        $row = $result->fetch_assoc();
        //to avoid doublication on session variable lets check before adding a new value
            $search = array_search($row['postid'],$_SESSION['seen_today']);
            if(!$search && $search !== 0){
                $_SESSION['seen_today'][] = $row['postid'];
            }
        #here another query to find out the sender
            $queryForSenders = "SELECT userid,name,userid,username,source from users where userid = '$row[sender]' ";
            
            $sender = $conn->query($queryForSenders)->fetch_assoc();
                        $post.="<div class='post' onpointerenter='Post_seen(event)' onmousewheel='Post_seen(event)'>
                            <div class='sender' id=".$sender['userid']." onclick='get_profile(event)'>
                                <img src='backend/".$sender['source']."'>
                                <div class='detail'>
                                    <h3 style='position:absolute;transform: translateY(-7px);'>".$sender['name']."</h3>
                                    <span style='font-size:12px;margin-left:7px;position:absolute;transform: translateY(10px);'>@".$sender['username']."</span>
                                </div>
                            </div>
                            <div class='img_container'>
                                <img src='backend/".$row['source']."'>
                            </div>
                            <div class='reactions'>";

                            $queryforReaction = "SELECT * from postreaction where userid = '$userid' and postid = '$row[postid]' ";
                            $reactionStatus = $conn->query($queryforReaction)->fetch_assoc();

                            $post.="<div ".(!empty($reactionStatus) && $reactionStatus['liked']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,1)'>
                                    <svg width='30' height='25' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                        <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                        <path class='filled' fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>
                                    </svg>
                                    <span>".$row['likes']."</span>
                                </div>
                                <div ".(!empty($reactionStatus) && $reactionStatus['commented']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='postComments(event)'>
                                    <svg  width='30' height='25' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                                        <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                                        <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                    </svg>
                                    <span>".$row['comments']."</span>
                                </div>
                                <div ".(!empty($reactionStatus) && $reactionStatus['reposted']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,2)'>
                                    <svg width='30' height='25' fill='currentColor' class='bi bi-repeat' viewBox='0 0 16 16'>
                                        <path d='M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z'/>
                                    </svg>
                                    <span>".$row['reposts']."</span>
                                </div>
                            </div>
                            <span class='caption'>".$row['caption']."</span>
                        </div>";
        }
    }else{
        //if there is no new post and already seen most of them today just here gonna display random of them
        if(count($fetchedPost)>0){

            $randomNo = rand(0,count($fetchedPost)-1);
            
            $query = "SELECT * from posts where postid = '$fetchedPost[$randomNo]' ";
            $result = $conn->query($query);
            $row = $result->fetch_assoc();
            //to avoid doublication on session variable lets check before adding a new value
                $search = array_search($row['postid'],$_SESSION['seen_today']);
                if(!$search && $search !== 0){
                    $_SESSION['seen_today'][] = $row['postid'];
                }
            #here another query to find out the sender
                $queryForSenders = "SELECT userid,name,userid,username,source from users where userid = '$row[sender]' ";
                $sender = $conn->query($queryForSenders)->fetch_assoc();
                            $post.="<div class='post' onpointerenter='Post_seen(event)' onmousewheel='Post_seen(event)'>
                                <div class='sender' id=".$sender['userid']." onclick='get_profile(event)'>
                                    <img src='backend/".$sender['source']."'>
                                    <div class='detail'>
                                        <h3 style='position:absolute;transform: translateY(-7px);'>".$sender['name']."</h3>
                                        <span style='font-size:12px;margin-left:7px;position:absolute;transform: translateY(10px);'>@".$sender['username']."</span>
                                    </div>
                                </div>
                                <div class='img_container'>
                                    <img src='backend/".$row['source']."'>
                                </div>
                                <div class='reactions'>";
                                $queryforReaction = "SELECT * from postreaction where userid = '$userid' and postid = '$row[postid]' ";
                                $reactionStatus = $conn->query($queryforReaction)->fetch_assoc();

                                $post.="<div ".(!empty($reactionStatus) && $reactionStatus['liked']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,1)'>
                                        <svg width='30' height='25' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                            <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                            <path class='filled' fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>
                                        </svg>
                                        <span>".$row['likes']."</span>
                                    </div>
                                    <div ".(!empty($reactionStatus) && $reactionStatus['commented']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='postComments(event)'>
                                        <svg  width='30' height='25' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                                            <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                                            <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                        </svg>
                                        <span>".$row['comments']."</span>
                                    </div>
                                    <div ".(!empty($reactionStatus) && $reactionStatus['reposted']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,2)'>
                                        <svg width='30' height='25' fill='currentColor' class='bi bi-repeat' viewBox='0 0 16 16'>
                                            <path d='M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z'/>
                                        </svg>
                                        <span>".$row['reposts']."</span>
                                    </div>
                                </div>
                                <span class='caption'>".$row['caption']."</span>
                            </div>";
            }

        }
}

$post.="<center class='post' style='border:none;padding-bottom:13px;' id='postLOADER'> <div style='width:30px;height:30px'><div style='width:15px;height:15px;' class='loading'><div></div> </center>";

$data['posts']= $post;
                
#-------------------------------------------------------------- Stories -------

$loadedStories="";

$queryForStory = "SELECT * from active_stories";
$stories = $conn->query($queryForStory);
$groupedStories = [];

if($stories->num_rows>0){
        while($story= $stories->fetch_assoc()){
           $id = $story['sender'];
            $senderQuery = "SELECT userid,name FROM users where userid = '$id' ";
            $sender= $conn->query($senderQuery)->fetch_assoc();
                        if(!isset($groupedStories[$id])){
                            $loadedStories .= "<div class='story' onclick='see_story(event)' id='".$story['sender']."'>
                                                    <span>".$sender['name']."</span>
                                                </div>";
                            $groupedStories[$id] = $id;
                        }
        }
}
/* 



#loading stories

/*
                $loadedStories .= "<div class='story' onclick='see_story(event)' id=".$story['sender'].">
                                       <span>"."AST"."</span>
                                     </div>";
            }
        }

        #here another query to find out the senders stories
        
        
            
        

        ...
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
                   ;;;
            }

        }

    }
}
*/


$data['stories'] = $loadedStories;


echo json_encode($data) ;

?>