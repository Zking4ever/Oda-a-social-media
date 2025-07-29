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
                    background-color: #bec6ff91;
                    align-self:start;
                    margin-left:10px;
                    border:none;
                    border-radius:10px;
                    padding:5px;
                    text-align:start;
                }
                    </style>
            <div class='aiBox'><h1> Incree AI</h1>
                    <h3>Hey, How can i help you today?</h3>
                    <small> Boost your knowledg; increase your conciusness; extend your scope </small> </div>";

}
elseif(isset($_POST['data_type']) && $_POST['data_type'] == "ask"){
$API = "AIzaSyAyBkJGhAXdY_OIXRwDtIoNFgRIpJaxVq4";
$url="https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=$API";
        $prompt = trim($_POST['prompt']);
    $prepared_request = '{
            "contents": [{
                    "parts":[{
                        "text":"'.$prompt.'"
                        }]
                    }]
                }';

$response = run_curl($url,$prepared_request);
$response = json_decode($response, true);

if(isset($response['candidates'][0]['content']['parts'][0]['text'])){

    $response_text = $response['candidates'][0]['content']['parts'][0]['text'];
    $query = "INSERT into aiRequests(userid,prompt) value('$userid','$prompt')";
    $excute = $conn->query($query);
} else {
    $response_text = "Sorry, I couldn't process your request at the moment.";
}

echo json_encode($response_text);

    }

function run_curl($url, $data){
  $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

   return $response;
}

    