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

    }
//sharing story

var share_story = document.getElementById('share_story');
var story_img = document.getElementById('story_img');
var story_caption = document.getElementById('story_caption');

share_story.onclick = function(){
    var file = story_img.files[0];
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
        myform.append('file',file);
        ajax.open("POST","backend/post_story.php");
        ajax.send(myform);
}