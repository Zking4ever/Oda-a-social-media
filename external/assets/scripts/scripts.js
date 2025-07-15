//to add and load posts
var add = document.getElementById('add');
var submit = document.getElementById('submit');
var inputs = document.getElementsByClassName('new_post_inputes')[0];
var contributers = document.getElementsByClassName('contributers')[0];
var loadingDiv = document.getElementsByClassName("loadingGif")[0];
var notifications = document.getElementsByClassName('notifications')[0];
var loaded_post = document.getElementsByClassName('loaded_post')[0];
var radiosParent = document.getElementById("myradios");
var radios = radiosParent.getElementsByTagName("input");

var type_inputes = document.getElementsByClassName("inputs")[0];
var intervalId; 

for(var i=0;i<radios.length;i++){
    radios[i].addEventListener('change',function(){
        let clickedIndex = getIndex(this);
        let request_type = "";
        //depending on the radio sending a request to api with different request type
        switch(clickedIndex){
            case 0: if(radios[0].checked){
                        request_type= "loadHome";
                         type_inputes.style.display = "none";
                         type_inputes.getElementsByTagName("label")[0].style.display = "none"; 
                         clearInterval(intervalId);
                    }
                    break;
            case 1: if(radios[1].checked){
                         request_type= "loadFriends";
                         type_inputes.style.display = "none";
                         type_inputes.getElementsByTagName("label")[0].style.display = "block"; // for file transfer only in chat
                    }
                    break;
            case 2: if(radios[2].checked){
                         request_type= "loadThoughts";
                         type_inputes.style.display = "flex";
                         type_inputes.getElementsByTagName("label")[0].style.display = "none"; 
                         var commentContainer = document.getElementsByClassName("commentContainer")[0];
                         if(window.getComputedStyle(commentContainer).display == "none"){
                            type_inputes.getElementsByTagName("input")[1].placeholder = "type what you are thinking";
                         }
                         clearInterval(intervalId);
                    }
                    break;
            case 3: if(radios[3].checked){
                         request_type= "loadAsks";
                         clearInterval(intervalId);
                    }
                    break;
           /* case 4: if(radios[4].checked){
                        
                         request_type= "loadCouncelor";
                         clearInterval(intervalId);
                    }
                    break;
                    */
            case 5: if(radios[5].checked){
                         request_type= "loadSettings";
                         type_inputes.style.display = "none";
                         clearInterval(intervalId);
                    }
                    break;
        }
        var xml = new XMLHttpRequest;
        loading("LOADING...");     //function to show its loading
        xml.onload = function(){ 
            if(xml.readyState==4 || xml.status==200){
                handleResult(xml.response,request_type);
            }
        }
        xml.open("GET","backend/api.php?request_type="+request_type,true);
        xml.send();
    });
}
function getIndex(obj){
    for(var i=0;i<radios.length;i++){
        if(radios[i]==obj){
            return i;
        }
    }
}

//post inputs
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
    loading("Processing your post... wait a momment..");
    var ajaxrequest = new XMLHttpRequest;
        ajaxrequest.onload = function(){
            if(ajaxrequest.readyState == 4){
                handleResult(ajaxrequest.response,"post");
            }
        }
        form.append('file',file[0]);
        form.append('caption',caption);
        form.append('request_type',"add_post");
    
    ajaxrequest.open("POST","backend/api.php",true);
    ajaxrequest.send(form);


    inputs.style.display ="none";
    add.style.opacity = "100";   
        
}

differentiateStories(); 

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
                    form.append('actives',activeStories);
                    form.append('request_type',"differentiate");
                    xmlR.open("POST","backend/api.php",true);
                    xmlR.send(form);
            }
        }
    xml.open("GET","backend/api.php?request_type=get_stories",true);
    xml.send();
}
/*
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
*/

//log out
var logout_btn = document.getElementsByClassName("logout")[0];

logout_btn.onclick = function(){
        if(confirm("Do you want to log out?")){
            var myform = new FormData;
            loading("LOGING OUT...");
            var ajax = new XMLHttpRequest;
            ajax.onload = function(){
                if(ajax.readyState==4){
                    handleResult(ajax.response,"log out");
                }
            }
            
            myform.append('request_type','logout');
            ajax.open("POST","backend/api.php");
            ajax.send(myform);
        }
}

//to put userinfo
var username = document.getElementById('username');
var profile_image = document.getElementById('profile_image');
var stroies = document.getElementsByClassName('stroies')[0];

async function handleResult(result,type){
     
    finishedLoading();//since it is handling the response
    switch(type){
        case "loadHome":
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
        case "loadFriends":
            var response = JSON.parse(result);
                loaded_post.innerHTML = response['F_request'];
                loaded_post.innerHTML += response['friends'];
                loaded_post.innerHTML += response['F_suggestion'];
            break;
        case "loadSettings":
        case "loadThoughts":
                loaded_post.innerHTML = result;
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
                //then the refresh will take it out as the session is destroyed
                location.href = location.href;
          	// window.location.assign("http://incrediblefuture.mywebcommunity.org/");
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


function loading(text){
        contributers.style.display = "flex";
        loadingDiv.style.display = "flex";
        if(text!=null){
            loadingDiv.textContent = text;
        }
}
function finishedLoading(){
        contributers.style.display = "none";
        loadingDiv.style.display = "none";
}
