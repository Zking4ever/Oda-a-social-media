<?php

if(isset($_POST['data_type']) && $_POST['data_type']=="post_reaction"){

    $react_type = $_POST['react_type'];
    $reaction = ($react_type=="likes" ? "liked" : "reposted");
    $postid = $_POST['postid'];
    $number = $_POST['number'];
    $status = $_POST['status'];

    #save the reacion to postreaction table
    if($status=='reacting'){
        $reactQuery = "SELECT * FROM postreaction where userid = '$userid' and  postid = '$postid' ";
        $excute = $conn->query($reactQuery);
        if($excute->num_rows>0){
            $saveQuery = "UPDATE postreaction set $reaction = 1 where userid = '$userid' and postid='$postid' ";
            $save = $conn->query($saveQuery);
            if(!$save){
                echo "error occured";
                die;
            }
        }else{
            $saveQuery = "INSERT into postreaction(userid,postid,$reaction) values ('$userid','$postid',1)";
            $save = $conn->query($saveQuery);
            if(!$save){
                echo "error occured";
                die;
            }
        }
    }elseif($status=='removing'){
        $reactQuery = "SELECT * FROM postreaction where userid = '$userid' and  postid = '$postid' ";
        $excute = $conn->query($reactQuery);
        if($excute->num_rows>0){
             $saveQuery = "UPDATE postreaction set $reaction = 0 where userid = '$userid' and postid='$postid' ";
            $save = $conn->query($saveQuery);
            if(!$save){
                echo "error occured";
                die;
            }
        }
    }
    #save the post number to db
    $query = "UPDATE posts set $react_type = '$number' where postid = '$postid' ";
    $excute = $conn->query($query);
    if($excute){
        echo "saved to db";
    }
}

if(isset($_POST['data_type']) && $_POST['data_type']=="post_comment"){

    $postid = $_POST['postid'];
    $number = $_POST['number']+1;
    $message = $_POST['message'];
    $commentid = createRand(25);

    #savereaction
    $reaction = "SELECT * from postreaction where userid='$userid' and postid = '$postid' ";
    $excute = $conn->query($reaction);
    if($excute->num_rows==0){
        $queryTosave = "INSERT into postreaction(userid,postid,commented) values ('$userid','$postid',1) ";
        $save = $conn->query($queryTosave);
        if(!$save){
            echo "error occured";
            die;
        }
    }else{
        $queryTosave = "UPDATE postreaction set commented = 1 where userid = '$userid' and postid = '$postid' ";
        $save = $conn->query($queryTosave);
        if(!$save){
            echo "error occured";
            die;
        }
    }
    #save the number to post table
    $querySaveNumber = "UPDATE posts set comments = '$number' where postid = '$postid' ";
    $saveN = $conn->query($querySaveNumber);
    if(!$saveN){
        echo "error occured";
        die;
    }


    $query = "INSERT into postcomments(commentid,postid,userid,comment) values ('$commentid','$postid','$userid','$message') ";
    $write = $conn->query($query);

    if($write){
        echo "commented";
    }
}


if(isset($_POST['data_type']) && $_POST['data_type']=="read_comment"){
    
    $postid = $_POST['postid'];
    $comments ="comments <svg class='cloth' onclick='clothPostComment(event)' width='28' height='28' fill='red' class='bi bi-x-circle' viewBox='0 0 16 16'>
                    <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16'/>
                    <path d='M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708'/>
                </svg> ";

    $query= "SELECT * from postcomments where postid = '$postid'";
    $result = $conn->query($query);
    if($result->num_rows==0){
        $comments .= "<div style='margin:auto;width:fit-content;'>No comments yet</div>";
    }else{
        while($com = $result->fetch_assoc()){
            $sender = $conn->query("SELECT username from users where userid = '$com[userid]' ")->fetch_assoc();
            $comments .= "<div class='comment'>
                                <div>
                                    <span>".$com['comment']."</span>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='13' height='13' fill='currentColor' class='bi bi-heart' viewBox='0 0 16 16'>
                                            <path d='m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15'/>
                                    </svg>
                                </div>
                                <div style='width:fit-content;align-self:flex-end;font-size:small;'>@".$sender['username']."</div>
                            </div>
                    ";
        }
    }
    
    echo $comments;

}