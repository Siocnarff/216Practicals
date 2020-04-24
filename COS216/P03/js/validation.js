function validate() {
    let form = document.forms["register"];
    let name = form["name"].value.trim();
    let surname = form["surname"].value.trim();
    let email = form["email"].value.trim();
    let password = form["password"].value;

    let message = "";
    if(!validEmail(email)) {
        return false;
    }
    if (!validName(name)) {
        message += "You must enter a name, only alphabetical characters allowed.\n";
    }
    if (!validName(surname)) {
        message += "You must enter a surname, only alphabetical characters allowed.\n";
    }
    if(!validPassword(password)) {
        message += "Password should be longer than 8 characters, contain upper and" +
            " lower case letters as well as at least one digit and one symbol.\n";
    }
    if(message.length !== 0) {
        alert("Your form seems to have some errors.\n\n" + message);
        return false;
    }
    return true;
}

function validEmail(email) {
    let strictRe = /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/;
    if (!strictRe.test(email)) {
        return confirm("Woa! Unusual email address detected.\nAre you sure\n" + email + "\nis correct?");
    }
    return true;
}

function validName(name) {
    let re = /^[a-zA-Z]{1,40}$/;
    return re.test(name);
}

function validPassword(password) {
    let re = /(?=^.{9,}$)((?=.*\w)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[|!"@#$%&\/()?^'\\+\-*]))^.*/;
    return re.test(password);
}
