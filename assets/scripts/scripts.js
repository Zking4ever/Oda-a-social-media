//to add and load posts
var add = document.getElementById('add');
var submit = document.getElementById('submit');
var inputs = document.getElementsByClassName('new_post_inputes')[0];
var contributers = document.getElementsByClassName('contributers')[0];
var notifications = document.getElementsByClassName('notifications')[0];
var loaded_post = document.getElementsByClassName('loaded_post')[0];

add.onclick = function(){
        inputs.style.display = "flex";
        contributers.style.display = "flex";
        add.style.opacity = "0";     
}
//add a post
submit.onclick = function(){
    var file = document.getElementById('file').files;
    var caption = document.getElementById('caption').value;
    var form = new FormData;
    var ajaxrequest = new XMLHttpRequest;
        ajaxrequest.onload = function(){
            if(ajaxrequest.readyState == 4){
                handleResult(ajaxrequest.response,"post");
            }
        }
        form.append('file',file[0]);
        form.append('caption',caption);
    
    ajaxrequest.open("POST","backend/post.php",true);
    ajaxrequest.send(form);


    inputs.style.display ="none";
    contributers.style.display ="none";
    add.style.opacity = "100";   
        
}

differentiateStories();
load();

//load posts
function differentiateStories(){

    var xml = new XMLHttpRequest;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
                //manipulating the responded stories and separating active ones
                    var respo = JSON.parse(xml.response);
                    var activeStories = [];
                    var i=0;
                    respo.forEach(element => {
                        var stories_Date = new Date(element.story_time);
                        var next = new Date(element.story_time);
                        next.setDate(stories_Date.getDate()+1)
                        var now = new Date();
                            if( next.getTime() > now.getTime()){
                                activeStories[i] = element;
                                i++;
                            }
                    });

                    var form = new FormData;
                    var xmlR = new XMLHttpRequest;
                    xmlR.onload = function(){
                    if(xmlR.readyState==4 || xmlR.status==200){
                            if(JSON.parse(xmlR.response) != "done"){
                                handleResult("There was an error while organizing active stories","story")
                            }
                    
                        }
                    }
                    activeStories = JSON.stringify(activeStories);
                    form.append('actives',activeStories)
                    xmlR.open("POST","backend/differentiateStories.php",true);
                    xmlR.send(form);
            }
        }
    xml.open("POST","backend/getStories.php",true);
    xml.send();
}
function load(){
    var xml = new XMLHttpRequest;
    xml.onload = function(){
        notifications.style.opacity ="100";
        notifications.style.transform =" translateX(-50%) translateY(0px)";
        notifications.innerHTML = "loading...";
        if(xml.readyState==4 || xml.status==200){
            handleResult(xml.response,"load");
        }
    }
    xml.open("POST","backend/load.php",true);
    xml.send();
}
//change_profile
function change_profile(e){
    
    var filename = e.target.files[0].name;
    var ex_start = filename.lastIndexOf('.');
    var ex = filename.substr(ex_start+1,3);
    if(!(ex=='jpg' || ex=='JPG')){
        handleResult('File not supported','story');
        manage_story.style.display ="none";
        return;
    }

    if(confirm('Do you want to change your profile picture?')){
        var file = e.target.files[0];

        var myform = new FormData;
        var ajax = new XMLHttpRequest;
        ajax.onload = function(){
            if(ajax.readyState==4){
                handleResult(ajax.response,"change_profile");
            }
        }

        myform.append('file',file);
        myform.append('type','change_profile');
        ajax.open("POST","backend/change_profile.php");
        ajax.send(myform);
    }
}

//log out
var logout_btn = document.getElementsByClassName("logout")[0];

logout_btn.onclick = function(){
        if(confirm("Do you want to log out?")){
            var myform = new FormData;
        var ajax = new XMLHttpRequest;
            ajax.onload = function(){
                if(ajax.readyState==4){
                    handleResult(ajax.response,"log out");
                }
            }
            
            myform.append('type','logout');
            ajax.open("POST","backend/change_profile.php");
            ajax.send(myform);
        }
}

//to put userinfo
var username = document.getElementById('username');
var profile_image = document.getElementById('profile_image');
var stroies = document.getElementsByClassName('stroies')[0];

async function handleResult(result,type){
     
    switch(type){
        case "load":
            var response = JSON.parse(result);
            //puting users' info
            //username.innerHTML = response['userinfo']['firstname'] + " " + response['userinfo']['lastname'];
            //profile_image.src = "backend/"+ response['userinfo']['profile_source'];

            //puting the stories
            stroies.innerHTML += response['stories'];
            
            //puting the responded postes
            loaded_post.innerHTML = response['posts'];
            notifications.style.opacity ="0";
            notifications.style.transform =" translateX(-50%) translateY(-30px)";
            notifications.innerHTML = "";
            break;
        case "post":
            notifications.style.opacity ="100";
            notifications.style.transform =" translateX(-50%) translateY(0px)";
            notifications.innerHTML = result;
            break;
        case "change_profile":
            notifications.style.opacity ="100";
            notifications.style.transform =" translateX(-50%) translateY(0px)";
            notifications.innerHTML = result;
            
            //refreshing the page everytime to see the changes
            location.href = location.href;
            break;
        case "log out":
            if(result=="loged out"){
                notifications.style.opacity ="100";
                notifications.style.transform =" translateX(-50%) translateY(0px)";
                notifications.innerHTML = "Loging out...";
                //then the refresh will take it out as the session is destroyed

            //refreshing the page everytime to see the changes
            location.href = location.href;
            }
            break;
        case "story":
            notifications.style.opacity ="100";
            notifications.style.transform =" translateX(-50%) translateY(0px)";
            notifications.innerHTML = result;
            break;
    }


    await delay(3000);
    notifications.style.transfrom ="translateX(-50%) translateY(-30px)";
    await delay(1000);
    notifications.style.opacity ="0";

}

function delay(ms){
    return new Promise(response => setTimeout(response,ms));
}