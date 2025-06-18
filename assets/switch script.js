var part1 = document.getElementsByClassName('part1')[0];
var part2 = document.getElementsByClassName('part2')[0];
var sign_up = document.getElementsByClassName('sign_up')[0];
var login = document.getElementsByClassName('login')[0];

function delay(t){
    return new Promise(response=>setTimeout(response,t));
}
async function logIn(){
    part1.style.transform ="translateX(200%)";
    part2.style.transform ="translateX(-50%)";
    await delay(500);
    sign_up.style.display = "none";
    login.style.display = "flex";
}

async function signUp(){
    part1.style.transform ="translateX(0)";
    part2.style.transform ="translateX(0)";
    await delay(500);
    login.style.display = "none";
    sign_up.style.display = "flex";
};

var childinput = sign_up.getElementsByTagName('input');
var childlabel = sign_up.getElementsByTagName('label');
var childinputL = login.getElementsByTagName('input');
var childlabelL = login.getElementsByTagName('label');

for(var i=0;i<childinput.length;i++){
    childinput[i].onfocus = function(){
        var index = getIndexFromList(childinput,this);
        childlabel[index].style.transform ="translateY(-5px) translateX(-90px)";
        //childlabel[index].style.backgroundColor="white";
        this.onfocus = false;
    }
}
for(var i=0;i<childinputL.length;i++){
    childinputL[i].onfocus = function(){
        var index = getIndexFromList(childinputL,this);
        childlabelL[index].style.transform ="translateY(-5px) translateX(-90px)";
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