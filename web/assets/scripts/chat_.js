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
                thoughts_radio.checked =false;
                thoughts_radio.click();
                //readThought();
            }else if(data_type == "add_comment"){
                thoughts_radio.checked =false;
                thoughts_radio.click();
                the_input_box.setAttribute('prev_com_no',the_input_box.getAttribute('prev_com_no')+1);
                readComment(the_input_box.getAttribute('comment_this_thought'));
            }else if(data_type == "post_comment"){
                readPostComment(the_input_box.getAttribute('comment_this_post'));
            }else if(data_type == "ask_ai"){
                thoughts_radio.checked =false;
                thoughts_radio.click();
                //readThought();
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
            var response = JSON.parse(xml.response);
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
    console.log("reading chat");
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
    console.log(ajax.response);
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