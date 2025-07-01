<?php

$friendid = $_POST['friendid'];
$response = $_POST['response'];

$status="";

if($response == "send"){
    $relationid = createRand(25);
    $query = "INSERT into friend_requests(relationid,sender,receiver,status_) value('$relationid','$userid','$friendid','pending')";
    $excute = $conn->query($query);

    if($excute){
        $status = "friend request sent";
    }

}
elseif($response == "confirm"){
    $relationid = $_POST['relationid'];
    $query1 = "UPDATE friend_requests set status_ = 'confirmed' where relationid = '$relationid' ";
    $query2 = "INSERT into friends(relationid,person1,person2) value('$relationid','$userid','$friendid')";
    $excute1 = $conn->query($query1);
    $excute2 = $conn->query($query2);

    if($excute1 && $excute2){
        $status = "friend request confirmed";
    }

}
echo $status;