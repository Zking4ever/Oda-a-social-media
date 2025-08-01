
function passVisiblity(e){
                    pass = e.target.parentElement.getElementsByTagName('input')[0];
                    if(pass.type=="password"){
                        pass.type = "text";
                        e.target.className = 'bi bi-eye-slash';
                    }else{
                        pass.type = "password";
                        e.target.className = 'bi bi-eye';
                    }
                }
function change_profile_img(e){
    if(!confirm("Do you want to change your profile picture?")){
        return;
    }
    var filetype = e.target.files[0].type;
    var file_type_desc = filetype.split('/');
    var file_catagory = file_type_desc[0];
    
    if(file_catagory !="image"){
        handleResult('File not supported','story');
        return;
    }
    var label = e.target.parentElement.getElementsByTagName("label")[0];
    label.innerHTML = "Uploading your profile..";
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = async function(){
        if(ajax.readyState==4 || ajax.status==200){
           if(ajax.response == "done"){
                handleResult("Profile changed successfuly","story");
                label.innerHTML = "Change Profile";
                await new Promise(response=>setTimeout(response,2000));
                radios[5].checked = false;
                radios[5].click();
           }
        }
    }
    form.append('userid',userid);
    form.append('request_type',"setting");
    form.append('data_type',"change_profile_picture");
    form.append('profile_image',e.target.files[0]);
    
    ajax.open("POST",DIR,true);
    ajax.send(form);
}

function saveSettings(e){
    if(confirm("Are you sure about the changes?")){
        var form = new FormData;
        var ajax = new XMLHttpRequest;
        ajax.onload = async function(){
            if(ajax.readyState==4 || ajax.status==200){
                handleResult(ajax.response,'story');//story cause just wanted to notify the result
                await new Promise(response=>setTimeout(response,2000));
                radios[5].checked = false;
                radios[5].click();
            }
        } 
        form.append('userid',userid);
        form.append('request_type',"setting");
        form.append('data_type',"save_setting");
        inputs = e.target.parentElement.getElementsByTagName('input');
        form.append('username',inputs[0].value);
        form.append('name',inputs[1].value);
        form.append('password',inputs[3].value);

        ajax.open("POST",DIR,true);
        ajax.send(form);
    }
}
