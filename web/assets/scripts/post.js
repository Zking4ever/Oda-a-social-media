radios[0].click();
//everytime the page starts with home

var isLoading=false;

var post = document.getElementsByClassName('post');

loaded_post.addEventListener('scroll',function(){
    
    Loader = post[post.length-1]; //to fetch post
    if(!Loader || Loader.id != "postLOADER"){ //this means there is no post loging gif here 
        return;
    }
    if(window.getComputedStyle(Loader).opacity !=1){
        if(!isLoading){
            isLoading=true;
            fetch_post();
        }
    }
});

function scrollThought() {
    Loader = document.getElementById('thoughtLoader'); //checking if it is the thought loader
        if(!Loader){
            return;
        }else{ 
            if(window.getComputedStyle(Loader).opacity !=1){
                if(!isLoading){ // to not request twise 
                    isLoading=true;
                    fetchThought();
                }
            }
        }
}

function fetch_post(){
        Loader = post[post.length-1];
        var xml = new XMLHttpRequest;
        xml.onload = function(){ 
            if(xml.readyState==4 || xml.status==200){
                var response = JSON.parse(xml.response);
                if( (response['posts'].split('NO NEW POST')).length ==2){ 
                    // the response is no new post 
                    if(post[post.length-2].textContent == '  NO NEW POST.. '){
                        //and already it has been displayed
                        isLoading=false; //for next time loading
                        return;
                   }
                }else if(post[post.length-2].textContent == '  NO NEW POST.. '){
                    loaded_post.removeChild(post[post.length-2]);
                }
                loaded_post.removeChild(Loader);
                loaded_post.innerHTML += response['posts'];
                isLoading=false;
            }
        }
    //in case if posts on the server are already marked as seen(previously) but not visible now 'cause the server filters
    //but what if the user wants to see again it or no new post found,the response will be to make those visible until there is no invisible
    //so i need to send which are currently visible
    var visiblePosts = [];
    var posts = document.getElementsByClassName('post');
    for(let i=0;i<posts.length;i++){
        var react = posts[i].getElementsByClassName('react')[0];
        if(react && !visiblePosts.includes(react.id)){
            visiblePosts.push(react.id);
        }
    }
        visiblePosts = JSON.stringify(visiblePosts);
        var form = new FormData;
        form.append("userid",userid);
        xml.open("POST",DIR+"?request_type=fetch_post&&visiblePosts="+visiblePosts,true);
        xml.send(form);
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
        if(xml.readyState==4){
            seenPost.push(postid);
        }
    }
    form.append("userid",userid);
    form.append("request_type","post_reaction");
    form.append("data_type","post_seen");
    form.append("postid",postid);

    xml.open("POST",DIR,true);
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

    form.append("userid",userid);
    form.append("request_type","post_reaction");
    form.append("data_type","post_reaction");
    form.append("react_type",react_type);
    form.append("postid",postid);
    form.append("number",number);
    form.append("status",status);

    xml.open("POST",DIR,true);
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
        
        form.append("userid",userid);
        form.append("request_type","post_reaction");
        form.append("data_type","read_comment");
        form.append("postid",postid);

        xml.open("POST",DIR,true);
        xml.send(form);
}
function clothPostComment(e){
        e.target.parentElement.style.display = "none";
        type_inputes.getElementsByTagName("label")[0].style.display = "block";
        type_inputes.style.display = "none";
        type_inputes.getElementsByTagName("input")[1].removeAttribute('comment_this_post');
        type_inputes.getElementsByTagName("input")[1].removeAttribute('prev_com_no');
}
var seenThoughts = [];
function seeThought(e){
    var element = e.target;
    var id = element.getElementsByTagName('div')[3].id;
    if(seenThoughts.includes(id)){
        return;
    }
    var form = new FormData;
    var xml = new XMLHttpRequest;
    xml.onload = function (){
        if(xml.readyState==4){
            seenThoughts.push(id);
        }
    }
    
    form.append("userid",userid);
    form.append("request_type","thought");
    form.append("data_type","see");
    form.append("thoughtid",id);

    xml.open("POST",DIR,true);
    xml.send(form);
}

function fetchThought(){
    var form = new FormData;
    var xml = new XMLHttpRequest;
    var all = document.getElementsByClassName("thoughtBox");
    xml.onload = function (){
        if(xml.readyState==4){
            var container = document.getElementsByClassName('thoughts')[0];
            if(all[all.length-2].textContent == "No new thought found.."){  //the last thought
                if(xml.response.split('No new thought found..').length ==2){
                    return;//the response is no new found and it was alredy displayed no need to do again
                    //but if there is a new one it is going to be displayed
                }else{
                    container.removeChild(all[all.length-2]); // the notification--> no new message --< has to be removed since it found a new one
                }
            }
            container.removeChild(all[all.length-1]);//this is the loader
            container.innerHTML += xml.response;
            isLoading=false; //for next time loading
        }
    }
    var thoughtids = [];
    for(let i=0;i<all.length-1;i++){
        var ele = all[i].getElementsByTagName('div')[3];
        if(ele){
            thoughtids.push(ele.id);
        }
    }
    thoughtids = JSON.stringify(thoughtids);
    
    form.append("userid",userid);
    form.append("request_type","fetch_thought");
    form.append("visibles",thoughtids);

    xml.open("POST",DIR,true);
    xml.send(form);
}
