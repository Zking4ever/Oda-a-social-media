
function passVisiblity(e){
                    pass = e.target.parentElement.getElementsByTagName('input')[0];
                    if(pass.type=="password"){
                        pass.type = "text";
                    }else{
                        pass.type = "password";
                    }
                }
function change_profile_img(e){
    if(!confirm("Do you want to change your profile picture?")){
        return;
    }
    var label = e.target.parentElement.getElementsByTagName("label")[0];
    label.innerHTML = "Uploading your profile..";
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
           if(ajax.response == "done"){
                handleResult("Profile changed successfuly","story");
                label.innerHTML = "Change Profile";
           }
        }
    }
    form.append('request_type',"change_profile_picture");
    form.append('profile_image',e.target.files[0]);
    
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}