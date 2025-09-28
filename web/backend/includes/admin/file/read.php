<?php

if(isset($_POST) && isset($_POST['request']) && $_POST['request']=="admin"){

    if(isset($_POST['id'])){
        //user related data
        $response = [];
            $personid =  $_POST['id'];
            $query = "SELECT postid,caption,source,likes,comments,reposts from posts where sender='$personid' ";
            $excute = $conn->query($query);
            $posts = "";
            if($excute){
                while($row = $excute->fetch_assoc()){
                    $posts .= "<div class='post' id=".$row['postid'].">
                            <img source='backend/".$row['source']."'>
                            <p>".$row['caption']."</p>
                            <h2>likes ".$row['likes']." | comments ".$row['comments']." | reposts  ".$row['reposts']."</h2>
                        </div>";
                }
            }
        $response['posts'] = $posts;

            $stories = "";
            $query = "SELECT storyid,caption,source,likes,seen from stories where sender='$personid' ";
            $excute = $conn->query($query);
            if($excute){
                while($row = $excute->fetch_assoc()){
                    $stories .= "<div class='story' id=".$row['storyid'].">
                            <img source='backend/".$row['source']."'>
                            <p>".$row['caption']."</p>
                            <h2>likes ".$row['likes']." | seen ".$row['seen']."</h2>
                        </div>";
                }
            }
        $response['stories'] =  $stories;

            $query = "SELECT person1,person2 from friends where person1='$personid' or person2='$personid' ";
            $excute = $conn->query($query);
            $friends = "";
            if($excute){
                while($row = $excute->fetch_assoc()){
                    $friendid = $row['person1'];
                    if($friendid == $personid){
                        $friendid = $row['person2'];
                    }
                    $info = $conn->query("SELECT name from users where userid = '$friendid'")->fetch_assoc();
                    $friends .= "<h3 id=".$friendid.">".$info['name']."</h3>";
                }
            }
        $response['friends'] = $friends;

        $Profile = $conn->query("SELECT source from users where userid = '$personid' ")->fetch_assoc();
        $response['profile'] = 'backend/'.$Profile['source'];

            
        echo json_encode($response);

        }
        elseif(isset($_POST['info'])){
            //dete post or story
            $info = json_decode($_POST['info']);
            if($info[1]=="story"){
                $storyinfo = $conn->query("SELECT*FROM stories where storyid= '$info[0]' ")->fetch_assoc();
                $storyinfo = json_encode($storyinfo);
                $queryD = "INSERT into deleted(type,info) values('story','$storyinfo' )";
                $excuteD = $conn->query($queryD);
                if($excuteD){
                    $query = "DELETE FROM stories where storyid = '$info[0]' ";
                    $excute = $conn->query($query);
                    if($excute){
                        echo "deleted";
                         die;
                     }
                }
                
            }elseif($info[1]=="post"){

                $postinfo = $conn->query("SELECT * FROM posts where postid ='$info[0]' ")->fetch_assoc();
                $postinfo = json_encode($postinfo);
                $queryD = "INSERT into deleted (type,info) values ('post','$postinfo' )";
                $excuteD = $conn->query($queryD);
                if($excuteD){
                    $query = "DELETE FROM posts where postid = '$info[0]' ";
                    $excute = $conn->query($query);
                    if($excute){
                        echo "deleted";
                        die;
                    }
                }
            }
        }elseif(isset($_POST['deleteUser'])){
            //delete a user
            $deleteUserid = $_POST['deleteUser'];
            $userData = $conn->query("SELECT*FROM users where userid = '$deleteUserid' ")->fetch_assoc();
            $userData = json_encode($userData);
            $queryD = "INSERT into deleted(type,info) values('user','$userData' )";
            $excuteD = $conn->query($queryD);
                if($excuteD){
                    $query = "DELETE from users where userid='$deleteUserid' ";
                    $excute = $conn->query($query);
                    if($excute){
                        echo "deleted";
                    }
                }
        }
        else{
            $query = "SELECT userid,name from users";
            $excute = $conn->query($query);
            $response = "";
            if($excute){
                while($row = $excute->fetch_assoc()){
                    $response .= "<h3 id=".$row['userid'].">".$row['name']."</h3>";
                }
            }
            $response .= "<div style='text-align:center;color:var(--txt-color)'>There are total of ".$excute->num_rows." users registered on ODA";
            echo json_encode($response);
        }

}
