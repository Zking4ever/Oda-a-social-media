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
                    height:400px;
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
                }
                .chatHolder{
                    flex:0.73;
                    overflow-Y:scroll;
                    background-color:red;
                    display:flex;
                    flex-direction:column;
                }
                .chatHolder div{
                    max-width:55%;
                    width:fit-content;
                    min-height:40px;
                    display:flex;
                    gap:5px;
                    align-items:center;
                    margin:7px;
                    padding:3px;
                }
                
                .sent{
                    align-self:end;
                    justify-content:end;
                }
                .chat img{
                    width:40px;
                    height:40px;
                    border-radius:50%;
                }
                .chatHolder div div{
                    background-color:white;
                    border-radius:12px;
                }
            </style>
                
            <div class='chat'>
                <div class='listHolder'>  
                    <div> <img> <span>User one</span></div>
                    <div> <img> <span>User two</span></div>
                    <div> <img> <span>User one</span></div>
                    <div> <img> <span>User two</span></div>
                </div>
                <div class='chatHolder'>";
            //query to get history messages
                $query = "SELECT * from chats where relationid = '$relationid'";
                $excute = $conn->query($query);
                    if($excute->num_rows>0){
                        while($row = $excute->fetch_assoc()){
                            if($userid == $row['sender']){
                                $chat .=" <div class='sent'>  
                                    <div> <span>".$row['message']."</span></div> <img> 
                                </div>";
                            }else{
                                $chat .="<div class='recieved'>  
                                    <img> <div> <span>".$row['message']."</span></div> 
                                </div>";
                            }
                        }
                    }
                    
    $chat .=" </div>
    </div>";

    echo $chat;
}

if($relationid != "" && $_POST['data_type']=="send_message"){

    $message = $_POST['message'];
    $messageid = createRand(25);
    $query = "INSERT into chats(messageid,relationid,sender,message) values ('$messageid','$relationid','$userid','$message')";
    $excute = $conn->query($query);
    if($excute){
        echo "message sent";
    }
}