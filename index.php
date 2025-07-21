<?php
    require_once 'external/vendor/autoload.php';
    require 'external/backend/config.php';

        $client = new Google_Client();
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setRedirectUri('http://localhost/mywork/incredible%20future/external/check.php');
        $client->addScope(Google_Service_Drive::DRIVE); 
        $client->addScope("email");
        $client->addScope("profile");
        
        $authUrl = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Increadiable future</title>
    <style>
        p,h1{
                margin: 0;
                padding: 0;
        }
        .wraper{
            height: 96vh;
            border:2px solid #9073de;
            display: flex;
            align-items: center;
            justify-content: center;

        }
        .part1{
            flex: 1;
            height: 100%;
            transition: all 2s ease;
            position: relative;
            overflow: hidden;
         }
        .notification{
            width: 80%;
            aspect-ratio: 8;
            padding: 5px 12px;
            text-align: center;
            position: absolute;
            left: 10%;
            top: -10%;
            color: white;
            border-radius: 5px;
            transition: all 1s ease;
        }
        .moved{
            transform: translateX(-200%);
        }
        .part2{
            flex: 2;
            height: 100%;
            background-color: #9073de;
            transition: all 2s ease;
            z-index: 10;
        }
        .section{
            width: 100%;
            height: 100%;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        .sign_up{
            display: none;
        }
        form{
            width: 100%;
        }
        input{
            border-radius: 10px;
            height: 25px;
            width: 45%;
        }
        input[type='button']{
            width: 100px;
            border-radius: 10px;
        }
        label{
            padding: 5px;
            cursor: pointer;
            color: rebeccapurple;
            transform: translate(-90px,19px);
            position: absolute;
            transition: all 1s ease;
        }
        .activelable{
            transform: translateY(-5px) translateX(-90px);
        }
        .switch_pages button{
            border: none;
            background-color: transparent;
            color: blue;
            cursor: pointer;
        }
        #passStrength{
            font-size: 14px;
            display: none;
            grid-template-columns: 50% 50%;
            background-color: rgb(217, 227, 234);
            min-height: 5px;
            width: 90%;
            margin: 5px auto;
            padding: 5px;
            border-radius: 5px;
        }
        .criteria{
            display: flex;
            align-items: center;
        }
        .des{
            color: red;
        }
        .criteria input:checked ~ .des{
            color: green;
        }
        #passStrength input{
            width: 12px;
        }
        .google{
            display: flex;
            gap: 20px;
            align-items: center;
            padding: 7px 12px;
            background-color: white;
            color: gray;
            font-weight: 700;
            text-decoration: none;
            border: solid gray;
            border-radius:5px;
        }
        .google::before{
            content: "";
            display: block;
            width: 30px;
            height: 30px;
            background-image: url(external/assets/svg/google.svg);
            background-color: white;
            background-size: cover;
        }
        .google:hover{
            background-color: #537bff;
            color: white;
        }
        @media (max-width:760px) {
            .part2{
                display: none;
            }
          .activelable{
            transform: translateY(-5px) translateX(-70px);
            }
        label{
            padding: 5px;
            transform: translate(-70px,19px);
            position: absolute;
            transition: all 1s ease;
            }
        .moved{
            transform: translateX(0);
        }
        }
    </style>
</head>
<body>
<div class="wraper">
    <div class="part2"></div>
    <div class="part1"> 
            <div class="notification">Lorepiente nam repellendus quaerat.</div>
            <div class="section login">
                <form id="log_in">
                    <p>Wlcome to</p>
                    <h1>Incredible Future</h1>
                    <h2>Log in</h2>
                    <label for="email" id="email_lable">Email</label><br>
                    <input type="email" name="email" id="email" required ><br>
                    <label for="password"  id="password_lable">Password</label><br>
                    <input type="password" name="password" id="password" required><br><br>
                    <input type="button" value="log in" onclick="submitData(1)">
                </form>
                <br>------------- Or -------------<br><br>
                <a href='<?php echo $authUrl ?>' class="google">Sign in with Google</a>
                
                <div class="switch_pages"><span>Don't have account? </span><button id="to_sign_up" onclick="signUp()">Sign up</button></div>
            </div>
            <div style="display: none;"><form id="external"><input id="check_btn" type="submit"></form></div>
            <div class="section sign_up">
                 <form id="sign_up">
                    <h2>Sign Up</h2>
                    <label for="fname">First Name</label><br>
                    <input type="text" name="fname" id="fname" required ><br>
                    <label for="lname">Last Name</label><br>
                    <input type="text" name="lname" id="lname" required ><br>
                    <label for="email2">Email</label><br>
                    <input type="email" name="email" id="email2" required ><br>
                    <label for="password2">Password</label><br>
                    <input type="password" name="password" id="password2" required><br>
                        <div id="passStrength">
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Must be at least of 8 characters</div></div> 
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Uppercase Letters</div> </div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Lowercase Letters</div></div>                       
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Special characters</div></div>                  
                           <div class="criteria"><input type="checkbox" disabled> <div class="des"> Contains Numbers</div></div>              
                        </div><br>
                    <input type="button" onclick="submitData(2)" value="Sign Up" id="sign_up_btn">
                </form>
                <br><br><br>
                <div class="switch_pages"><span>Already have an account? </span><button id="to_log_in" onclick="logIn()">Log in</button></div>
            </div> 
    </div>
</div>
    
</body>
<script src="external/assets/scripts/log.js"></script>
</html>