<?php

    if(!isset($_POST['data_type']) && $_GET['request_type']=="askAI"){
        echo "
            <style> 
                .aiBox{
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    position:relative;
                    left:50%;
                    transform: translateX(-50%);
                    min-height:120px;
                    max-height: 380px;
                    max-width:470px;
                    width:100%;
                    background-color: #9c7dcdc9;
                    color:white;
                    border-radius:30px;
                    margin: 20px 0;
                    padding:5px;
                    overflow-y:scroll;
                    text-align:center;
                }
                .loading{
                    height:25px;
                    width:25px;
                    border:solid #9073de;
                    border-radius:5px;
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
                    background-color:white;
                    color:black;
                    align-self:end;
                    margin:10px;
                    border:none;
                    border-radius:10px;
                    padding:5px;
                }
                .response{
                    max-width:80%;
                    min-height:100px;
                    min-width: 85px;
                    display:flex;
                    align-items:center;
                    justify-content:center;
                    background-color: #bec6ff91;
                    color:black;
                    align-self:start;
                    margin-left:10px;
                    border:none;
                    border-radius:10px;
                    padding:5px;
                }
                    </style>
            <div class='aiBox'><h1> Incree AI</h1>
                    <h3>Hey, How can i help you today?</h3>
                    <small> Boost your knowledg; increase your conciusness; extend the scope </small> </div>";

    }
    elseif(isset($_POST['data_type']) && $_POST['data_type'] == "ask"){
        sleep(3);
        echo json_encode("respose from server after query being processed");
    }
    