var to_sign_up = document.getElementById("to_sign_up");
var to_log_in = document.getElementById("to_log_in");

var part1 = document.getElementsByClassName('part1')[0];
var part3 = document.getElementsByClassName('part3')[0];

to_log_in.onclick = function(){
    part3.style.display ="flex";
    part1.style.display ="none";
}

to_sign_up.onclick = function(){
    part1.style.display ="flex";
    part3.style.display ="none";
}

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