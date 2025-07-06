
function startChat(e){
    type_inputes.style.display = "flex";
    type_inputes.getElementsByTagName("input")[1].placeholder = "type a message";
    var form = new FormData;
    var ajax =  new XMLHttpRequest;
    loading("Starting your chat...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            handleResult(ajax.response,"loadThoughts");
            var chat_holder = document.getElementsByClassName("chatHolder")[0];
            intervalId = setInterval( readChat, 1000);
            chat_holder.scrollTo(0,chat_holder.scrollHeight);
        }
    }
    form.append("request_type","chat");
    form.append("relationid",e.target.id);
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
    }else if(inputs_placeholder == "type what you are thinking"){
        data_type = "add_thought";
        request_type = "thought";
    }else if(inputs_placeholder == "comment"){
        data_type = "add_comment";
        request_type = "thought";
        form.append('thoughtid',the_input_box.getAttribute('comment_this_thought'));
        form.append('reaction_no',the_input_box.getAttribute('prev_com_no'));
    }
    var ajax =  new XMLHttpRequest;
    loading("Sending...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            //handleResult(ajax.response,"loadThoughts");
            finishedLoading();
            if(data_type == "send_message"){
                readChat();
            }else if(data_type == "add_thought"){
                thoughts_radio.checked =false;
                thoughts_radio.click();
                //readThought();
            }else if(data_type == "add_comment"){
                thoughts_radio.checked =false;
                thoughts_radio.click();
                readComment(the_input_box.getAttribute('comment_this_thought'));
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