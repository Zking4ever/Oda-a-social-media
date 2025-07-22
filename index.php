<?php
    require_once 'web/vendor/autoload.php';
    require 'web/backend/config.php';

        $client = new Google_Client();
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setRedirectUri('http://localhost/mywork/incredible%20future/web/main.php');
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
            <div class="notification">notifications</div>
            <div class="section login">
                <form id="log_in">
                    <p>Welcome to</p>
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
                
            </div>
            <div style="display: none;"><form id="external"><input id="check_btn" type="submit"></form></div>
             
    </div>
</div>
    
</body>
<script src="web/assets/scripts/log_.js"></script>
</html>