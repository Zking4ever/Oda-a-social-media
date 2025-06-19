var option_btn = document.getElementsByClassName('option_btn')[0];
var options = document.getElementsByClassName('options')[0];
var close_btn = document.getElementsByClassName('close')[0];

option_btn.onclick = function(){
    options.style.display = "block";
}
close_btn.onclick = function(){
    options.style.display = "none";
}

//story managing and sharing
var manage_story = document.getElementsByClassName('manage_story')[0];
var preview_img = document.getElementById('preview_img');

function preveiw(e){
    manage_story.style.display ="flex";
    //checking the file type
        var filename = e.target.files[0].name;
        var ex_start = filename.lastIndexOf('.');
        var ex = filename.substr(ex_start+1,3);
        if(!(ex=='jpg' || ex=='JPG')){
            handleResult('File not supported','story');
            manage_story.style.display ="none";
            return;
        }
        //here change the preview img
        var checkform = new FormData;
        var xml = new XMLHttpRequest;
            xml.onload = function(){
                    if(xml.readyState==4){
                        preview_img.src = 'backend/' + xml.response; 
                    }
            }
        checkform.append('type','get_path');
        checkform.append('file',e.target.files[0]);
        xml.open("POST","backend/post_story.php");
        xml.send(checkform);
}

var view_story = document.getElementsByClassName('view_story')[0];
var view_story_div = document.getElementsByClassName('view_story_div')[0];
var idInView;
var members;
let n ;
function see_story(e){
    view_story.style.display ="flex";
    view_story_div.innerHTML = e.target.innerHTML;
    idInView = e.target.id;
    members = document.getElementsByClassName(idInView);
    n = Math.floor(members.length/2);
    switch_stories();
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
    if(n<(members.length/2)){
        n = members.length;
    }

    if(n>members.length){
        n = Math.floor(members.length/2);
    }

    for(var i=members.length/2;i<members.length;i++){
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
}


//sharing story

var share_story = document.getElementById('share_story');
var story_img = document.getElementById('story_img');
var story_caption = document.getElementById('story_caption');

share_story.onclick = function(){
    var file = document.getElementById('story_img').files[0];
    var caption = story_caption.value;
    var myform = new FormData;
        var ajax = new XMLHttpRequest;
            ajax.onload = function(){
                    if(ajax.readyState==4){
                        handleResult(ajax.response,'story');
                        manage_story.style.display ="none";
                    }
            }
        myform.append('caption',caption);
        myform.append('type','share_story');
        myform.append('file',file);
        ajax.open("POST","backend/post_story.php");
        ajax.send(myform);
}