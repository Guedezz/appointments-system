<?php
/* Displays all information messages on this page*/
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Info</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="css/info.css">
    </head>
    <body style="background-color:#fff249;">
        <main>
            <div class="content" style="margin-top: 15%;">
                <h1><?php echo $_SESSION['message_header'] ?></h1>

                <div class="col-md-6 offset-md-3 text align-self-center">
                    <?php
                    // Make sure message is not empty
                    if( isset($_SESSION['message']) AND !empty($_SESSION['message']) ): 
                    echo $_SESSION['message'];    
                    else:
                    header( "location: login.php" );
                    endif;
                    ?>
                    <div><br><a class="btn btn-danger" href="<?php unset($_SESSION['message']); unset($_SESSION['message_header']); echo'login.php';?>">Back</a></div>
                </div>    
            </div>
        </main>
    </body>
</html>