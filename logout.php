<?php
/* Log out process, unsets and destroys session variables */
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="refresh" content="3;url=login.php">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <title>See you soon!</title>
    </head>

    <body>
        <div class=" col-md-6 offset-md-3" style=" position:absolute; top: 10%">
            <hr>
             <h2 class="text-center">Thank you for using </h2>
            <img src="images/logo.png" style="width: 20%; heigth:20%; display: block; margin-left: auto; margin-right: auto;">
            <div class="col-md-12" >
                <h1 class="text-center">See you soon <?php echo $_SESSION['first_name']; ?> </h1>
                <p class="text-center">You are now logged out</p>
            </div>
        </div>
    </body>
</html>
<?
session_unset();
session_destroy();
?>
