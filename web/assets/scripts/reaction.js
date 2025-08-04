function remove(e){
    if(!confirm("Do you want to remove it?")){
                return;
     }
     var parent = e.target.parentElement.parentElement.parentElement;
     parent.style.display = "none";
}
//responding to suggestion
function request(id){
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = async function(){
        if(ajax.readyState==4 || ajax.status==200){
            handleResult(ajax.response,"story");
            await new Promise(response=>setTimeout(response,1000));
            menuLabel[1].click();
        }
    }
    form.append("userid",userid);
    form.append("request_type","resonse_to_suggestion");
    form.append("friendid",id);
    form.append("response","send");
    ajax.open("POST",DIR,true);
    ajax.send(form);
}
//responding to request
function  response(id,relationid){
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = async function(){
        if(ajax.readyState==4 || ajax.status==200){
            handleResult(ajax.response,"story");
            await new Promise(response=>setTimeout(response,1000));
            menuLabel[1].click();
        }
    }
    form.append("userid",userid);
    form.append("request_type","resonse_to_suggestion");
    form.append("relationid",relationid);
    form.append("friendid",id);
    form.append("response","confirm");
    ajax.open("POST",DIR,true);
    ajax.send(form);
}

function reactThoght(e,n){
    var element = e.target;
    var id = element.parentElement.id;
    //avoid simultaneous liking and disliking
       var sibiling = element.parentElement.children;
       for(var i=0;i<sibiling.length-1;i++){
             if(sibiling[i] != element && sibiling[i].className == "reacted"){
                sibiling[i].click();
             }
       } 
    var previous_content = JSON.stringify(element.innerHTML).split(" ");
    var reaction_no = previous_content[2];
    var react_type;
    var status;
    if(n==1) react_type="likes";else if(n==2) react_type ="dislikes";

    if(element.className !="reacted"){
        reaction_no++;
        element.className ="reacted"
        status = "reacting";
    }else{
        reaction_no--;
        element.removeAttribute('class');
        status = "remove";
    }
    
    var form = new FormData;
    var xml = new XMLHttpRequest;
    xml.onload=function(){
        if(XMLDocument.readyState==4 || xml.status==200){
            element.innerHTML = " "+previous_content[1]+" "+reaction_no+" ";
        }
    }
    form.append("userid",userid);
    form.append("request_type","thought");
    form.append("data_type","react");
    form.append("id",id);
    form.append("reaction_type",react_type);
    form.append("status",status);
    form.append("reaction_no",reaction_no);

    xml.open("POST",DIR,true);
    xml.send(form);
}
function seeComment(e){
        var element = e.target;
        var id = element.parentElement.id;

        var previous_content = JSON.stringify(element.innerHTML).split(" ");
        var reaction_no = previous_content[2];
        
        var commentContainer = document.getElementsByClassName("commentContainer")[0];
        commentContainer.style.display = "block";
        readComment(id);
        //preparing for writing comment
            type_inputes.style.position = "absolute";
            type_inputes.getElementsByTagName("input")[1].placeholder = "comment";
            type_inputes.getElementsByTagName("input")[1].setAttribute('prev_com_no',reaction_no);
            type_inputes.getElementsByTagName("input")[1].setAttribute('comment_this_thought',id);
}
function clothComment(e){
        document.getElementsByClassName("commentContainer")[0].style.display = "none";
        type_inputes.style.position = "unset";
        type_inputes.getElementsByTagName("input")[1].placeholder = "type what you are thinking";
        type_inputes.getElementsByTagName("input")[1].removeAttribute('comment_this_thought');
        type_inputes.getElementsByTagName("input")[1].removeAttribute('prev_com_no');
}

function readComment(id){
    var commentContainer = document.getElementsByClassName("commentContainer")[0];
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
            commentContainer.innerHTML = ajax.response;
        }
    }
    form.append("userid",userid);
    form.append("request_type","thought");
    form.append("data_type","read_comment");
    form.append("thoughtid",id);

    ajax.open("POST",DIR,true);
    ajax.send(form);
}