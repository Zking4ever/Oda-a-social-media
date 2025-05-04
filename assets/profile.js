var option_btn = document.getElementsByClassName('option_btn')[0];
var options = document.getElementsByClassName('options')[0];
var close_btn = document.getElementsByClassName('close')[0];

option_btn.onclick = function(){
    options.style.display = "block";
}
close_btn.onclick = function(){
    options.style.display = "none";
}