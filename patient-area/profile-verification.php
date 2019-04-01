<?php
/*This script will be included in all pages. The main purpose is to  check if the account is active*/
$email = $_SESSION['email'];
$hash = $_SESSION['hash'];

if ( $_SESSION['patient_logged_in'] != true ) {
    header("location: ../login.php");    
}
else {
    // Check if user has confirmed his email
    if ($_SESSION['active']==false){

        // Send account verification link (verify.php)
        $_SESSION['mailto'] = $_SESSION['email'];
        $_SESSION['email_subject'] = 'Account Verification';
        $_SESSION['email_body'] = '
        Hello '.$first_name.',
        Thank you for signing up!
        Please open the following link to activate your account:
        http://localhost:8080/verify.php?email='.$email.'&hash='.$hash;  

        $_SESSION['message_header'] = "Info!";
        $_SESSION['message'] = "Please activate your account by clicking on the link sent to your email. If you wish to resend the email click <a href='resend-confirm.php'>here</a>. Please note: if you don't find the email in your inbox, kindly check your spam mail box for the activation link.";
        //session_destroy();
        header("location: ../info.php");
    }

    else {
        // Create these variable for readability
        // This will be included in all pages therefore this information will always be available
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $id = $_SESSION['id'];
        $practice = $_SESSION['practice_name'];
        $address = $_SESSION['address'];
        $postcode = $_SESSION['postcode'];
        $dob = $_SESSION['dob'];
        $sex = $_SESSION['sex'];
        $phone = $_SESSION['phone'];
    }
}