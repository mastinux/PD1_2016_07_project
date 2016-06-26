function checkEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function register(){
    var email = document.getElementById("new-email").value;
    var password = document.getElementById("new-password").value;
    var repeated_password = document.getElementById("new-password-repeated").value;

    // TODO: remove previous messages by id

    if ( !email || !password || !repeated_password ){
        console.log("Email or password not inserted in registration form.");
        var navbar = document.getElementById("navbar");

        var div = document.createElement("div");
        div.setAttribute("class", "col-lg-12");
        navbar.parentNode.insertBefore(div, navbar.nextElementSibling);

        var textDiv = document.createElement("div");
        textDiv.setAttribute("class", "alert alert-warning alert-dismissible");
        textDiv.setAttribute("role", "alert");
        textDiv.innerHTML = "Email or password not inserted in registration form.";

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

    return false;

    var valid_email = false;
    var valid_password = false;

    // checking email
    if ( !checkEmail(email)){
        console.log("invalid email");
        var error_message = document.getElementById("error-message");
        error_message.setAttribute("class", "alert alert-warning");
        error_message.innerHTML = "Please enter proper email."
    }
    else{
        // extracting username from email
        console.log("valid email");
        valid_email = true;
        var username = email.substr(0, email.indexOf('@'));
        console.log("username: ", username);
    }

    // checking match between password and repeated_password
    if (password != repeated_password) {
        console.log("password mismatch");
        var error_message = document.getElementById("error-message");
        error_message.setAttribute("class", "alert alert-warning");
        error_message.innerHTML = "Please repeat same password."
    } else {
        console.log("passwords match");
        valid_password = true;
    }

    if ( !(valid_email && valid_password) ) {
        return false;
    }
}

function login() {
    
}