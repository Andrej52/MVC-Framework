// kontrola zhodnosti hesiel
// password match script

function check() {
    var password = document.querySelector('#password').value;
    var confirm = document.querySelector('#repeat-password').value;
    let matching = document.querySelector('#message');
    let btn = document.querySelector('#signUp');
    matching.style.display="flex";
    btn.disabled = true
 
    matching.style.display="hidden";
    if (confirm == "" || password == "")
    {
            matching.style.display="none";
    }
    else if (confirm !== password) 
    {
            matching.innerHTML="Hesla sa nezhoduju";
            matching.style.color="red";
    } 
    else
    {
            matching.innerHTML="Hesla sa zhoduju";
            matching.style.color="lightgreen";     
            btn.disabled = false;
    }
            
}

function checkInputs(input)
{       

    if(input.value.match(/^([ a-z0-9])$/))
    {
            ("input " +input +" does not match");
    }
}

// check input
function show_Password(showPassword)
    {   
    if (showPassword.checked === true) 
    {            
            document.querySelector("#password").setAttribute("type","text");
            document.querySelector("#repeat-password").setAttribute("type","text");
    }
    else
    {
            document.querySelector("#password").setAttribute("type","password");
            document.querySelector("#repeat-password").setAttribute("type","password");
    }
    };


