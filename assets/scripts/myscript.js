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
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
            alert(ajax.response);
        }
    }
    form.append("request_type","resonse_to_suggestion");
    form.append("friendid",id);
    form.append("response","send");
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}
//responding to request
function  response(id,relationid){
    var form = new FormData;
    var ajax = new XMLHttpRequest;
    ajax.onload = function(){
        if(ajax.readyState==4 || ajax.status==200){
            alert(ajax.response);
        }
    }
    form.append("request_type","resonse_to_suggestion");
    form.append("relationid",relationid);
    form.append("friendid",id);
    form.append("response","confirm");
    ajax.open("POST","backend/api.php",true);
    ajax.send(form);
}