function validform() {

    var a = document.forms["my-form"]["first_name"].value;
    var b = document.forms["my-form"]["last_name"].value;    
    var c = document.forms["my-form"]["email_address"].value;
    var d = document.forms["my-form"]["password"].value;

    if (a==null || a=="")
    {
        alert("Please enter your first name!");
        return false;
    }else if (b==null || b=="")
    {
        alert("Please enter your last name!");
        return false;
    }else if (c==null || c=="")
    {
        alert("Please Enter your email address!");
        return false;
    }else if (d==null || d=="")
    {
        alert("Please create a password!");
        return false;
    }

}