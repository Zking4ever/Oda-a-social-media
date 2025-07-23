<?php

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


$query = "SELECT * from posts";
$result = $conn->query($query);

$post = "";
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        
        #here another query to find out the sender
        $queryForSenders = "SELECT userid,name,userid,username,source from users where userid = '$row[sender]' ";
        
        $sender = $conn->query($queryForSenders)->fetch_assoc();
                    $post.="<div class='post' >
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
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                    <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                    <path class='filled' fill-rule='evenodd' d='M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314'/>
                                </svg>
                                <span>".$row['likes']."</span>
                            </div>
                            <div ".(!empty($reactionStatus) && $reactionStatus['commented']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='postComments(event)'>
                                <svg  width='16' height='16' fill='currentColor' class='bi bi-chat-left-dots' viewBox='0 0 16 16'>
                                    <path d='M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z'/>
                                    <path d='M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0'/>
                                </svg>
                                <span>".$row['comments']."</span>
                            </div>
                            <div ".(!empty($reactionStatus) && $reactionStatus['reposted']==1? "class='react reacted' " : "class='react' "). " id=".$row['postid']." onclick='reactPost(event,2)'>
                                <svg width='16' height='16' fill='currentColor' class='bi bi-repeat' viewBox='0 0 16 16'>
                                    <path d='M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z'/>
                                </svg>
                                <span>".$row['reposts']."</span>
                            </div>
                        </div>
                        <span class='caption'>".$row['caption']."</span>
                    </div>";
        }
}else{
   $post.="<center class='post' style='border:none;'> <div> NO NEW POST..</div> </center>";

}
$post.="<center class='post' style='border:none;' id='postLOADER'> <div style='transform-origin:50% 50%;margin:10px;' class='loading'></div> </center>";

$data['posts']= $post;

echo json_encode($data);