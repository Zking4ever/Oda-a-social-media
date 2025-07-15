<?php

$relationid="";
if(isset($_SESSION['relationid'])){
    $relationid = $_SESSION['relationid'];
}
$chat ="";

if(isset($_POST['relationid']) && $_POST['data_type'] == "start_chat"){

    if(!isset($_SESSION['relationid']) || ($_SESSION['relationid'] != $_POST['relationid'])){
        $_SESSION['relationid'] = $_POST['relationid'];
    }
    $chat = "<style>
                .chat{
                    height:350px;
                    width:90%;
                    margin: 20px auto;
                    display:flex;
                }
                
                .listHolder{
                    flex:0.27;
                    overflow-Y:scroll;
                }
                .listHolder div{
                    display:flex;
                    gap:5px;
                    align-items:center;
                    margin:7px;
                    padding:3px;
                    border:solid thin #9073de;
                    border-radius:5px;
                    cursor:pointer;
                }
                .active{
                    background-color:#9073de;
                    color:azure;
                }
                .active .new{
                    background-color:azure;
                }
                .new{
                    background-color:azure;
                    position:absolute;
                    top:1px;
                    left:2%;
                    width:18px;
                    aspect-ratio:1;
                    font-size:12px;
                    border:solid thin;
                    border-radius:50%;
                    color:black;
                    text-align:center;
                }
                
                .chatHolder{
                    flex:0.73;
                    overflow-Y:scroll;
                    background-color: #efeaea;
                }
                .chatHolder .sent,
                .chatHolder .recieved{
                    width:97%;
                    min-height:28px;
                    display:flex;
                    gap:5px;
                    align-items:center;
                    margin:1%;
                    padding:3px;
                }
                .sent{
                    justify-content:end;
                    position:relative;
                }
                .profile{
                    width:40px;
                    height:40px;
                    border-radius:50%;
                    border:solid white;
                }
                .chatHolder div div:not(.files){
                    flex-direction:column;
                    background-color:white;
                    border-radius:12px;
                    max-width:70%;
                    width:fit-content;
                    overflow-wrap:break-word;
                    padding:5px;
                    text-align:right;
                }
                .chatHolder .profile{
                    align-self:end;
                    margin-bottom:8px;
                }
                .chatHolder div div span{
                    width:100%;
                    position:relative;
                }
                .status{
                    font-size:7px;
                    position:absolute;
                    padding:unset;
                    background-color:transparent;
                    right:-3px;
                    bottom:-8px;
                }
                .files{
                    display:unset;
                    width:100%;
                    display:grid;
                    grid-template-columns:50% 50%;
                    gap:4px;
                    max-width:unset;
                    font-size:small;
                }
                .files img{
                    width:98%;
                }
                .files .grid_exception{
                    width:200%;
                }
                @media (max-width:760px){
                .chat{
                    height:320px;
                    width:100%;
                    margin: 5px auto;
                }
                .profile{
                    width:22px;
                    height:22px;
                    border:solid thin white;
                }
                .listHolder{
                    flex:0.2;
                }
                .chatHolder{
                    flex:0.8;
                }
                .listHolder div{
                    flex-direction:column;
                    gap:2px;
                    margin:5px;
                    padding:2px;
                    font-size:small;
                    text-align:center;
                    border-radius:5px;
                }
            }
            @media (max-width:460px){
                .listHolder{
                    display:none;
                }
                .chatHolder{
                    flex:1;
                }
                .chatHolder div{
                    min-height:unset;
                }
            }
            </style>
                
            <div class='chat'>
                <div class='listHolder'>";
                $queryForFriend = "SELECT * FROM friends where person1 = '$userid' or person2 = '$userid' ";
                $friendArray = $conn->query($queryForFriend);
                
                while($friend=$friendArray->fetch_assoc()){
                    $friendid = $friend['person1'];
                    if($userid == $friendid){
                        $friendid =$friend['person2'];
                    }
                        $queryFriendProfiles = "SELECT * from users where userid='$friendid' ";
                        $friendProfileResponse = $conn->query($queryFriendProfiles);
                        $friendProfile = $friendProfileResponse->fetch_assoc();
                        //new message?
                        $queryForNewMessage = "SELECT * from chats where relationid = '$friend[relationid]' and sender != '$userid' and status='sent' ";
                        $result = $conn->query($queryForNewMessage);

                        $chat.="<div id='".$friend['relationid']."' onclick='startChat(event)' ".
                            ($_SESSION['relationid'] == $friend['relationid'] ? "class = 'active' " : " ")." style='position:relative;'>".
                                  (!empty($result)&&$result->num_rows>0 ? "<span class='new'>".$result->num_rows."</span>" : "")  
                                    ."<img class='profile' src='backend/".$friendProfile['source']."'> <span>".$friendProfile['firstname']." ".$friendProfile['lastname']."</span>
                            </div>";
                }
            
                $chat.="</div>
                <div class='chatHolder'>";
            //query to get history messages
                $query = "SELECT * from chats where relationid = '$relationid'";
                $excute = $conn->query($query);
                    if($excute->num_rows>0){
                        while($row = $excute->fetch_assoc()){
                            $sender = $row['sender'];
                            //file checking
                            $queryForfile = "SELECT * from chatfiles where messageid = '$row[messageid]'";
                            $File = $conn->query($queryForfile);
                            if($userid == $sender){
                               if($File->num_rows==0){
                                    $queryForProfile = "SELECT * from users where userid = '$userid'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chat .=" <div class='sent'><div><span>".$row['message']."<span class='status'>".($row['status']=='seen' ? "✔️✔️" : "✔️")."</span></span></div> <img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'></div>";
                                }else{
                                    $queryForProfile = "SELECT * from users where userid = '$userid'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chat .=" <div class='sent'><div> <div class='files'>";
                                    while($file = $File->fetch_assoc()){
                                        if($file["type"]=="image/gif"||$file["type"]=="image/png"||$file["type"]=="image/jpg" || $file["type"]=="image/jpeg"){
                                            $chat.="<a target='_blank' ".($File->num_rows==1 ? "class='grid_exception'" : "")."href='backend/".$file['source']."'><img src=backend/".$file['source']."> </a>";
                                        }else{
                                            $chat.="<a target='_blank' class='grid_exception' href='backend/".$file['source']."'>".$file['filename']."</a>";
                                        }
                                    }
                                    
                                    $chat .= "</div><span>".$row['message']."<span class='status'>".($row['status']=='seen' ? "✔️✔️" : "✔️")."</span></span></div> <img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'></div>";
                                }
                            }else{
                                if($File->num_rows==0){
                                    $queryForProfile = "SELECT * from users where userid = '$sender'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chat .="<div class='recieved'><img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'> <div> <span>".$row['message']."</span></div></div>";
                                }
                                else{
                                    $queryForProfile = "SELECT * from users where userid = '$sender'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chat .="<div class='recieved'><img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'> <div><div class='files'>";
                                    while($file = $File->fetch_assoc()){
                                        if($file["type"]=="image/gif"||$file["type"]=="image/png"||$file["type"]=="image/jpg" || $file["type"]=="image/jpeg"){
                                            $chat.="<a target='_blank' ".($File->num_rows==1 ? "class='grid_exception'" : "")."".($File->num_rows==1 ? "class='grid_exception'" : "")."href='backend/".$file['source']."'><img src=backend/".$file['source']."> </a>";
                                        }else{
                                            $chat.="<a target='_blank' class='grid_exception' href='backend/".$file['source']."'>".$file['filename']."</a>";
                                        }
                                    }
                                    
                                    $chat.="</div><span>".$row['message']."</span></div></div>";
                                }
                            }
                        }
                    }else{
                        $chat.="<center style='margin:20px auto;'> No message history found </center>";
                    }
                    
    $chat .="</div>
    </div>";

    echo $chat;
}

if($relationid != "" && $_POST['data_type']=="send_message"){

    $message = $_POST['message'];
    $messageid = createRand(25);
   
    if(isset($_FILES) ){
        $fileNumber = $_POST['filesNumber'];
        for($i=0;$i<$fileNumber;$i++){
            //each file going to be processed here
            $destination = "";
            $filename = $_FILES['file'.$i]['name'];
            $fileid = createRand(25);
            $type ="";
            if($_FILES['file'.$i]['name']!="" && $_FILES['file'.$i]['error']==0){
                
                $folder = "ChatFiles/";
                if(!file_exists($folder)){
                    mkdir($folder,0777,true);
                }
                $destination = $folder.$_FILES['file'.$i]['name'];
                $type = $_FILES['file'.$i]['type'];
                move_uploaded_file($_FILES['file'.$i]['tmp_name'],$destination);
            }
            if($destination!=""){
                $query = "INSERT into chatfiles(fileid,messageid,filename,source,type) values('$fileid','$messageid','$filename','$destination','$type') ";
                $excute = $conn->query($query);
                if(!$excute){ 
                    continue; 
                } 
            }
        }
    }
    $query = "INSERT into chats(messageid,relationid,sender,message,status) values ('$messageid','$relationid','$userid','$message','sent')";
    $excute = $conn->query($query);
    if($excute){
        echo "message sent";
    }

}

if(isset($_SESSION['relationid'])&& $_POST['data_type']=="read"){

    
    $chatHistory = "";
            //query to get history messages
                $query = "SELECT * from chats where relationid = '$relationid'";
                $excute = $conn->query($query);
                    if($excute->num_rows>0){
                          while($row = $excute->fetch_assoc()){
                            $sender = $row['sender'];
                            //file checking
                            $queryForfile = "SELECT * from chatfiles where messageid = '$row[messageid]'";
                            $File = $conn->query($queryForfile);
                            if($userid == $sender){
                               if($File->num_rows==0){
                                    $queryForProfile = "SELECT * from users where userid = '$userid'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chatHistory .=" <div class='sent'><div><span>".$row['message']."<span class='status'>".($row['status']=='seen' ? "✔️✔️" : "✔️")."</span></span></div> <img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'></div>";
                                }else{
                                    $queryForProfile = "SELECT * from users where userid = '$userid'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chatHistory .=" <div class='sent'><div> <div class='files'>";
                                    while($file = $File->fetch_assoc()){
                                        if($file["type"]=="image/gif"||$file["type"]=="image/png"||$file["type"]=="image/jpg" || $file["type"]=="image/jpeg"){
                                            $chatHistory.="<a target='_blank' ".($File->num_rows==1 ? "class='grid_exception'" : "")."href='backend/".$file['source']."'><img src=backend/".$file['source']."> </a>";
                                        }else{
                                            $chatHistory.="<a target='_blank' class='grid_exception' href='backend/".$file['source']."'>".$file['filename']."</a>";
                                        }
                                    }
                                        
                                    $chatHistory .= "</div><span>".$row['message']."<span class='status'>".($row['status']=='seen' ? "✔️✔️" : "✔️")."</span></span></div> <img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'></div>";
                                }
                            }else{
                                if($File->num_rows==0){
                                    $queryForProfile = "SELECT * from users where userid = '$sender'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chatHistory .="<div class='recieved'><img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'> <div> <span>".$row['message']."</span></div></div>";
                                }
                                else{
                                    $queryForProfile = "SELECT * from users where userid = '$sender'";
                                    $profile = $conn->query($queryForProfile)->fetch_assoc();
                                    $chatHistory .="<div class='recieved'><img class='profile' id='".$profile['userid']."' onclick='get_profile(event)' src='backend/".$profile['source']."' style='cursor:pointer'> <div><div class='files'>";
                                    while($file = $File->fetch_assoc()){
                                        if($file["type"]=="image/gif"||$file["type"]=="image/png"||$file["type"]=="image/jpg" || $file["type"]=="image/jpeg"){
                                            $chatHistory.="<a target='_blank' ".($File->num_rows==1 ? "class='grid_exception'" : "")."href='backend/".$file['source']."'><img src=backend/".$file['source']."> </a>";
                                        }else{
                                            $chatHistory.="<a target='_blank' class='grid_exception' href='backend/".$file['source']."'>".$file['filename']."</a>";
                                        }
                                    }
                                    
                                    $chatHistory.="</div><span>".$row['message']."</span></div></div>";
                                }
                            }
                        }
                    }else{
                        $chatHistory.="<center style='margin:20px auto;'> No message history found </center>";
                    }
        //change the status
        $query = "SELECT messageid from chats where relationid = '$relationid' and sender != '$userid'";
        $excute = $conn->query($query);
        if($excute->num_rows>0){
            while($row = $excute->fetch_assoc()){
                $query1 = "UPDATE chats set status='seen' where relationid = '$relationid' and messageid = '$row[messageid]'";
                $excute1 = $conn->query($query1);
                if(!$excute1){
                    echo "error occured";
                    die;
                }
            }
        }
        echo $chatHistory;
}