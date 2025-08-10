<?php

if(!isset($_POST['data_type']) && $_GET['request_type']=="askAI"){
        echo "
            <style> 
                .aiBox{
                    display:flex;
                    flex-direction:column;
                    position:relative;
                    left:50%;
                    transform: translateX(-50%);
                    min-height:120px;
                    max-height: 380px;
                    max-width:580px;
                    width:100%;
                    border-radius:30px;
                    margin: 20px 0;
                    padding:5px;
                    overflow-y:overlay;
                    text-align:center;
                }
                .loading{
                    height:25px;
                    width:25px;
                    border:solid #9073de;
                    border-radius:5px;
                    align-self:center;
                    transform-origin:100% 100%;
                    animation: load 2.4s ease infinite;
                }
                .aiBox h1{
                    margin:10px;
                }
                .aiBox div{
                    overflow-wrap:break-word;
                    transition: all 1s ease;
                }
                .request{
                    max-width:50%;
                    align-self:end;
                    margin:10px;
                    padding: 1px 5px;
                    border: solid thin;
                    border-radius:10px;
                }
                .response{
                    max-width:80%;
                    height:max-content;
                    min-width: 85px;
                    display:flex;
                    flex-direction:column;
                    background-color: var(--bg3);
                    align-self:start;
                    margin-left:10px;
                    border: solid var(--chat-br-color);
                    border-radius:10px;
                    padding:5px;
                    text-align:start;
                }
                b{
                    margin-left:15px;
                }
                    </style>
            <div class='aiBox'><h1> Incree AI</h1>
                    <h3>Hey, How can i help you today?</h3>
                    <small> Boost your knowledg; increase your conciusness; extend your scope </small> </div>";

}
elseif(isset($_POST['data_type']) && $_POST['data_type'] == "ask"){
$API = "AIzaSyAyBkJGhAXdY_OIXRwDtIoNFgRIpJaxVq4";//key destroyed and replaced
$url="https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$API";
        $prompt = trim($_POST['prompt']);
        
    $prepared_request = '{
            "contents": [{
                    "parts":[{
                        "text":"'.$prompt.'"
                        }]
                    }]
                }';
    //setting a limit for request
    $checkLimit = "SELECT id FROM `airequests` where userid ='$userid' ";
    $excute = $conn->query($checkLimit);
    if($excute->num_rows>10){
        $limited = [];
        $limited['candidates'][0]['content']['parts'][0]['text'] = "Sorry you have reached your limit.<br>please contact the developer";
        echo json_encode($limited);
        die;
    }
$response = run_curl($url, $prepared_request);
 echo $response;
 die;
}

function run_curl($url, $data){
    global $conn;
    global $prompt;
    global $userid;
  $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if($http_code === 200){
        $save = "INSERT INTO `airequests`(userid,prompt) values ('$userid','$prompt')";
        $excute = $conn->query($save);
        curl_close($ch);
        return $response;
    }else{
        curl_close($ch);
        return "error occured";
    }
}


