<?php
/*This script will resend an email for a patient to verify account*/

session_start();
$email = $_SESSION['email'];

$_SESSION['message_header'] = 'Success!';
$_SESSION['message'] =
    "Confirmation link has been sent to $email, please verify 
    your account by clicking on the link in the message!";

header('location: mail.php');