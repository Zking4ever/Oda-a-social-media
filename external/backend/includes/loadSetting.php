<?php

    $query = "SELECT * FROM users where userid = '$userid' ";
    $excute = $conn->query($query);

    if($excute->num_rows>0){
        $userdata = $excute->fetch_assoc();
        echo "
            <style>
                .one div{
                    width:50%;
                    display:flex;
                    justify-content:space-around;
                    align-items:center;
                    font-size:17px;
                    position: relative;
                }
                .one input{
                    width:70%;
                    padding:5px;
                    border-radius:10px;
                }
                .two div{
                    width:200px;
                    height:200px;
                    background-color:azure;
                    display:flex;
                    align-items:center;
                    overflow:hidden;
                }
                .two img{
                    width:75%;
                    margin:auto;
                }
                .two label{
                    padding:3px 10px;
                    background-color:lightgray;
                    border-radius:5px;
                }
            </style>
            <div class='box' style='display:flex; width:98%;padding:1%;background-color:#6b73b6;border-radius:10px;margin:10px auto'>
                <div class='one' style='flex:2.5;background-color:#3c6290; display:flex;flex-direction:column;align-items:center;border-radius:10px;'>
                    <br>
                    <h1>Setting</h1>
                    <br>
                    <div>Username:<input placeholder='Username' value='$userdata[username]'></div><br>
                    <div>First name:<input placeholder='First name' value='$userdata[firstname]'></div><br>
                    <div>Last name:<input placeholder='Last name' value='$userdata[lastname]'></div><br>
                    <div>Email:<input placeholder='Email' value='$userdata[email]'></div><br>
                    <div>Password:<input type='password' placeholder='Password' value='$userdata[password]'> <span style='position:absolute; right:10px;' onclick='passVisiblity(event)'>eye</span></div><br>
                    <button style='padding:3px 12px'>Change</button><br>
                </div>
                <div class='two' style='flex:1;display:flex;flex-direction:column;align-items:center;'>
                    <div style=''><img src=backend/$userdata[source]></div><br>
                    <label for='getFile'>Change Profile</label>
                    <input type='file' id='getFile' onchange='change_profile_img(event)' style='display:none;'>
                </div>
            </div>

            

        ";
        
    }
