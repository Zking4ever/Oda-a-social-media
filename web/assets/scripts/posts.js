radios[0].click();
//everytime the page starts with home

var isLoading=false;

var post = document.getElementsByClassName('post');

loaded_post.addEventListener('scroll',function(){
    
    Loader = post[post.length-1];
    if(!Loader || Loader.id != "postLOADER"){
        return;
    }
    if(window.getComputedStyle(Loader).opacity !=1){
        if(!isLoading){
            isLoading=true;
            fetch_post();
        }
    }
});

function fetch_post(){
        Loader = post[post.length-1];
        var xml = new XMLHttpRequest;
        xml.onload = function(){ 
            if(xml.readyState==4 || xml.status==200){
                console.log(xml.response);
                var response = JSON.parse(xml.response);
                loaded_post.removeChild(Loader);
                loaded_post.innerHTML += response['posts'];
                isLoading=false;
            }
        }
        xml.open("GET","backend/api.php?request_type=fetch_post",true);
        xml.send();
}

var seenPost = [];

function Post_seen(e){
    var element = e.target;
    while(element.className != 'post'){
        element = element.parentElement;
    }
    var postid = element.getElementsByClassName("react")[0].id;

    if(seenPost.includes(postid)){
        return;
    }
    var form = new FormData;
    var xml = new XMLHttpRequest;
    xml.onload = function (){
        seenPost.push(postid);
    }
    form.append("request_type","post_reaction");
    form.append("data_type","post_seen");
    form.append("postid",postid);

    xml.open("POST","backend/api.php",true);
    xml.send(form);
}

function reactPost(event,num){
    var element = event.target;
    if(!element.id){
        element = element.parentElement;
        if(!element.id){
            element = element.parentElement;
        }
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
        if(!element.id){
            element = element.parentElement;
        }
    }
    var span = element.getElementsByTagName('span')[0];
    var postid  = element.id;
    var number  = span.innerHTML;
        var commentContainer = document.getElementsByClassName("commentContainer")[0];
        commentContainer.style.display = "block";
        readPostComment(postid);
        //preparing for writing comment
            type_inputes.style.display = "flex";
            type_inputes.style.position = "absolute";
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
