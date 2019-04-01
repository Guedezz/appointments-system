<?php
/* Registration process, inserts user info into the database 
   and sends account confirmation email message
 */

// Set session variables to be used on profile.php page
$_SESSION['email'] = $_POST['email'];
$_SESSION['first_name'] = $_POST['firstname'];
$_SESSION['last_name'] = $_POST['lastname'];

// Escape all $_POST variables to protect against SQL injections
$first_name = $mysqli->escape_string($_POST['firstname']);
$last_name = $mysqli->escape_string($_POST['lastname']);
$email = $mysqli->escape_string($_POST['email']);
$password = $mysqli->escape_string(password_hash($_POST['password'], PASSWORD_BCRYPT));
$hash = $mysqli->escape_string( md5( rand(0,1000) ) );
$practice_id = $mysqli->escape_string($_POST['practice_select']);

// Check what category the user is registering for and save to DB table accordingly
//Login bariable will change according to category and will then be used to update the user login variable below
if(isset($_POST['register'])) {
    $selected_val = $_POST['category'];
    if ($selected_val == 'patient') {
        $db_table = 'users';
        $login_var = 'user_logged_in';
    } else {
        $db_table = 'staff';
        $login_var = 'staff_logged_in';
    }
}


// Check if user with that email already exists
$result = $mysqli->query("SELECT * FROM $db_table WHERE email='$email'") or die($mysqli->error());

// Email already exists if the rows returned are more than 0
if ( $result->num_rows > 0 ) {
    $_SESSION['message_header'] = 'Error';
    $_SESSION['message'] = 'User with this email already exists!';
    header("location: info.php");
}
else { // Email doesn't exist in DB, proceed...

    $sql = "INSERT INTO $db_table (first_name, last_name, email, password, hash, practice_id) " 
        . "VALUES ('$first_name','$last_name','$email','$password', '$hash', '$practice_id')";

    // Add user to the database
    if ( $mysqli->query($sql) ){

        $_SESSION['active'] = 0; //0 until user activates their account with verify.php
        $_SESSION[$login_var] = true; // So we know the user has logged in
        $_SESSION['message_header'] = 'Success!';
        $_SESSION['message'] =

            "Confirmation link has been sent to $email, please verify
                 your account by clicking on the link in the message!";

        // Send registration confirmation link (verify.php)
        $_SESSION['mailto'] = $email;
        $_SESSION['email_subject'] = 'Account Verification';
        $_SESSION['email_body'] = '
        Hello '.$first_name.',

        Thank you for signing up!

        Please open the following link to activate your account:

        http://localhost:8080/verify.php?email='.$email.'&hash='.$hash;  

        header("location: mail.php"); 
    }

    else { 
        $_SESSION['message_header'] = 'We\'re sorry!';
        $_SESSION['message'] = 'Registration failed! Please try again. If the problem persists contact your medical practice.';
        header("location: info.php");
    }
}