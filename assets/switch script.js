var to_sign_up = document.getElementById("to_sign_up");
var to_log_in = document.getElementById("to_log_in");

var part1 = document.getElementsByClassName('part1')[0];
var part2 = document.getElementsByClassName('part2')[0];
var part3 = document.getElementsByClassName('part3')[0];
var temp;
function delay(t){
    return new Promise(response=>setTimeout(response,t));
}
async function logIn(){
    part1.style.transform ="translateX(133%)";
    part2.style.transform ="translateX(-75%)";
    await delay(500);
    temp = part1.innerHTML;
    part1.innerHTML = part3.innerHTML;
}

async function signUp(){
    part1.style.transform ="translateX(0)";
    part2.style.transform ="translateX(0)";
    await delay(500);
    part1.innerHTML = temp;
};

var email = document.getElementById("email");
var email_lable = document.getElementById("email_lable");
var password = document.getElementById("password");
var password_lable = document.getElementById("password_lable");

email.onfocus = function(){
    email_lable.style.transform ="translateY(10px) translateX(-270px)"
}
password.onfocus = function(){
    password_lable.style.transform ="translateY(10px) translateX(-250px)"
}