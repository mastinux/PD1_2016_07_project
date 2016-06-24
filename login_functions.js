function checkEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function register(){
    var email = document.getElementById("new-email").value;
    var password = document.getElementById("new-password").value;
    var repeated_password = document.getElementById("new-password-repeated").value;

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

    /*
    if ( valid_email && valid_password){
        var form = document.getElementById("register-form");
        form.setAttribute("method", "post");
        form.setAttribute("action", "register.php");
        form.submit()
    }
    */
}

function login() {

}