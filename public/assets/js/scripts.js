window.onscroll = function() {
    navbar();
    topb();
}

//window.onload=function(){}

/*  top button  */

function topb() {
    let topbutton = document.querySelector("#top");

    if (document.body.scrollTop > height || document.documentElement.scrollTop > height)
        topbutton.style.display = "block";
    else
        topbutton.style.display = "none";
}
/*  Navbar stickness  */
function navbar() {
    if (window.pageYOffset >= height) {
        nav.classList.add("sticky");
        managebar.style.marginTop=nav.offsetHeight;
    } else {
        nav.classList.remove("sticky");
        managebar.style.marginTop="0px";
    }                                                                                                      
}


function add_topic(){
    let overlay =document.querySelector("#topic");
    overlay.style.display="flex";
}

function add_gallery(){
    let gallery= document.querySelector("#gallery");
    gallery.style.display="flex";
}

function gettime(){
    const date=new Date();
    let day=date.getDay();
    let hour=date.getHours();
    let minute=date.getMinutes();
    let time;
    if (minute<10) {
        time=hour+":"+"0"+minute;
    }
    else{
        time=hour+":"+minute;
    }
    let currTime=document.getElementById("crnt-time");
    let info=document.getElementById("openning-hours");

    currTime.innerHTML="Aktuálny čas: "+time;
}
