var to_sign_up = document.getElementById("to_sign_up");
var to_log_in = document.getElementById("to_log_in");

var one = document.getElementsByClassName('one')[0];
var two = document.getElementsByClassName('two')[0];

to_log_in.onclick = function(){
    one.style.display ="block";
    two.style.display ="none";
}

to_sign_up.onclick = function(){
    one.style.display ="none";
    two.style.display ="block";
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