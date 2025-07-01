<?php
#differentiating the active stories

 require "conn.php";

 if(isset($_POST['actives'])){
    $actives = json_decode($_POST['actives']);

    $queryToTrunc = "TRUNCATE table active_stories";
    $trunc = $conn->query($queryToTrunc);
    
    foreach ($actives as $story => $value) {
        $queryInsert = "INSERT INTO active_stories(storyid,sender,caption,seen,likes,source,story_time) values('$value->storyid','$value->sender','$value->caption','$value->seen','$value->likes','$value->source','$value->story_time')";
        $comput = $conn->query($queryInsert);
    }
        echo json_encode("done");
}

#seeing specific story after getting the user id

if(isset($_POST['type']) && $_POST['type']=="see_story"){
    $sendersid = $_POST['sendersid'];

    $query = "SELECT * FROM active_stories where sender = '$sendersid' ";
    $stories = $conn->query($query);
    $response = [];
    $i=0;
    if($stories->num_rows>0){
        while($story = $stories->fetch_assoc()){
            $response[$i] = $story['source']."s9par@tor".$story['caption'];
            $i++;
        }
            echo json_encode($response);
    }

}

?>