function startChat(e){
    type_inputes.style.display = "flex";
    type_inputes.getElementsByTagName("input")[1].placeholder = "type a message";
    var form = new FormData;
    var ajax =  new XMLHttpRequest;
    loading("Starting your chat...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            handleResult(ajax.response,"loadThoughts");
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

    if(inputs_placeholder == "type a message"){
        data_type = "send_message";
        request_type = "chat";
    }else if(inputs_placeholder == "type what you are thinking"){
        data_type = "add_thought";
        request_type = "thought";
    }
    var form = new FormData;
    var ajax =  new XMLHttpRequest;
    loading("Sending...");
    ajax.onload = function(){
        if(ajax.readystate==4 || ajax.status ==200){
            //handleResult(ajax.response,"loadThoughts");
            finishedLoading();
            alert(ajax.response);
        }
    }
    form.append("request_type",request_type);
    form.append("data_type",data_type);
    form.append("message",the_input_box.value);
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}