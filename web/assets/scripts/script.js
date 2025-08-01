//to add and load posts
var add = document.getElementById('add');
var submit = document.getElementById('submit');
var inputs = document.getElementsByClassName('new_post_inputes')[0];
var DIR = "http://incrediblefuture.atwebpages.com/web/backend/api.php";
var userid = new URLSearchParams(window.location.search).get('userid');
var contributers = document.getElementsByClassName('contributers')[0];
var loadingDiv = document.getElementsByClassName("loadingGif")[0];
var loadingMessage = document.getElementsByClassName("loadingMessage")[0];
var notifications = document.getElementsByClassName('notifications')[0];
var loaded_post = document.getElementsByClassName('loaded_post')[0];
var radiosParent = document.getElementById("myradios");
var radios = radiosParent.getElementsByTagName("input");

var menuLabel = document.getElementsByClassName("menuLabel");

var type_inputes = document.getElementsByClassName("inputs")[0];
var intervalId; 

for(var i=0;i<menuLabel.length;i++){
    menuLabel[i].addEventListener('click',function(){
        let clickedIndex = getIndex(this);
        let request_type = "";
        //if its on home page the width has to be reduced
        if(radios[0].checked){
            loaded_post.className = "loaded_post home";
        }else{
            loaded_post.className = "loaded_post";
        }
        //depending on the radio sending a request to api with different request type
        switch(clickedIndex){
            case 0:      request_type= "loadHome";
                         type_inputes.style.display = "none";
                         type_inputes.getElementsByTagName("label")[0].style.display = "none"; 
                         clearInterval(intervalId);
                         intervalId = undefined;
                    break;
            case 1:      request_type= "loadFriends";
                         clearInterval(intervalId);
                         intervalId = undefined;
                         type_inputes.style.display = "none";
                         type_inputes.getElementsByTagName("label")[0].style.display = "block"; // for file transfer only in chat
                    break;
            case 2:     request_type= "loadThoughts";
                         type_inputes.style.display = "flex";
                         type_inputes.getElementsByTagName("label")[0].style.display = "none"; 
                         var commentContainer = document.getElementsByClassName("commentContainer")[0];
                         if(window.getComputedStyle(commentContainer).display == "none"){
                            type_inputes.getElementsByTagName("input")[1].placeholder = "type what you are thinking";
                         }
                         clearInterval(intervalId);
                         intervalId = undefined;
                    break;
            case 3:      request_type= "askAI";
                         clearInterval(intervalId);
                         intervalId = undefined;
                         type_inputes.style.display = "flex";
                         type_inputes.getElementsByTagName("label")[0].style.display = "none";
                         type_inputes.getElementsByTagName("input")[1].placeholder = "ask ai";
                    break;
           /* case 4: if(menuLabel[4].checked){
                        
                         request_type= "loadCouncelor";
                         clearInterval(intervalId);
                    }
                    break;
                    */
            case 4:      request_type= "loadSettings";
                         type_inputes.style.display = "none";
                         clearInterval(intervalId);
                         intervalId = undefined;
                    break;
        }
        var xml = new XMLHttpRequest;
        loading("LOADING...");     //function to show its loading
        xml.onload = function(){ 
            if(xml.readyState==4 || xml.status==200){
                handleResult(xml.response,request_type);
            }
        }
        var form = new FormData;
        form.append('userid',userid);
        xml.open("POST",DIR+"?request_type="+request_type,true);
        xml.send(form);
    });
}
function getIndex(obj){
    for(var i=0;i<menuLabel.length;i++){
        if(menuLabel[i]==obj){
            return i;
        }
    }
}
//

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
        form.append('userid',userid);
        form.append('file',file[0]);
        form.append('caption',caption);
        form.append('request_type',"add_post");
    
    ajaxrequest.open("POST",DIR,true);
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
                    form.append('userid',userid);
                    form.append('actives',activeStories);
                    form.append('request_type',"differentiate");
                    xmlR.open("POST",DIR,true);
                    xmlR.send(form);
            }
        }
    var formData = new FormData;
    formData.append('userid',userid);
    xml.open("POST",DIR+"?request_type=get_stories",true);
    xml.send(formData);
}


var contribut = document.getElementsByClassName('contributers')[1];
//get user profile
function get_profile(e){
        var element = e.target;
        for(let i=0;i<3;i++){
            if(!element.id && element.className!="sender"){
                element = element.parentElement;
            }
        }
        var myform = new FormData;
        var ajax = new XMLHttpRequest;
        loading();
        ajax.onload = function(){
            if(ajax.readyState==4){
                finishedLoading();
                contribut.style.display = "flex";
                var Data = JSON.parse(ajax.response);
                
                var profile_img = contribut.getElementsByTagName("img")[0];
                var infos = contribut.getElementsByTagName("span");
                var btn = contribut.getElementsByTagName("button")[0];
                var profile_link = contribut.getElementsByTagName("a")[0];

                profile_img.src = "backend/"+Data['profile']['img_src'];
                profile_link.href = "backend/"+Data['profile']['img_src'];
                infos[0].innerHTML = Data['profile']['fullname'];
                infos[1].innerHTML = "@"+Data['profile']['username'];
                btn.innerHTML = Data['relationstatus'][0];
                btn.id = Data['profile']['userid'];
                if(Data['relationstatus'][1]){
                    btn.id = Data['relationstatus'][1];
                }

                var stories = contribut.getElementsByClassName('stroies')[0];
                var loaded_post = contribut.getElementsByClassName('loaded_post')[0];
                if(Data["stories"]==""){
                    stories.style.display = "none";
                    loaded_post.style.height = "72%";
                }else{
                    stories.style.padding = "0.5px";
                    stories.style.display = "flex";
                    loaded_post.style.height = "65%";
                }
                stories.innerHTML = Data["stories"];
                loaded_post.innerHTML = Data['posts'];
            }
        }


        myform.append('userid',userid);
        myform.append('request_type',"profile");
        myform.append('personid',element.id);

        ajax.open("POST",DIR);
        ajax.send(myform);
    
}

var close = document.getElementById("close");

close.addEventListener('click',function(){
    contribut.style.display = "none";
});

var btn = contribut.getElementsByTagName("button")[0];

btn.onclick = function(e){
    if(btn.innerHTML=="send request"){
        request(this.id);
        this.innerHTML = "request pending...";
    }else if(btn.innerHTML=="message"){
        this.addEventListener('click',(e)=>{
            startChat(e);
        });
        this.click();
        contribut.style.display = "none";
    }else{
        return;
    }
}
//log out
function LogOut(){
        if(confirm("Do you want to log out?")){
            var myform = new FormData;
            loading("LOGING OUT...");
            var ajax = new XMLHttpRequest;
            ajax.onload = function(){
                if(ajax.readyState==4){
                    handleResult(ajax.response,"log out");
                }
            }
            
            myform.append('userid',userid);
            myform.append('request_type','logout');
            ajax.open("POST",DIR);
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
            notifications.style.display="none";
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
        case "askAI":
                loaded_post.innerHTML = result;
            break;
        case "post":
            notifications.style.display="flex";
            notifications.style.opacity ="100";
            notifications.style.transform =" translateX(-50%) translateY(0px)";
            notifications.innerHTML = result;
            break;
        case "change_profile":
            notifications.style.display="flex";
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
            notifications.style.display="flex";
            notifications.style.opacity ="100";
            notifications.style.transform =" translateX(-50%) translateY(0px)";
            notifications.innerHTML = result;
            break;
    }


    await delay(3000);
    notifications.style.transfrom ="translateX(-50%) translateY(-30px)";
    await delay(1000);
    notifications.style.opacity ="0";
    notifications.style.display="none";

}

function delay(ms){
    return new Promise(response => setTimeout(response,ms));
}


function loading(text){
        contributers.style.display = "flex";
        loadingDiv.style.display = "flex";
        if(text!=null){
            loadingMessage.textContent = text;
        }
}
function finishedLoading(){
        contributers.style.display = "none";
        loadingDiv.style.display = "none";
}
