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
                                        <span onclick='reactThoght(event,3)'".(!empty($reaction) && $reaction['commented']==1? "class='reacted'" : "")."> Comment ".$thought['comments']." </span> 
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

            $query = ($reaction_type=="likes" ? "INSERT into reaction(userid,thoughtid,liked) values('$userid','$thoughtid',1)" : ($reaction_type=="dislikes" ? "INSERT into reaction(userid,thoughtid,disliked) values('$userid','$thoughtid',1)" : "INSERT into reaction(userid,thoughtid,commented) values('$userid','$thoughtid',1)"));
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