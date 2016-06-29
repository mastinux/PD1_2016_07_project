function checkEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //var re = new RegExp('[\!\#\$\%\&\'\*\+\-\/\=\?\^\_\`\{\|\}\~][a-zA-Z0-9_]@[a-zA-Z0-9_].[a-zA-Z]');
    console.log(re.test(email));
    return re.test(email);
}

function removeElementById(id) {
    var element = document.getElementById(id);
    element.parentNode.removeChild(element);
}

function printMessage(type, msg) {
    var types = ['info', 'success', 'warning', 'danger'];
    for (var i = 0; i < types.length; i++)
        if (document.getElementById(types[i] + "-msg"))
            removeElementById(types[i] + "-msg");

    var navbar = document.getElementById("navbar");

    var div = document.createElement("div");
    div.setAttribute("id", type + "-msg");
    div.setAttribute("class", "col-lg-12");
    navbar.parentNode.insertBefore(div, navbar.nextElementSibling);

    var textDiv = document.createElement("div");
    textDiv.setAttribute("class", "alert alert-" + type + " alert-dismissible");
    textDiv.setAttribute("role", "alert");
    textDiv.innerHTML = msg;

    div.appendChild(textDiv);

    var button = document.createElement("button");
    button.setAttribute("type", "button");
    button.setAttribute("class", "close");
    button.setAttribute("data-dismiss", "alert");
    button.setAttribute("aria-label", "Close");

    textDiv.appendChild(button);

    var span = document.createElement("span");
    span.setAttribute("aria-hidden", "true");
    span.innerHTML = "&times;";

    button.appendChild(span);
}

function register(){
    var email = document.getElementById("new-email").value;
    var password = document.getElementById("new-password").value;
    var repeated_password = document.getElementById("new-password-repeated").value;

    // checking empty values
    if ( !email || !password || !repeated_password ){
        console.log("Email or password not inserted in registration form.");
        printMessage("warning", "Email or password not inserted in registration form.");
        return false;
    }

    // checking email
    if ( !checkEmail(email) ){
        console.log("Invalid email.");
        printMessage("danger", "Invalid email inserted in registration form.");
        return false;
    }

    // checking match between password and repeated_password
    if (password != repeated_password) {
        console.log("Password does not match.");
        printMessage("danger", "Passwords inserted do not match in registration form.");
        return false;
    }

    return true;
}

function login() {
    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    // checking empty values
    if ( !username || !password ){
        console.log("Username or password not inserted in login form.");
        printMessage("warning", "Username or password not inserted in login form.");
        return false;
    }

    // checking email
    if ( !checkEmail(username) ){
        console.log("Invalid email.");
        printMessage("danger", "Invalid email inserted in login form.");
        return false;
    }

    return true;
}