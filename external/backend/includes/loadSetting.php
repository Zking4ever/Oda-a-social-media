<?php

    $query = "SELECT * FROM users where userid = '$userid' ";
    $excute = $conn->query($query);

    if($excute->num_rows>0){
        $userdata = $excute->fetch_assoc();
        echo "
            <style>
                .one{
                    flex:2.5;
                    background-color:#eef6ff; 
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    border-radius:10px;
                }
                .two{
                    flex:1;
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                }
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
                    border-radius:10px;
                    margin:0 5px;
                    transition: all .4s ease;
                }
                .two div:hover{
                    transform:scale(1.04);
                    transform-origin:50% 50%;
                }
                .two a{
                    display:flex;
                }
                .two img{
                    width:75%;
                    margin:auto;
                }
                .two label{
                    padding:3px 10px;
                    background-color:lightgray;
                    border-radius:5px;
                    cursor:pointer;
                }
                @media (max-width:760px){
                .two div{
                    width:70px;
                    height:70px;
                    border-radius:50%;
                }
                .two div:hover{
                    transform:scale(1.06);
                    border:solid thin white;
                }
                    .two img{
                        width:96%;
                    }
                    .two label{
                        text-align:center;
                        width:50%;
                        font-size:14px;
                    }
                    .one div{
                        width:70%;
                        font-size:14px;
                        justify-content: space-between;
                    }
                    .one input{
                        width:63%;
                        padding: 2px;
                        border-radius:5px;
                    }
                }
            </style>
            <div class='box' style='display:flex; width:98%;padding:1%;background-color:#6b73b6;border-radius:10px;margin:40px auto'>
                <div class='one'>
                    <br>
                    <h1>Setting</h1>
                    <br>
                    <div>Username:<input placeholder='Username' value='$userdata[username]'></div>
                    <div>Full name:<input placeholder='Full name' value='$userdata[name]'></div>
                    <div>Email:<input placeholder='Email' value='$userdata[email]' disabled></div>
                    <div>Password:<input type='password' placeholder='Password' value='$userdata[password]'> <span style='position:absolute; right:10px; cursor:pointer;' onclick='passVisiblity(event)'>eye</span></div><br>
                    <button style='padding:3px 12px' onclick='saveSettings(event)'>Change</button><br>
                </div>
                <div class='two'>
                    <div><a target='_blank' href='backend/$userdata[source]'><img src='backend/$userdata[source]'></a></div><br>
                    <label for='getFile'>Change Profile</label>
                    <input type='file' id='getFile' onchange='change_profile_img(event)' style='display:none;'>
                </div>
            </div>

            

        ";
        
    }
