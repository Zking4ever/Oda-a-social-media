<?php

$data = [];


        $query = "SELECT * from Friend_requests where receiver = '$userid' and status ='pending' ";
        $result = $conn->query($query);

        $friendsRequests = "";
        if($result->num_rows>0){
            $friendsRequests.="<fieldset class='fieldset'>
                                <legend>Friend Requests</legend>
                                <div class='F_request'>";
            while($row = $result->fetch_assoc()){
                
                $senderid = $row['sender'];
                #here another query to find out the sender  
                $queryForSenders = "SELECT * from users where userid='$senderid' ";
                $senderArray = $conn->query($queryForSenders);
                $sender=$senderArray->fetch_assoc();
                $friendsRequests.="
                        <div class='f_request'>
                            <img src='backend/".$sender['source']."'>
                            <div class='detail'>
                                <h3>".$sender['firstname']." ".$sender['lastname']."</h3>
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
    $fr_array = array();
    $i=0;

    if($freindsResult->num_rows>0){
        $friends.="<legend style='margin:5px'>Freinds</legend>
                                <div class='Freinds'>";
        while($friend = $freindsResult->fetch_assoc()){

            $relationid = $friend['relationid'];
            $friendid = $friend['person1'];
            if($userid == $friendid){
                $friendid = $friend['person2'];
            }
            $fr_array[$i] = $friendid;
            $i++;
                #here another query to find out the freind sp to get the profile  
                $queryForFriend = "SELECT * from users where userid='$friendid' ";
                $friendArray = $conn->query($queryForFriend);
                $friend=$friendArray->fetch_assoc();
                
                $friends.="<div class='friend'>
                                        <img src='backend/".$friend['source']."'>
                                        <div class='detail'>
                                            <h3>".$friend['firstname']." ".$friend['lastname']."</h3>
                                            <span style='font-size:12px;margin-left:7px;'>".$friend['username']."</span>
                                        </div>
                                        <svg id='$relationid' onclick='startChat(event)'></svg>
                                    </div>";
            }
        $friends.="</div>";
    }

    
    $data['friends']= $friends;
#--------------------------------------- suggestion ---------
//lets get request the user already have sent to avoid dublication
$sent_requests = array();
$j=0;

$query = "SELECT * FROM Friend_requests where sender = '$userid' ";
$execute = $conn->query($query);
    if($execute->num_rows>0){
        while($row = $execute->fetch_assoc()){
            $sent_requests[$j] = $row['receiver'];
            $j++;
        }
}

//now the suggestion
    $query = "SELECT * from users where userid != '$userid'";
    $result = $conn->query($query);
        
    $friendSuggestions = "";

        if($result->num_rows>0){
             $friendSuggestions.="<legend style='margin:5px'>Suggestions</legend>
                            <div class='F_suggestion'>";
            while($row = $result->fetch_assoc()){

                if(!isAfreind($fr_array,$row['userid']) && !AlreadySentRequestTo($row['userid'],$sent_requests)){

                    $friendSuggestions.="
                                    <div class='f_sug'>
                                        <img src=backend/".$row['source'].">
                                        <div class='detail'>
                                            <h3>".$row['firstname']." ".$row['lastname']."</h3>
                                            <span style='font-size:12px;margin-left:7px;'>@".$row['username']."</span>
                                            <div style='transform:translateY(4px)'> <button onclick='request(`".$row['userid']."`,`1`)'>Send Request</button> <button onclick='remove(event)'>remove</button> </div>
                                        </div>
                                    </div>";
                    
                
                }
            }
                $friendSuggestions.="</div>";
        }

        $data['F_suggestion']= $friendSuggestions;
    
//freind suggestions filtering function

#two things are here friends don't have to be suggested again and the one that are already sent the request should't do it twice
function isAfreind($array,$userid){
    
    for ($i=0; $i < count($array) ; $i++) { 
                    # code...
            if($array[$i] == $userid){
                return true;
            }
    }
    return false;
}

function AlreadySentRequestTo($id,$array){
        for ($i=0; $i < count($array); $i++) { 
            # code...
            if($array[$i]==$id){
                return true;
            }
        }
        return false;
}

echo json_encode($data) ;

?>