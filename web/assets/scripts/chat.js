
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
    form.append("request_type","chat");
    form.append("relationid",element.id);
    form.append("data_type","start_chat");
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}
function send(e){
    var data_type;
    var request_type;
    var the_input_box = e.target.parentElement.getElementsByTagName("input")[1];
    var inputs_placeholder = the_input_box.placeholder;
    var form = new FormData;

    if(inputs_placeholder == "type a message"){
        data_type = "send_message";
        request_type = "chat";
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
    }

    var ajax =  new XMLHttpRequest;
    loading("Sending...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            //handleResult(ajax.response,"loadThoughts");
            finishedLoading();
            if(data_type == "send_message"){
                var the_file_input = e.target.parentElement.getElementsByTagName("input")[0];
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
            }
            the_input_box.value = "";
        }
    }
    form.append("request_type",request_type);
    form.append("data_type",data_type);
    form.append("message",the_input_box.value);
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
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
    form.append("request_type","chat");
    form.append("data_type","read");
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}

var send_btn = document.getElementById("send_btn");
send_btn.onmouseenter = function(){
    
    var inps = type_inputes.getElementsByTagName("input");
    if(inps[0].value.trim() == "" && inps[1].value.trim() == "" ){
        this.disabled = true;
    }else{
        this.disabled = false;
    }
}