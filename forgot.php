<?php 
/* Reset your password form, sends reset.php password link */
require 'db.php';
session_start();

// Check if form submitted with method="post"
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) 
{   
    $email = $mysqli->escape_string($_POST['email']);
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email'");

    if ( $result->num_rows == 0 ) // User doesn't exist
    { 
        $_SESSION['message'] = "User with that email doesn't exist!";
        header("location: error.php");
    }
    else { // User exists (num_rows != 0)

        $user = $result->fetch_assoc(); // $user becomes array with user data

        $email = $user['email'];
        $hash = $user['hash'];
        $first_name = $user['first_name'];

        // Session message to display on info.php
        $_SESSION['message_header'] = "Almost done!";
        $_SESSION['message'] = "<p>Please check your email <span>$email</span>"
            . " for a confirmation link to complete your password reset!</p>";

        
        // Send registration confirmation link (verify.php)
        $_SESSION['mailto'] = $email;
        $_SESSION['email_subject'] = 'Password Reset Link';
        $_SESSION['email_body'] = '
        Hello '.$first_name.',

        You have requested password reset!

        Please click this link to reset your password:

        http://http://localhost:8080/reset.php?email='.$email.'&hash='.$hash;  
  
        header("location: mail.php"); 
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Bootstrap CSS and others -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" >
        <link href="css/loginAreaStyle.css" rel="stylesheet" id="bootstrap-css">

        <!--Button style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>Reset Your Password</title>
    </head>

    <body>
        <div class="row justify-content-center" style="margin-top:10%">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Reset Your Password
                </div>
                <div class="panel-body">
                    <div class="form">
                        <form action="forgot.php" method="post">
                            <div class="field-wrap">
                                <label>
                                    Email Address<span class="req">*</span>
                                </label>
                                <input type="email"required autocomplete="off" name="email"/>
                            </div>
                            <a href="login.php" class="btn btn-primary">Back</a>
                            <button class="btn btn-primary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </body>

</html>
