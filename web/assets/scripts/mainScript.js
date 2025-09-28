//to add and load posts
var add = document.getElementById('add');
var submit = document.getElementById('submit');
var cancel = document.getElementById('cancel');
var inputs = document.getElementsByClassName('new_post_inputes')[0];
var DIR = "backend/api.php";
var userid; // = new URLSearchParams(window.location.search).get('userid');
var contributers = document.getElementsByClassName('contributers')[0];
var loadingDiv = document.getElementsByClassName("loadingGif")[0];
var loadingMessage = document.getElementsByClassName("loadingMessage")[0];
var notifications = document.getElementsByClassName('notifications')[0];
var stroies = document.getElementsByClassName('stroies')[0];
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
        if(clickedIndex==0){//for posts the box has to be smaller
            loaded_post.className = "loaded_post home";
            stroies.style.display = "flex";
        }else{
            loaded_post.className = "loaded_post";
            stroies.style.display = "none";
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
}
cancel.onclick = function(){
        inputs.style.display = "none";
        contributers.style.display = "none";
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
                            console.log(xmlR.response);
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
                profile_img.src = (Data['profile']['setedProfile']==1? "backend/"+Data['profile']['img_src']: Data['profile']['img_src']);
                profile_link.href = (Data['profile']['setedProfile']==1? "backend/"+Data['profile']['img_src']: Data['profile']['img_src']);
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

        ajax.open("POST",DIR,true);
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
            ajax.open("POST",DIR,true);
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
            stroies.innerHTML = response['stories'];
            
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
                location.href = "https://oda.social-networking.me";
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

//--------------------after this the chat script is going to be included 'cause it isn't loading for some reason ----------------------------------- 

//chat script

var relationid;
function startChat(e){
    var element = e.target;
    if(!element.id){
        element = element.parentElement;
    }
    type_inputes.style.display = "flex";
    type_inputes.getElementsByTagName("label")[0].style.display = "block";
    type_inputes.getElementsByTagName("input")[1].placeholder = "type a message";
    var form = new FormData;
    var ajax =  new XMLHttpRequest;
    loading("Starting your chat...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            handleResult(ajax.response,"loadThoughts");
            var chat_holder = document.getElementsByClassName("chatHolder")[0];
            if(!intervalId){
                intervalId = setInterval( readChat, 1000);
            }
            chat_holder.scrollTo(0,chat_holder.scrollHeight);
        }
    }
    
    form.append("userid",userid);
    form.append("request_type","chat");
    form.append("relationid",element.id);
    relationid = element.id;
    form.append("data_type","start_chat");
    ajax.open("POST",DIR,true);
    ajax.send(form);
}
function send(e){
    var data_type;
    var request_type;
    var the_input_box = e.target.parentElement.getElementsByTagName("input")[1];
    var inputs_placeholder = the_input_box.placeholder;
    var the_file_input = e.target.parentElement.getElementsByTagName("input")[0];
    var form = new FormData;

    if(the_input_box.value.trim()=="" && the_file_input.value ==""){
        return;
    }
    if(inputs_placeholder == "type a message"){
        data_type = "send_message";
        request_type = "chat";
        form.append("relationid",relationid);
        var fileInput = e.target.parentElement.getElementsByTagName("input")[0];
        if(fileInput.value!=""){
            form.append("filesNumber",fileInput.files.length);
            for(let i=0;i<fileInput.files.length;i++){
                form.append('file'+i,fileInput.files[i]);
            }
        }
    }else if(inputs_placeholder == "type what you are thinking"){
        data_type = "add_thought";
        request_type = "thought";
    }else if(inputs_placeholder == "comment"){
        data_type = "add_comment";
        request_type = "thought";
        form.append('thoughtid',the_input_box.getAttribute('comment_this_thought'));
        form.append('reaction_no',the_input_box.getAttribute('prev_com_no'));
    }else if(inputs_placeholder == "comment on this post"){
        data_type = "post_comment";
        request_type = "post_reaction";
        form.append('postid',the_input_box.getAttribute('comment_this_post'));
        form.append('number',the_input_box.getAttribute('prev_com_no'));
    }else if(inputs_placeholder == "ask ai"){
        askAi(the_input_box);
        return;
    }

    var ajax =  new XMLHttpRequest;
    loading("Sending...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            //handleResult(ajax.response,"loadThoughts");
            finishedLoading();
            if(data_type == "send_message"){
                the_file_input.value="";
                readChat();
            }else if(data_type == "add_thought"){
                menuLabel[2].click();
                //readThought();
            }else if(data_type == "add_comment"){
                menuLabel[2].click();
                the_input_box.setAttribute('prev_com_no',the_input_box.getAttribute('prev_com_no')+1);
                readComment(the_input_box.getAttribute('comment_this_thought'));
            }else if(data_type == "post_comment"){
                readPostComment(the_input_box.getAttribute('comment_this_post'));
            }
            the_input_box.value = "";
        }
    }
    form.append("userid",userid);
    form.append("request_type",request_type);
    form.append("data_type",data_type);
    form.append("message",the_input_box.value);
    ajax.open("POST",DIR,true);
    ajax.send(form);
}

var firstTime = true;
var isLoadingRequest = false;

function askAi(input){
    if(isLoadingRequest){
        return handleResult("Please wait... I'm working on your previous request","story")
    }
    isLoadingRequest = true; //avoid requesting two things instantly while the server was doing on previous request
    var aiBox = document.getElementsByClassName('aiBox')[0];
    var box = document.createElement('div');
    var div = document.createElement('div');
    box.className = "request";
    div.className = 'response';
    box.innerHTML = input.value;
    div.innerHTML = `<div style='width:50px;height:50px;'><div class='loading' style='width:20px;height:20px;justify-self:center;'></div></div>`;
    if(firstTime){
        aiBox.innerHTML = "";
        firstTime = false;
    }
    aiBox.appendChild(box);
    aiBox.appendChild(div);

    var xml = new XMLHttpRequest;
    var form = new FormData;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
            isLoadingRequest = false;
            var Airesponse = JSON.parse(xml.response);
            if(!Airesponse['candidates']){
                div.innerHTML = "Sorry, I couldn't process your request at the moment.";
                return;
            }
            var response = Airesponse['candidates'][0]['content']['parts'][0]['text'];
            div.innerHTML = "";
            response = response.split("*   ");
            for(let i=0;i<response.length;i++){
                var subResponse = response[i].split('**');
                if(subResponse.length === 1){
                    var p = document.createElement('p');
                    p.innerHTML = subResponse[0];
                    div.appendChild(p);
                    continue;
                }
                if(i==0){
                    var p = document.createElement('p');
                    p.innerHTML = subResponse[0];
                    div.appendChild(p);
                    var h2 = document.createElement('h2');
                    h2.innerHTML = subResponse[1];
                    div.appendChild(h2);
                    var p = document.createElement('p');
                    p.innerHTML = subResponse[2];
                    div.appendChild(p);
                }else{
                    var p = document.createElement('p');
                    if(subResponse[0].trim() != ""){
                        p.innerHTML = subResponse[0];
                    }
                    p.innerHTML += `<b>`+subResponse[1]+`</b>`; //bold
                    p.innerHTML += subResponse[2];
                    div.appendChild(p);
                }
                
                if(subResponse[3] && subResponse[3].trim() != ""){
                    var h2 = document.createElement('h2');
                    h2.innerHTML = subResponse[3];
                    div.appendChild(h2);
                }
                if(subResponse[4] && subResponse[4].trim() != ""){
                    var p = document.createElement('p');
                    p.innerHTML = subResponse[4];
                    div.appendChild(p);
                }
                if(subResponse[5] && subResponse[5].trim() != ""){
                    var h3 = document.createElement('h3');
                    h3.innerHTML = subResponse[5];
                    div.appendChild(h3);
                }

            };
            aiBox.scroll(0,aiBox.scrollHeight);
        }
    }
    form.append("userid",userid);
    form.append("prompt",input.value);
    form.append("data_type","ask");

    xml.open("POST",DIR+"?request_type=askAI",true);
    xml.send(form);
    input.value = "";
}
function readChat(){
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
            var chat_holder = document.getElementsByClassName("chatHolder")[0];
            var innerString = JSON.stringify(chat_holder.innerHTML);
            var responseString = JSON.stringify(ajax.response);

            if(responseString.split("div").length != innerString.split("div").length){
                    chat_holder.innerHTML = ajax.response;
                    chat_holder.scrollTo(0,chat_holder.scrollHeight);
                    //console.log("have a new message");
            }
                    //console.log("have no new message");
        }
    }
    form.append("userid",userid);
    form.append("relationid",relationid);
    form.append("request_type","chat");
    form.append("data_type","read");
    ajax.open("POST",DIR,true);
    ajax.send(form);
}

var send_btn = document.getElementById("send_btn");
var inp = type_inputes.getElementsByTagName("input")[1];

inp.addEventListener('keyup',function(e){
    if(e.key == "Enter"){
        send_btn.click();
    }
});
