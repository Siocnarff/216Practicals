function validate() {
    let form = document.forms["register"];
    let name = form["name"].value.trim();
    let surname = form["surname"].value.trim();
    let email = form["email"].value.trim().toLowerCase();
    let password = form["password"].value;

    let message = "";
    if(!validEmail(email)) {
        message += "Your email address is not valid";
    }
    if (!validName(name)) {
        message += "Your name may only contain alphabetical characters.\n";
    }
    if (!validName(surname)) {
        message += "Your surname may only contain alphabetical characters.\n";
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
    let standardRe = /(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)])/;
    let valid = standardRe.test(email);
    if (!strictRe.test(email)) {
        return valid && confirm("Woa! Unusual email address detected.\nAre you sure\n" + email + "\nis correct?");
    }
    return valid;
}

function validName(name) {
    let re = /^[a-zA-Z\s]{1,40}$/;
    return re.test(name);
}

function validPassword(password) {
    let re = /(?=^.{9,}$)((?=.*\w)(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[|!"@#$%&\/()?^'\\+\-*]))^.*/;
    return re.test(password);
}
