
function validateForm()
{
    alert("ValidateForm called");

    var personalInfoObj = document.getElementById("personalInfo");
    var salutation = personalInfoObj.id_salutation.value;
    var firstName = personalInfoObj.id_firstName.value;
    var lastName = personalInfoObj.id_lastName.value;
    var email = personalInfoObj.id_email.value;
    var phone = personalInfoObj.id_phone.value;
    var everythingOK = true;
    
    var emailPattern = /^\S+@\S+\.\w+$/;
    var phonePattern = /[0-9]{3}[\s|-][0-9]{3}[\s|-]*[0-9]{4}/;
    
    
    if  (salutation == "Title") {
        alert("Enter your title");
        everythingOK = false;
    } else if ((firstName.length < 3) || (firstName == "First name")) {
        alert("Enter First Name");
        everythingOK = false;
    } else if ((lastName.length < 3) || (lastName == "Your surname")) {
        alert("Enter Surname");
        everythingOK = false;
    } else if ((email.length == 0) || (!emailPattern.test(email))) {
        alert("Not a valid e-mail address");
        everythingOK = false;
    } else if (!phonePattern.test(phone)) { 
        alert("Enter a valid phone number - format 012 420-0000");
        everythingOK = false;
    }
    
    //alert("End of Validate call" + everythingOK);
    
    return everythingOK;

}