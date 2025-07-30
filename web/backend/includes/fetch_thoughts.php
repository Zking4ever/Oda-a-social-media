<?php

$thoughtList = "";

$seen = [];
$query = "SELECT seenThoughtData from seenthoughts where userid='$userid' ";
$excute = $conn->query($query);
if($excute->num_rows>0){
    $seen = $excute->fetch_assoc()['seenThoughtData'];
    $seen = json_decode($seen);
}
$allThoughts = [];
$query = "SELECT thoughtid FROM thoughts";
$excute = $conn->query($query);
while($row = $excute->fetch_assoc()){
    $allThoughts[] = $row['thoughtid'];
}

//first if a new exist or any unseen thought

$new = subtractArray($allThoughts,$seen);
    if(count($new)>0){
        for($i=0;$i<4 && $i<count($new);$i++){
            if(!isMember($new[$i],$_SESSION['seen_today_thoughts'])){
                $_SESSION['seen_today_thoughts'][] = $new[$i];
            }
             $query = "SELECT * FROM thoughts where thoughtid = '$new[$i]'";
             $excute = $conn->query($query);
             $thought = $excute->fetch_assoc();
             #another query whether the user has reacted or not
            $reactionquery = "SELECT * FROM reaction where thoughtid = '$thought[thoughtid]' and userid='$userid' ";
            $reaction = $conn->query($reactionquery)->fetch_assoc();
             $thoughtList .="<div class='thoughtBox' onmouseenter='seeThought(event)'>
                                <div style='display:flex'><div onclick='get_profile(event)' id='".$thought['sender']."' style='width:fit-content;cursor:pointer'>@".$thought['sendersUsername']."</div> &nbsp thinks:</div>
                                    <div class='thought'>".$thought['content']."</div>
                                    <div style='margin-top:7px'  id='".$thought['thoughtid']."'>
                                        <span onclick='reactThoght(event,1)'".(!empty($reaction) && $reaction['liked']==1? "class='reacted'" : "")."> Like ".$thought['likes']." </span>  
                                        <span onclick='reactThoght(event,2)'".(!empty($reaction) && $reaction['disliked']==1? "class='reacted'" : "")."> Dislike ".$thought['dislikes']." </span> 
                                        <span onclick='seeComment(event)'".(!empty($reaction) && $reaction['commented']==1? "class='reacted'" : "")."> Comment ".$thought['comments']." </span> 
                                    </div>
                            </div>";
        }

    }else{

        //if there is no new thought just bring those old which aren't seen today
        $filtered = subtractArray($allThoughts,$_SESSION['seen_today_thoughts']);
        if(count($filtered)>0){
            for($i=0;$i<4 && $i<count($filtered);$i++){
                if(!isMember($filtered[$i],$_SESSION['seen_today_thoughts'])){
                    $_SESSION['seen_today_thoughts'][] = $filtered[$i];
                }
                $query = "SELECT * FROM thoughts where thoughtid = '$filtered[$i]'";
                $excute = $conn->query($query);
                $thought = $excute->fetch_assoc();
                #another query whether the user has reacted or not
                $reactionquery = "SELECT * FROM reaction where thoughtid = '$thought[thoughtid]' and userid='$userid' ";
                $reaction = $conn->query($reactionquery)->fetch_assoc();
                $thoughtList .="<div class='thoughtBox' onmouseenter='seeThought(event)'>
                                    <div style='display:flex'><div onclick='get_profile(event)' id='".$thought['sender']."' style='width:fit-content;cursor:pointer'>@".$thought['sendersUsername']."</div> &nbsp thinks:</div>
                                        <div class='thought'>".$thought['content']."</div>
                                        <div style='margin-top:7px'  id='".$thought['thoughtid']."'>
                                            <span onclick='reactThoght(event,1)'".(!empty($reaction) && $reaction['liked']==1? "class='reacted'" : "")."> Like ".$thought['likes']." </span>  
                                            <span onclick='reactThoght(event,2)'".(!empty($reaction) && $reaction['disliked']==1? "class='reacted'" : "")."> Dislike ".$thought['dislikes']." </span> 
                                            <span onclick='seeComment(event)'".(!empty($reaction) && $reaction['commented']==1? "class='reacted'" : "")."> Comment ".$thought['comments']." </span> 
                                        </div>
                                </div>";
            }
        }else{
            //if there is no new and user has seen all already so the remaining option is to make the invisibles visible
            if(isset($_POST['visibles'])){
                $visibles = json_decode($_POST['visibles']);
                $invisibles = subtractArray($allThoughts,$visibles);
                if(count($invisibles)>0){
                        $fetchedNow = [];
                        for($i=0; $i<4 && $i<count($invisibles);$i++){
                            
                            $rand = rand(0,count($invisibles)-1);
                            while(isMember($rand,$fetchedNow)){
                                $rand = rand(0,count($invisibles)-1);
                            }
                            $thoughtID = $invisibles[$rand];
                            if(!isMember($thoughtID,$_SESSION['seen_today_thoughts'])){
                                $_SESSION['seen_today_thoughts'][] = $thoughtID;
                            }
                            $fetchedNow[] = $rand;
                            $query = "SELECT * FROM thoughts where thoughtid='$thoughtID'";
                            $excute = $conn->query($query);
                            $thought = $excute->fetch_assoc();
                                #another query whether the user has reacted or not
                                $reactionquery = "SELECT * FROM reaction where thoughtid = '$thought[thoughtid]' and userid='$userid' ";
                                $reaction = $conn->query($reactionquery)->fetch_assoc();
                                $thoughtList .="<div class='thoughtBox' onmouseenter='seeThought(event)'>
                                                    <div style='display:flex'><div onclick='get_profile(event)' id='".$thought['sender']."' style='width:fit-content;cursor:pointer'>@".$thought['sendersUsername']."</div> &nbsp thinks:</div>
                                                        <div class='thought'>".$thought['content']."</div>
                                                        <div style='margin-top:7px'  id='".$thought['thoughtid']."'>
                                                            <span onclick='reactThoght(event,1)'".(!empty($reaction) && $reaction['liked']==1? "class='reacted'" : "")."> Like ".$thought['likes']." </span>  
                                                            <span onclick='reactThoght(event,2)'".(!empty($reaction) && $reaction['disliked']==1? "class='reacted'" : "")."> Dislike ".$thought['dislikes']." </span> 
                                                            <span onclick='seeComment(event)'".(!empty($reaction) && $reaction['commented']==1? "class='reacted'" : "")."> Comment ".$thought['comments']." </span> 
                                                        </div>
                                                </div>";
                        }
                }else{
                      $thoughtList .="<center class='thoughtBox' style='border:none;'><div>No new thought found..</div></center>";
                }
            }
            
        }
    }

    $thoughtList .="<center class='thoughtBox' style='animation:loaderapear 2s ease;animation-timeline:view();animation-range:0% 40%;height:40px;border:none;' id='thoughtLoader'>
                        <div class='loading' style='width:15px;height:15px;margin:5px;'></div>
                </center> </div>";
    echo $thoughtList;