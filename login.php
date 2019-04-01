<?php
require 'db.php';
session_start();

//if any user is logged in check if he's staff or patient and redirect to respective page
if (isset($_SESSION['patient_logged_in']) || isset( $_SESSION['staff_logged_in'])){

    if ($_SESSION['patient_logged_in']==true && $_SESSION['active']==true){
        header("location: patient-area/");
    }else if ($_SESSION['staff_logged_in']==true  && $_SESSION['active']==true){
        header("location: staff-area/");
    } else {
        //if not logged_in or not active destroy session and redirect to login page
        session_destroy();
        header("location: login.php");
    }
}
//if login button gets pressed
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['login'])) { //user logging in

        require 'login-script.php'; //run this script
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS and others -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.css" >
        <link href="css/loginAreaStyle.css" rel="stylesheet" id="bootstrap-css">

        <!--Button style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>Login</title>
    </head>

    <body>
        <main class="my-form">
            <div class="container" style="margin-top:5%; margin-bottom:5%;">
                <div class="row justify-content-center" >
                    <div class="col-md-4" >
                        <img src="images/logo.png" style="width: 30%; heigth:30%; display: block; margin-left: auto; margin-right: auto;">
                        <form method="post">
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="Email" value="" required autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" value="" required autocomplete="off"/>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary" name="login" style="width: 100%; padding: 10px; font-weight: bold">Log In</button>
                            </div>
                            <div class="form-group" style="text-align:center; vertical-align: middle;">
                                <a href="forgot.php" class="ForgetPwd" style="text-align:center; vertical-align: middle;">Can't remember your Password?</a>
                            </div>
                            <hr>
                            <div class="form-group">
                                <input type=button 
                                       style="width: 100%; padding: 10px; font-weight: bold"  
                                       onclick="window.location.href='register.php'" 
                                       class="btn btn-primary" 
                                       value="Register"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>