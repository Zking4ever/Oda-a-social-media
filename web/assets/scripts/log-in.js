var notification = document.getElementsByClassName('notification')[0];

function delay(t){
    return new Promise(response=>setTimeout(response,t));
}

var login = document.getElementsByClassName('login')[0];
var childinputL = login.getElementsByTagName('input');
var childlabelL = login.getElementsByTagName('label');

for(var i=0;i<childinputL.length-1;i++){
    childinputL[i].onfocus = function(){
        var index = getIndexFromList(childinputL,this);
        childlabelL[index].className="activelable";
        //childlabelL[index].style.transform ="translateY(-5px) translateX(-90px)";
        //childlabel[index].style.backgroundColor="white";
        this.onfocus = false;
    }
}
function getIndexFromList(list,element){
    for(var i=0;i<list.length;i++){
        if(list[i]==element){
            return i;
        }
    }
    return -1;
}


function submitData(no){
    if(no==1){
        handleRequest("log_in");
    }else if(no==2){
        handleRequest("sign_up");
    }
}
function handleRequest(type){

    var form = new FormData;
    if(type == "log_in"){
        var input = login.getElementsByTagName('input');
            for(let i=0;i<input.length-1;i++){
                if(input[i].value == ""){
                    handleResponse("Empty values are not allowed","error");
                    return;
                }
            }
            form.append('email',input[0].value);
            form.append('password',input[1].value);
    }
    form.append('type',type);
    var xml = new XMLHttpRequest;
    xml.onload = function(){
        if(xml.readyState==4 || xml.status==200){
            var response = JSON.parse(xml.response);
            if(response['status']=="bad"){
                handleResponse(response["result"],"error");
                return;
            }
            if(response['result']=="log in"){
                    location.href = "https://oda.social-networking.me/web/home.php";
            }
            handleResponse(response["result"]);
        }
    }
    xml.open("POST","web/sign.php",true); 
    xml.send(form);
}

async function handleResponse(result,type){
    if(type=="error"){
        notification.style.backgroundColor = "#ea6969";
    }else{
        notification.style.backgroundColor = "green";
    }
    notification.innerHTML = result;
    notification.style.top = "3%";
    await new Promise(resp=>setTimeout(resp,2000));
    notification.style.top = "-10%";
}
