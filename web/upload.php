<?php



$destination = 'C:\Users\USER\Documents\trying to move file with php\ ';

if(isset($_FILES) && isset($_FILES['file']['name'])){
    if($_FILES['file']['error']==0){
        $destination = $destination.$_FILES['file']['name'];
        $move = move_uploaded_file($_FILES['file']['tmp_name'] ,$destination);
        echo $move;
        echo $destination;
    }
}