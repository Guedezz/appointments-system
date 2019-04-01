<?php
/* The password reset form, the link to this page is included
   from the forgot.php email message
*/
require 'db.php';
session_start();

// Make sure email and hash variables aren't empty
if( isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) )
{
    $email = $mysqli->escape_string($_GET['email']); 
    $hash = $mysqli->escape_string($_GET['hash']); 

    // Make sure user email with matching hash exist
    $result = $mysqli->query("SELECT * FROM users WHERE email='$email' AND hash='$hash'");

    if ( $result->num_rows == 0 )
    { 
        $_SESSION['message_header'] = "Error!";
        $_SESSION['message'] = "You have entered invalid URL for password reset!";
        header("location: info.php");
    }
}
else {
    $_SESSION['message_header'] = "Error!";
    $_SESSION['message'] = "Sorry, verification failed, try again!";
    header("location: info.php");  
}
?>
<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
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
                        <label>Choose Your New Password</label>

                        <form action="reset_password.php" method="post">

                            <div class="field-wrap">
                                <label>
                                    New Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="newpassword" autocomplete="off"/>
                            </div>

                            <div class="field-wrap">
                                <label>
                                    Confirm New Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="confirmpassword" autocomplete="off"/>
                            </div>

                            <!-- This input field is needed, to get the email of the user -->
                            <input type="hidden" name="email" value="<?= $email ?>">    
                            <input type="hidden" name="hash" value="<?= $hash ?>">    

                            <button class="btn btn-primary">Apply</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
        <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
        <script src="js/index.js"></script>

    </body>
</html>
