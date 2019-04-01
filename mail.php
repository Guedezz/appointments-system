<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'phpmailer/vendor/autoload.php';

//get email address, subject and address from session variables
$email = $_SESSION['mailto'];
$subject = $_SESSION['email_subject'];
$body = $_SESSION['email_body'];


$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'thepatienthub@gmail.com';          // SMTP username
    $mail->Password = 'Ytrewq4321';                       // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Sender
    $mail->setFrom('thepatienthub@gmail.com', 'The Patient Hub');
    // Add a recipient
    $mail->addAddress($email);     

    //Content
    $mail->Subject = $subject;
    $mail->Body    = $body;

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    $_SESSION['message_header'] = "Error!";
    $_SESSION['message'] = "The email could not be sent due to following error: ".$mail->ErrorInfo;
}
//All good! redirect to login page
echo "<script>window.location.href='info.php'</script>";
