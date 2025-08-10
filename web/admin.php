<?php
session_start();

if(!isset($_SESSION['userid'])){
    echo "don't have access to this";
    die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body{
    background-color: var(--txt-color);
    margin: 0;}
.wraper{
    width: 100%;
    height: 97vh;
    display: flex;
    align-items: center;
    background-color: var(--bg);
    --bg: #0d1117;
    --bg2: #2b313a;
    --bg3: #212830;
    --txt-color: white;
    --hover: #f2f2f2;
    --img:#a0d3cf;
    --hover-br:#dde1ff;
}
#mybox{
    pointer-events: none;
    position: absolute;
    opacity: 0;
}
#mybox:checked ~ .wraper {
    --bg: #ffff;
    --br: #a4b9b8;
    --bg2: #dde1ff;
    --bg3: #f6f8fa;
    --txt-color: black;
    --hover:#7b8f8d;
    --img:#929494;
    --hover-br: white;
}
.one{
    flex: 1;
    border:solid;
    height: 100%;
    display: flex;
    flex-direction: column;
    overflow-y: overlay;
}
.users{
    align-self: center;
    width: 90%;
    background-color: var(--bg2);
}
.two{
    flex: 2.5;
    display: flex;
    align-items: center;
    height: 100%;
}
.subone{
    flex: 3;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 20px;
    height: 100%;
}
.subtwo{
    flex: 1.2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding-right: 15px;
    gap: 5%;
}
.theme{
    padding: 5px;
}
.round_box{
    width: 55px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    justify-self: right;
    border-radius: 14px;
    background-color: rgb(124, 118, 118);
    cursor: pointer;
}
.round_box svg:nth-child(2){
    border-radius: 50%;
    background-color: aliceblue;
}
.top:first-of-type{
    border:solid var(--br);
    background-color: var(--bg3);
    border-radius: 10px;
    display: flex;
}
.top{
    height: 45%;
    width: 90%;
    display: flex;
    overflow: hidden;
}
.top:nth-of-type(2){
    gap: 2%;
}
.top:nth-of-type(2) .posts, .stories{
    width: 49%;
    height: 100%;
    border:solid var(--br);
    background-color: var(--bg2);
    border-radius: 10px;
    display: grid;
    grid-template-columns: 30% 30% 30%;
    grid-template-rows: 30% 30% 30%;
    overflow-y: overlay;
    justify-content: space-around;
    row-gap: 4%;
}
.top .img{
    width: 55%;
    background-color: var(--img);
    border-radius: 6px;
    display: flex;
    justify-content: center;
    align-items: center;
}
.top img{
    max-width: 95%;
}
.disc{
    width: 45%;
    display: flex;
    flex-direction: column;
    align-items: center;
    overflow: overlay;
    padding-left: 3px;
    position: relative;
    color: var(--txt-color);
}
.disc *{
    margin: 5px auto;
}
.post,.story{
    width: 100%;
    height: 80px;
    margin: 9% auto;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    overflow: hidden;
    transition: all 1s ease;
}
.post{
    background-color: rgb(90, 60, 60);
}
.story{
    background-color: rgb(228, 160, 160);
}
.post:hover,
.story:hover{
    color: var(--txt-color);
    border: solid var(--hover-br);
    transform: scale(1.15);
}
.post img,.story img,
.post h2,.story h2{
    display: none;
}
.profile{
    height: 15%;
    background-color: var(--bg3);
    border:solid var(--br);
    border-radius: 10px;
}
.friends{
    height: 75%;
    width: 100%;
    background-color: var(--bg2);
    border:solid var(--br);
}
h3{
    margin: 0;
    margin-bottom: 5px;
    padding: 10px 15px;
    border: solid thin;
    border-radius: 5px;
}
h3:hover{
    background-color: var(--hover);
    color: var(--bg2);
}
.active{
    background-color: var(--hover);
    color: var(--bg2);
}
.notify{
    position: absolute;
    top: -90px;
    left: 50%;
    transform: translateX(-50%);
    padding: 10px 70px;
    text-align: center;
    border: solid thin;
    border-radius: 8px;
    background-color: white;
    animation: notify 3s ease;
    display: none;
}
@keyframes notify {
    50%{
        top: 30px;
    }
}

</style>
<body>
    <input type="checkbox" id="mybox">
    <div class="wraper">
        <div class="one">
            <div class="theme">
                    <label for="mybox" class="round_box">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15 4C15.292 4 15.438 4 15.5781 4.04183C16.192 4.22522 16.4775 4.93111 16.1637 5.48976C16.0921 5.61719 15.8744 5.82779 15.4389 6.249C13.935 7.70352 13 9.74257 13 12C13 14.2574 13.935 16.2965 15.4389 17.751C15.8744 18.1722 16.0921 18.3828 16.1637 18.5102C16.4775 19.0689 16.192 19.7748 15.5781 19.9582C15.438 20 15.292 20 15 20V20C10.5817 20 7 16.4183 7 12C7 7.58172 10.5817 4 15 4V4Z" fill="#F2F9FE"/>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <circle cx="12" cy="12" r="4" fill="#223344"/>
                            <path d="M12 5V3" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M12 21V19" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M16.95 7.04996L18.3643 5.63574" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M5.63608 18.3644L7.05029 16.9502" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M19 12L21 12" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M3 12L5 12" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M16.95 16.95L18.3643 18.3643" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            <path d="M5.63608 5.63559L7.05029 7.0498" stroke="#223344" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                    </label>
            </div>
            <div class="users">
                <h3>USER1</h3>
                <h3>USER2</h3>
            </div>
        </div>
        <div class="two">
            <div class="subone">
                <div class="top">
                    <div class="img"><img src="" id="img"></div>
                    <div class="disc">
                        <p id='cap' style="overflow-wrap: break-word;">posts description or story caption</p>
                        <div id="reactions" style="text-align: left;"></div>
                        <button class="action" style="background-color: red; padding: 5px 28px; border: none; border-radius: 10px;position: absolute; right: 5px; bottom: 5px;cursor: pointer;">Delete</button>
                    </div>
                </div>
                <div class="top">
                    <div class="posts">
                        User Posts                            
                    </div>
                    <div class="stories">
                        User Stories
                    </div>
                </div>
            </div>
            <div class="subtwo">
                <div class="profile" style="position: relative;">
                    <img id="profile" src="" style="width: 75px;height:75px;border-radius: 50%;border: none;">
                    <button style="position: absolute;top: 10px;right: 10px;background-color: rgb(213, 22, 22);color: white;border: 5px;border-radius:2px;cursor:pointer;padding: 2px 20px;">Log out</button>
                    <button class="deleteUser" style="position: absolute;bottom: 10px;right: 10px;background-color: rgb(213, 22, 22);color: white;border: 5px;border-radius:2px;cursor:pointer;padding: 2px 20px;">DELETE USER</button>
                </div>
                <div class="friends">
                    User Friends
                </div>
            </div>
        </div>
    </div>
    <div class="notify"></div>
</body>
<script>

   
    var bord = document.getElementById("img");
    var cap = document.getElementById("cap");
    var reactions = document.getElementById("reactions");
    var action = document.getElementsByClassName("action")[0];
    var profile = document.getElementById("profile");
    
    var postContainer = document.getElementsByClassName("posts")[0];
    var storyContainer = document.getElementsByClassName("stories")[0];
    var friendContainer = document.getElementsByClassName("friends")[0];
    var deleteUser = document.getElementsByClassName("deleteUser")[0];


loadUsers();

function loadUsers(){
    var xml =new XMLHttpRequest;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
            var usersContainer = document.getElementsByClassName('users')[0];
            usersContainer.innerHTML = JSON.parse(xml.response);
            var users = document.getElementsByTagName('h3');
            for (let i = 0; i < users.length; i++) {
                users[i].addEventListener('click',function(){
                    userClicked(this);
                })
            }
        }
    }
    var form = new FormData;
    form.append('request',"admin");
    xml.open("POST","backend/api.php",true);
    xml.send(form);
}

function userClicked(e){
    var element = e;
    if(!e.id){
        element = element.parentElement;
    }
    var xml = new XMLHttpRequest;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
            
            var response = JSON.parse(xml.response);
            postContainer.innerHTML = response['posts'];
            storyContainer.innerHTML = response['stories'];
            profile.src = response['profile'];
            friendContainer.innerHTML = response['friends'];
            deleteUser.id = element.id;
            //adding eventlisteners
             var post = document.getElementsByClassName("post");
             var story = document.getElementsByClassName("story");
            for (let i = 0; i < post.length; i++) {
                post[i].addEventListener('click',function(){
                    clicked(this);
                });
            }
            for (let i = 0; i < story.length; i++) {
                story[i].addEventListener('click',function(){
                    clicked(this);
                });
            }
            //marking the currect user as active
            var active = document.getElementsByClassName("active")[0];
            if(active){
                active.className="";
            }
            element.className = "active";
        }
    }
    var form = new FormData;
    form.append('request',"admin");
    form.append('id',element.id);
    xml.open("POST","backend/api.php",true);
    xml.send(form);
}

function clicked(e){
        var element = e;
        var x = 0;
        while(element.className != "story" && element.className != "post"){
            element = element.parentElement;
            x++;
            if(x==3){
                break;
            }
        }
        if(element.className != "story" && element.className != "post"){
            return;
        }
        var img = element.getElementsByTagName("img")[0];
        var caption = element.getElementsByTagName("p")[0];
        var reac = element.getElementsByTagName("h2")[0];

        bord.src = img.getAttribute('source');
        cap.innerHTML = caption.innerHTML;
        var numb = (reac.innerHTML).split('|');
        reactions.innerHTML = numb[0]+`<br>` + numb[1] + `<br>` + numb[2];
        action.id = element.id+"|spliter|"+element.className;

    }

action.addEventListener("click",function(e){
    if(!e.target.id){
        return;
    }
    var comp = (e.target.id).split("|spliter|");
    if(confirm("Are you sure about deleteing this?")){
        if(confirm("This action can't be undone!")){
            var xml = new XMLHttpRequest;
            xml.onload = function(){
                if(xml.readyState==4 || xml.status==200){
                    notify(xml.response);
                    if(xml.response == "deleted"){
                        var element = document.getElementById(comp[0]);
                        element.style.display = "none";
                        bord.src = "";
                        cap.innerHTML = "posts description or story caption";
                        reactions.innerHTML ="";
                        action.id = undefined;
                    }
                }

            }
            var form = new FormData;
            form.append('request',"admin");
            form.append('info',JSON.stringify(comp));

            xml.open("POST","backend/api.php",true);
            xml.send(form);
        }
    }
});

deleteUser.addEventListener("click",function(e){
    if(!e.target.id){
        return;
    }
    if(confirm("Are you sure about deleteing this?")){
        if(confirm("This action can't be undone!")){
            var xml = new XMLHttpRequest;
            xml.onload = function(){
                if(xml.readyState==4 || xml.status==200){
                    notify(xml.response);
                    if(xml.response == "deleted"){
                        location.href = location.href;
                    }
                }
            }
            var form = new FormData;
            form.append('request',"admin");
            form.append('deleteUser',e.target.id);

            xml.open("POST","backend/api.php",true);
            xml.send(form);
        }
    }
});

var box = document.getElementsByClassName("notify")[0];

box.addEventListener('animationend',function(){
    this.style.display = "none";
});

function notify(text){
    box.innerHTML = text;
    box.style.display = "flex";

}
    </script>
</html>