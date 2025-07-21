var part1 = document.getElementsByClassName('part1')[0];
var part2 = document.getElementsByClassName('part2')[0];
var sign_up = document.getElementsByClassName('sign_up')[0];
var login = document.getElementsByClassName('login')[0];
var notification = document.getElementsByClassName('notification')[0];

function delay(t){
    return new Promise(response=>setTimeout(response,t));
}
async function logIn(){
    part1.className="part1";
    part2.style.transform ="translateX(0)";
    await delay(500);
    sign_up.style.display = "none";
    login.style.display = "flex";
}

async function signUp(){
    part1.className="part1 moved";
    part2.style.transform ="translateX(50%)";
    await delay(500);
    login.style.display = "none";
    sign_up.style.display = "flex";
};

var childinput = sign_up.getElementsByTagName('input');
var childlabel = sign_up.getElementsByTagName('label');
var childinputL = login.getElementsByTagName('input');
var childlabelL = login.getElementsByTagName('label');

for(var i=0;i<childinput.length-1;i++){
    childinput[i].onfocus = function(){
        var index = getIndexFromList(childinput,this);
        childlabel[index].className="activelable";
        //childlabel[index].style.transform ="translateY(-5px) translateX(-90px)";
        //childlabel[index].style.backgroundColor="white";
        this.onfocus = false;
    }
}
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
    if(type == "sign_up"){
        var input = sign_up.getElementsByTagName('input');
            for(let i=0;i<input.length-1;i++){
                if(input[i].value == ""){
                    handleResponse("Empty values are not allowed","error");
                    return;
                }
            }
            form.append('fname',input[0].value);
            form.append('lname',input[1].value);
            form.append('email',input[2].value);
            form.append('password',input[3].value);
    }
    else if(type == "log_in"){
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
                var external = document.getElementById("external");
                external.action ="external/check.php";
                var check_btn = document.getElementById("check_btn");
                check_btn.click();
                return;
            }
            handleResponse(response["result"]);
        }
    }
    xml.open("POST","external/sign_in_up.php",true); 
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

//password strength test
var password = document.getElementById("password2");
var sign_up_btn = document.getElementById("sign_up_btn");
var passStrength = document.getElementById("passStrength");

password.addEventListener('focus',function(){
        passStrength.style.display = "grid";
});

password.addEventListener("keyup",function(){
        var input = password.value;
        var radians = passStrength.getElementsByTagName("input");
        passStrength.style.height = "90px";
        
            checkForLength(input,radians[0]);
            checkForUpperCase(input,radians[1]);
            checkForLowerCase(input,radians[2]);
            checkForSpecialChar(input,radians[3]);
            checkForNumber(input,radians[4]);

        sign_up_btn.disabled = true;
        if(radians[0].checked && radians[1].checked && radians[2].checked && radians[3].checked && radians[4].checked && radians[5].checked){
             sign_up_btn.disabled = false;
        }
});

function checkForLength(inputValue,element){
    inputValue = inputValue.split("");
    if(inputValue.length>=8){
        element.checked=true;
        return;
    }
    element.checked = false;
}
function checkForUpperCase(inputValue,element){
    var alph = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    for(let i=0;i<inputValue.length;i++){
       for(let j=0;j<alph.length;j++){
            if(inputValue[i]==alph[j]){
                element.checked = true;
                return;
            }
       }
    }
    
    element.checked = false;
}
function checkForLowerCase(inputValue,element){
    var alph =  ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    for(let i=0;i<inputValue.length;i++){
       for(let j=0;j<alph.length;j++){
         if(inputValue[i]==alph[j]){
            element.checked = true;
            return;
         }
       }
    }
    
    element.checked = false;
}
function checkForSpecialChar(inputValue,element){
    var alph =  ['@', '$', '#', '%', '&', '^', '(', ')', '-', '+'];

    for(let i=0;i<inputValue.length;i++){
       for(let j=0;j<alph.length;j++){
         if(inputValue[i]==alph[j]){
            element.checked = true;
            return;
         }
       }
    }
    
    element.checked = false;
}
function checkForNumber(inputValue,element){
    var alph =  ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    for(let i=0;i<inputValue.length;i++){
       for(let j=0;j<alph.length;j++){
         if(inputValue[i]==alph[j]){
            element.checked = true;
            return;
         }
       }
    }
    
    element.checked = false;
}