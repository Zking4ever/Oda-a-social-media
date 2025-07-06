<?php

if(isset($_GET['request_type']) && $_GET['request_type']=="loadThoughts"){
    $thoughtList = "<style>
        .thoughts{
            width:99%;
            height:400px;
            margin:auto;
            overflow-Y:scroll;
        }
        .thoughtBox{
            width: 70%;
            min-height:fit-contents;
            margin:auto;
            padding:7px;
            border:solid thin;
            border-radius:7px;
            border:solid thin #9073de;
            margin-top:15px;
        }
        .thought{
            height:80%;
            margin:auto;
            background-color:azure;
            padding:5px 10px;
            border-radius:7px;
        }
        span{
            background-color:gray;
            padding:1px 7px;
            border-radius:6px;
            margin-left:10px;
            cursor:pointer;
        }
        .reacted{
            background-color:#9073de;
        }
           @media (max-width:760px){
            .thoughts{
                height:366px;
            }
            .thoughtBox{
                    width:87%
                }
            span{
                font-size:small;
                padding:1px 3px;
            }
        }
        </style>
        <div class = 'thoughts'>";

        $query = "SELECT * FROM thoughts";
        $excute = $conn->query($query);
        while($thought = $excute->fetch_assoc()){
            #another query whether the user has reacted or not
            $reactionquery = "SELECT * FROM reaction where thoughtid = '$thought[thoughtid]' and userid='$userid' ";
            $reaction = $conn->query($reactionquery)->fetch_assoc();
            $thoughtList .="<div class='thoughtBox'>
                                @".$thought['sendersUsername']." thinks:
                                    <div class='thought'>".$thought['content']."</div>
                                    <div style='margin-top:7px'  id='".$thought['thoughtid']."'>
                                        <span onclick='reactThoght(event,1)'".(!empty($reaction) && $reaction['liked']==1? "class='reacted'" : "")."> Like ".$thought['likes']." </span>  
                                        <span onclick='reactThoght(event,2)'".(!empty($reaction) && $reaction['disliked']==1? "class='reacted'" : "")."> dislikes ".$thought['dislikes']." </span> 
                                        <span onclick='seeComment(event)'".(!empty($reaction) && $reaction['commented']==1? "class='reacted'" : "")."> Comment ".$thought['comments']." </span> 
                                    </div>
                            </div>";
        }

        $thoughtList .=" </div>";

    echo $thoughtList;
}

if(isset($_POST['request_type']) && isset($_POST['data_type']) && $_POST['data_type']=="add_thought"){

    $message = $_POST['message'];
    $thoughtid = createRand(25);

    $profile = $conn->query("SELECT * FROM users where userid = '$userid' ")->fetch_assoc();
    $query = "INSERT into thoughts(thoughtid,sender,sendersUsername,content) values('$thoughtid','$userid','$profile[username]','$message') ";
    $excute = $conn->query($query);
    if($excute){
        echo "thought shared successfuly";
        die;
    }
    echo "error while sharing thought";
    
}
if(isset($_POST['request_type']) && isset($_POST['data_type']) && $_POST['data_type']=="react"){
    
    $thoughtid = $_POST['id'];
    $reaction_type = $_POST['reaction_type'];
    $reaction_no = $_POST['reaction_no'];
    $status = $_POST['status'];
    $saveType = ($reaction_type=="likes" ? "liked" : ($reaction_type=="dislikes" ? "disliked" : "commented"));
    if($status == "reacting"){
        //already intracted or not?
        $reactionquery = "SELECT * FROM reaction where thoughtid = '$thoughtid' and userid='$userid' ";
        $reaction = $conn->query($reactionquery);
        if($reaction->num_rows==0){

            $query = ($reaction_type=="likes" ? "INSERT into reaction(userid,thoughtid,liked) values('$userid','$thoughtid',1)" : ($reaction_type=="dislikes" ? "INSERT into reaction(userid,thoughtid,disliked) values('$userid','$thoughtid',1)" : ""));
            $excute = $conn->query($query);
            if(!$excute){
                echo "error ocured";
                die;
            }
        }else{
            $query = "UPDATE reaction set $saveType = 1 where userid = '$userid' and thoughtid ='$thoughtid' ";
            $excute = $conn->query($query);
            if(!$excute){
                echo "error ocured";
                die;
            }
        }
        
    }elseif($status == "remove"){
        $query = "UPDATE reaction set $saveType = 0 where userid = '$userid' and thoughtid = '$thoughtid' ";
        $excute = $conn->query($query);
            if(!$excute){
                echo "error ocured";
                die;
            }
    }

    $query = "UPDATE thoughts set $reaction_type = '$reaction_no' where thoughtid = '$thoughtid' ";
    $excute = $conn->query($query);
    if($excute){
        echo "done";
    }
}

if(isset($_POST['request_type']) && isset($_POST['data_type']) && $_POST['data_type']=="add_comment"){

    
    $comment = $_POST['message'];
    $commentid = createRand(25);
    $thoughtid = $_POST['thoughtid'];
    $reaction_no = $_POST['reaction_no']+1;

    //already intracted or not?
        $reactionquery = "SELECT * FROM reaction where thoughtid = '$thoughtid' and userid='$userid' ";
        $reaction = $conn->query($reactionquery);
        if($reaction->num_rows==0){
            $queryforStatus = "INSERT into reaction(userid,thoughtid,commented) values('$userid','$thoughtid',1)";
            $saveCommentStatus = $conn->query($queryforStatus);
            if(!$saveCommentStatus){
                echo "error occured";
                die;
            }
        }else{
            $queryforStatus = "UPDATE reaction set commented =1 where userid='$userid' and thoughtid='$thoughtid' ";
            $saveCommentStatus = $conn->query($queryforStatus);
            if(!$saveCommentStatus){
                echo "error occured";
                die;
            }
        }
    
    $increaseNoComment = "UPDATE thoughts set comments = '$reaction_no' where thoughtid = '$thoughtid' ";
    $excute = $conn->query($increaseNoComment);
    if(!$excute){
        echo "error occured";
        die;
    }
    $query = "INSERT into comments(commentid,thoughtid,userid,comment) values ('$commentid','$thoughtid','$userid','$comment') ";
    $excute = $conn->query($query);
    if($excute){
        echo "commented";
    }
}

if(isset($_POST['request_type']) && isset($_POST['data_type']) && $_POST['data_type']=="read_comment"){

    $thoughtid = $_POST['thoughtid'];

    $comments ="comments <svg class='cloth' onclick='clothComment(event)' width='28' height='28' fill='red' class='bi bi-x-circle' viewBox='0 0 16 16'>
                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                    <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>
                </svg> ";

    $query = "SELECT * FROM comments where thoughtid = '$thoughtid' ";
    $excute = $conn->query($query);
    if($excute->num_rows>0){
        while($com = $excute->fetch_assoc()){
            $commenter = $conn->query("SELECT username from users where userid = '$com[userid]' ")->fetch_assoc();
            $comments .= "<div class='comment'>
                    <div>
                        <span>".$com['comment']."</span>
                        <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                            <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                        </svg>
                    </div>
                    <div style='width:fit-content;align-self:flex-end;font-size:small;'>@".$commenter['username']."</div>
                </div>
           ";
        }
    }else{
         $comments .="<div style='margin:auto;width:fit-content;'>No comment on this thought</div> ";
    }
         

    echo $comments;
}
