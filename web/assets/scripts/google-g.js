var payload;
var container = document.getElementsByClassName('container')[0];

var password = document.getElementById("passwordP");
var password2 = document.getElementById("password2");
var usernameInput = document.getElementById("username");
var btn = document.getElementById("btn");
var passStrength = document.getElementById("passStrength");

//password strength test
password.addEventListener('focus',function(){
        passStrength.style.display = "grid";
});

password.addEventListener("keyup",function(){
        var input = password.value;
        var radians = passStrength.getElementsByTagName("input");
        passStrength.style.height = "90px";
        
            checkForLength(input,radians[0]);
            checkForMatching(password2.value,radians[1]);
            checkForUpperCase(input,radians[2]);
            checkForLowerCase(input,radians[3]);
            checkForSpecialChar(input,radians[4]);
            checkForNumber(input,radians[5]);

        btn.disabled = true;
        if(radians[0].checked && radians[2].checked && radians[3].checked && radians[4].checked && radians[5].checked){
             if(radians[1].checked){
                btn.disabled = false;
             }
        }
});

password2.addEventListener("keyup",function(){
        var radians = passStrength.getElementsByTagName("input");
            checkForMatching(this.value,radians[1]);
        if(radians[0].checked && radians[2].checked && radians[3].checked && radians[4].checked && radians[5].checked){
             if(radians[1].checked){
                btn.disabled = false;
             }
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
function checkForMatching(inputValue,element){
    var firstOnes = password.value;
    if(inputValue == firstOnes){
        element.checked = true;
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

function handleCredentialResponse(response) {
    // Decode the ID token and handle the user data
    const idToken = response.credential;
    payload = atob(idToken.split('.')[1]);
    var form = new FormData;
    var xml = new XMLHttpRequest;
        xml.onload = function(){
            if(xml.status==200){
                if(xml.response == "done"){
                    location.href = "https://oda.social-networking.me/web/home.html";
                }else{
                    container.style.display = "block";
                    //for sign up
                }
            }
        }
        form.append("userinfo", payload);
        xml.open("POST","web/handle.php",true);
        xml.send(form);
    }
window.onload = function () {
    google.accounts.id.initialize({
        client_id: "866620799082-2masej40mt8jaldbh2urcf9hbtel9kef.apps.googleusercontent.com",
        callback: handleCredentialResponse
    });

    google.accounts.id.renderButton(
        document.getElementById("google-signin-button"),
        { theme: "outline", size: "large",text: "continue_with",type: "standard",width:"100%" } 
    );
};
    

btn.onclick = function(e){
    btn.disabled = true;
    e.preventDefault();
    if(usernameInput.value == "" || password.value == ""){
        handleResponse("Empty values are not allowed","error");//notify
    }
    if(!payload){
        handleResponse("unexpected google response","error");
        return;
    }
    var form = new FormData;
    var xml = new XMLHttpRequest;
        xml.onload = function(){
            if(xml.status==200){
                    alert(xml.response)
                if(xml.response == "done"){
                    location.href = "https://oda.social-networking.me/web/home.html";
                }else{
                    btn.disabled = false;
                }
            }
        }
        form.append("userinfo", payload);
        form.append("type", "sign_up");
        form.append("username", usernameInput.value);
        form.append("password", password.value);
        xml.open("POST","web/handle.php",true);
        xml.send(form);
}