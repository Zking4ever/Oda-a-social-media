<?php

require "conn.php";

$queryForStory = "SELECT * from stories";
$stories = $conn->query($queryForStory);

$StoryObject = [];
$i=0;

if($stories->num_rows>0){
    while($story = $stories->fetch_assoc()){
        $StoryObject[$i] = $story;
        $i++;
    }
}

echo json_encode($StoryObject);

?>