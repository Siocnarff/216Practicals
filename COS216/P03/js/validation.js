function validate() {
    let form = document.forms["register"];
    let name = form["name"].value;
    let surname = form["surname"].value;
    let email = form["email"].value;
    let password = form["password"].value;

    let message = "";
    if(!validateEmail(email)) {
        message += "Email address must contain a '@' symbol.\n"
    }
    if (name.length <= 0 || name.length > 40) {
        message += "Name must be between 1 and 40 characters in length.\n"
    }
    if (surname.length <= 0 || surname.length > 40) {
        message += "Surname must be between 1 and 40 characters long.\n"
    }
    if(!validatePassword(password)) {
        message += "Password should be longer than 8 characters, contain upper and" +
            " lower case letters, at least one digit and one symbol.\n"
    }
    if(message.length !== 0) {
        alert("Your form seems to have some errors.\n\n" + message)
    }
}

function validateEmail(email) {
    let strictRe = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
    let lenientRe = /^\S+@\S+\.\S+$/;
    if (strictRe.test(email)) {
        let yes = confirm("Something looks strange. Are you sure " + email + " is correct?");
        if(!yes) {
            return false;
        }
    }
    return lenientRe.test(email)
}

function validatePassword() {
    let re = /
}