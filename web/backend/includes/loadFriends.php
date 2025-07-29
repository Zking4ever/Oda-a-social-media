<?php

$data = [];

        $query = "SELECT * from friend_requests where receiver = '$userid' and status ='pending' ";
        $result = $conn->query($query);

        $friendsRequests = "";
        if($result->num_rows>0){
            $friendsRequests.="<fieldset class='fieldset'>
                                <legend>Friend Requests</legend>
                                <div class='F_request'>";
            while($row = $result->fetch_assoc()){
                
                $senderid = $row['sender'];
                #here another query to find out the sender  
                $queryForSenders = "SELECT name,username,userid,source from users where userid='$senderid' ";
                $senderArray = $conn->query($queryForSenders);
                $sender=$senderArray->fetch_assoc();
                $friendsRequests.="
                        <div class='f_request'>
                            <img id='".$sender['userid']."' onclick='get_profile(event)' src='backend/".$sender['source']."'>
                            <div class='detail'>
                                <h3>".$sender['name']."</h3>
                                <span style='font-size:12px;margin-left:7px;'>".$sender['username']."</span>
                                <div style='transform:translateY(4px)'> <button onclick='response(`".$sender['userid']."`,`".$row['relationid']."`)'>confirm</button> <button onclick='remove(event)'>remove</button> </div>
                            </div>
                        </div>";
                            
                }
            $friendsRequests.="</div>
            </fieldset>";
        }
                    
        $data['F_request']=  $friendsRequests;
           
#---------------------------------------

    $friendsquery = "SELECT * from friends where person1 = '$userid' or person2 = '$userid' ";
    $freindsResult = $conn->query($friendsquery);

    $friends = "";

    if($freindsResult->num_rows>0){
        $friends.="<legend style='margin:5px'>Freinds</legend>
                                <div class='Freinds'>";
        while($friend = $freindsResult->fetch_assoc()){
            
            $relationid = $friend['relationid'];
            $friendid = $friend['person1'];
            if($userid == $friendid){
                $friendid = $friend['person2'];
            }
            
                #here another query to find out the friend data to get the profile  
                $queryForFriend = "SELECT name,username,userid,source from users where userid='$friendid' ";
                $friendArray = $conn->query($queryForFriend);
                $friend=$friendArray->fetch_assoc();
                 //new message?
                $queryForNewMessage = "SELECT messageid from chats where relationid = '$relationid' and sender != '$userid' and status='sent' ";
                $result = $conn->query($queryForNewMessage);

                $friends.="<div class='friend' style='margin:5px'>
                                        <img id='$friend[userid]' onclick='get_profile(event)' src='backend/".$friend['source']."'>".
                                        (!empty($result)&&$result->num_rows>0 ? "<span style='position:absolute;left:4%;transform:translateY(-10px);font-size:small;width:17px;aspect-ratio:1;text-align:center;border:solid thin;border-radius:50%;background-color:azure;'>".$result->num_rows."</span>" : "")
                                        ."<div class='detail'>
                                            <h3>".$friend['name']."</h3>
                                            <span style='font-size:12px;margin-left:7px;'>".$friend['username']."</span>
                                        </div>
                                        <i class='bi bi-chat-square-text' id='$relationid' onclick='startChat(event)'></i>
                                    </div>";
            }
        $friends.="</div>";
    }

    
    $data['friends']= $friends;
#--------------------------------------- suggestion ---------
//lets get request the user already have sent to avoid dublication
$Connections = array();
$i=0;

$query = "SELECT * FROM friend_requests where sender = '$userid' or receiver = '$userid' ";
$execute = $conn->query($query);
    if($execute->num_rows>0){
        while($row = $execute->fetch_assoc()){
            $rowid = $row['sender'];
            if($userid == $rowid){
                $rowid = $row['receiver'];
            }
            $Connections[$i] = $rowid;
            $i++;
        }
}

//now the suggestion
    $query = "SELECT name,username,userid,source from users where userid != '$userid'";
    $result = $conn->query($query);
        
    $friendSuggestions = "";

        if($result->num_rows>0){
             $friendSuggestions.="<legend style='margin:5px'>Suggestions</legend>
                            <div class='F_suggestion'>";
            $limit=0;

            while($row = $result->fetch_assoc()){
                if(!checkConnection($row['userid'],$Connections)){

                    $friendSuggestions.="
                                    <div class='f_sug'>
                                        <div style='width:100%;height:130px;display:flex;align-items:center;justify-contents:center;overflow:hidden;border-radius:10px;background-color:#c3dcef9c;' title='see profile'><img id='".$row['userid']."' onclick='get_profile(event)' src=backend/".$row['source']." alt='profile picture'></div>
                                        <div class='detail'>
                                            <h3>".$row['name']."</h3>
                                            <span style='font-size:12px;margin-left:7px;'>@".$row['username']."</span>
                                            <div style='transform:translateY(4px)'> <button onclick='request(`".$row['userid']."`,`1`)'>Send Request</button> <button onclick='remove(event)'>remove</button> </div>
                                        </div>
                                    </div>";
                            $limit++;
                            if($limit==12){
                                break;
                            }
                }
            }
                $friendSuggestions.="</div>";
        }

        $data['F_suggestion']= $friendSuggestions;
    
//friend suggestions filtering function

#two things are here friends don't have to be suggested again and the one that are already sent the request should't do it twice
function checkConnection($userid,$array){
    
    for ($i=0; $i < count($array) ; $i++) { 
                    # code...
            if($array[$i] == $userid){
                return true;
            }
    }
    return false;
}

echo json_encode($data) ;

?>