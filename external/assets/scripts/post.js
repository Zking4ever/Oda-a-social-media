

function reactPost(event,num){
    var element = event.target;
    if(!element.id){
        element = element.parentElement;
    }
    var span = element.getElementsByTagName('span')[0];
    var postid  = element.id;
    var number  = span.innerHTML;
    var react_type = (num==1 ? "likes" : "reposts");
    var status;

    if(element.className == 'react reacted'){
        //this time user is removing the 
        element.className = 'react';
        number--;
        status = "removing";
    }else{
        //user reacting
        element.className = 'react reacted';
        number++;
        status = "reacting";
    }

    var form = new FormData;
    var xml = new XMLHttpRequest;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
            if(xml.response == "saved to db"){
                span.innerHTML = number;
            }
        }
    }

    form.append("request_type","post_reaction");
    form.append("data_type","post_reaction");
    form.append("react_type",react_type);
    form.append("postid",postid);
    form.append("number",number);
    form.append("status",status);

    xml.open("POST","backend/api.php",true);
    xml.send(form);

}

function postComments(e){
    var element = e.target;
    if(!element.id){
        element = element.parentElement;
    }
    var span = element.getElementsByTagName('span')[0];
    var postid  = element.id;
    var number  = span.innerHTML;
        var commentContainer = document.getElementsByClassName("commentContainer")[0];
        commentContainer.style.display = "block";
        readPostComment(postid);
        //preparing for writing comment
            type_inputes.style.display = "flex";
            type_inputes.getElementsByTagName("label")[0].style.display = "none";
            type_inputes.getElementsByTagName("input")[1].placeholder = "comment on this post";
            type_inputes.getElementsByTagName("input")[1].setAttribute('prev_com_no',number);
            type_inputes.getElementsByTagName("input")[1].setAttribute('comment_this_post',postid);
}

function readPostComment(postid){
    
        var commentContainer = document.getElementsByClassName("commentContainer")[0];
        //commentContainer.innerHTML = "post comment on "+postid+" goes here";
        var form = new FormData;
        var xml= new XMLHttpRequest;
        xml.onload = function(){
            if(xml.readyState==4 || xml.status==200){
                commentContainer.innerHTML = xml.response;
            }
        }
        form.append("request_type","post_reaction");
        form.append("data_type","read_comment");
        form.append("postid",postid);

        xml.open("POST","backend/api.php",true);
        xml.send(form);
}
function clothPostComment(e){
        e.target.parentElement.style.display = "none";
        type_inputes.getElementsByTagName("label")[0].style.display = "block";
        type_inputes.style.display = "none";
        type_inputes.getElementsByTagName("input")[1].removeAttribute('comment_this_post');
        type_inputes.getElementsByTagName("input")[1].removeAttribute('prev_com_no');
}

radios[0].click();
//everytime the page starts with home