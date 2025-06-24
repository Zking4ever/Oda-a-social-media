<?php
#differentiating the active stories

/*
$queryForStory = "SELECT * from active_stories";
$stories = $conn->query($queryForStory);

    if($stories->num_rows>0){
        while($story= $stories->fetch_assoc()){
            $userid = $story['sender'];
            $story_time = date_create_from_format("Y-m-d H:i:s",date($story['story_time']));
            $now = date_add(date_create_from_format("Y-m-d H:i:s",date( "Y-m-d H:i:s")) , date_interval_format("H",24) ) ;
            
            if($story_time < $now){
                $loadedStories .= " ".date($story['story_time'])." < ".date( "Y-m-d H:i:s");
            }
                   if(!isset($userWithStory['$userid'])){

                        $userWithStory['$userid'] = $story['sender'];
                        $query = "INSERT into active_story_users (sender,set_time) values ('$story[sender]','$story[story_time]')";
                        $addToActive = $conn->query($query);
                            if($addToActive){
                                        $loadedStories="added successfuly";
                                    }
                    }
               
           
        }
    }

        
#}
 */

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

?>