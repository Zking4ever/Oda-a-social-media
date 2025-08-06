<?php
require "backend/conn.php";
session_start();

 $data;

if(isset($_POST) && !empty($_POST) && $_POST['type']=="log_in" ){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare('SELECT userid,password from users where email = ? ');
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows>0){
        $stmt->bind_result($userid, $Storedpassword);
        if($stmt->fetch()){
            if(password_verify($password,$Storedpassword)){
                $data['result'] = "log in";
                $data['status'] = "great";
                $_SESSION['userid'] = $userid;

                //header("location : check.php");
                echo json_encode( $data );
                die;
            }else{
                $data['result'] = "incorrect password";
                $data['status'] = "bad";

                echo json_encode( $data );
                die;
            }
        }
    }
    else{
        $data['result'] = "incorrect email";
        $data['status'] = "bad";

        echo json_encode( $data );
        die;
    }

}

?>