var contributers = document.getElementsByClassName('contributers')[0];

//story managing and sharing
var manage_story = document.getElementsByClassName('manage_story')[0];
var preview_img = document.getElementById('preview_img');

function preveiw(e){
    //checking the file type
        var filename = e.target.files[0].name;
        var ex_start = filename.lastIndexOf('.');
        var ex = filename.substr(ex_start+1,3);
        if(!(ex=='jpg' || ex=='JPG' || ex=='HEIC')){
            handleResult('File not supported','story');
            return;
        }
        //here change the preview img
        var checkform = new FormData;
        var xml = new XMLHttpRequest;
        loading("PREPARING...wait a momment..");
        xml.onload = function(){
                    if(xml.readyState==4){
                        finishedLoading();
                        contributers.style.display = "flex";
                        manage_story.style.display ="flex";
                        preview_img.src = 'backend/' + xml.response; 
                    }
            }
        checkform.append('type','get_path');
        checkform.append('request_type',"add_story");
        checkform.append('file',e.target.files[0]);
        xml.open("POST","backend/api.php");
        xml.send(checkform);
}

var view_story = document.getElementsByClassName('view_story')[0];
var view_story_div = document.getElementsByClassName('view_story_div')[0];
var idInView;
var members;
let n ;
function see_story(e){
    idInView = e.target.id;
    
    var checkform = new FormData;
    var xml = new XMLHttpRequest;
    loading("Processing...wait a momment..");
    xml.onload = function(){
            if(xml.readyState==4 || xml.status==200){
                        var storyResponse = JSON.parse(xml.response);
                        view_story_div.innerHTML="";//cleaning everything for new views
                        storyResponse.forEach(element => {
                            var components = element.split("s9par@tor");
                            var div = document.createElement("div");
                            var img = document.createElement("img");
                            var caption = document.createElement("span");
                            img.src =  "backend/"+components[0];
                            caption.innerHTML = components[1];
                            div.style.position = "relative";
                            div.appendChild(img);
                            div.appendChild(caption);
                            view_story_div.appendChild(div);
                        });
                        members = view_story_div.getElementsByTagName("div");
                        n = Math.floor(members.length);
                        switch_stories();
                        finishedLoading();//now display
                        contributers.style.display = "flex";
                        view_story.style.display ="flex";
                    }
            }
        checkform.append('type','see_story');
        checkform.append('request_type','see_story');
        checkform.append('sendersid',idInView);
        xml.open("POST","backend/api.php");
        xml.send(checkform);
}
var btn1 = document.getElementById('btn1');
var btn2 = document.getElementById('btn2');

async function switch_stories(num){
    if(idInView==null){
        return;
    }

    if(num!=null){
        change(num);
    }
    function change(num){
        n +=num;
    }
    if(n<0){
        n = members.length-1;
    }

    if(n > members.length-1){
        n = 0;
    }

    for(var i=0;i<members.length;i++){
        members[i].style.display="none";
    }

    members[n].style.display="block";
}

btn2.onclick = function(){
    switch_stories(1);
}
btn1.onclick = function(){
    switch_stories(-1);
}
view_story.ondblclick = function(){
    view_story.style.display = "none";
    contributers.style.display = "none";
}


//sharing story

var share_story = document.getElementById('share_story');
var story_img = document.getElementById('story_img');
var story_caption = document.getElementById('story_caption');

share_story.onclick = function(){
    var file = document.getElementById('story_img').files[0];
    var caption = story_caption.value;
    manage_story.style.display ="none";
    loading("Uploading your stories...");
    var myform = new FormData;
        var ajax = new XMLHttpRequest;
            ajax.onload = function(){
                    if(ajax.readyState==4 || ajax.status == 200){
                        handleResult(ajax.response,'story');
                    }
            }
        myform.append('caption',caption);
        myform.append('type','share_story');
        myform.append('request_type',"add_story");
        
        myform.append('file',file);
        ajax.open("POST","backend/api.php");
        ajax.send(myform);
}