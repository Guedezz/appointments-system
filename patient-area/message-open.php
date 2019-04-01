<?php 

session_start();
include 'profile-verification.php';
include '../db.php';

$message_id = $_GET['id'];
$sender = $_GET['name'].' '.$_GET['surname'];
$sender_id = $_GET['uid'];

//set message as read
$sql = "UPDATE accounts.user_messages SET opened = true WHERE id = $message_id";
$result = $mysqli->query($sql);

//get messages
$sql = "SELECT * FROM accounts.user_messages WHERE id = $message_id";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {
    
    // output data of each row
    foreach($result as $row) {
        $message = $row['message'];
    }
} else {
    header('location: index.php');
}

$mysqli->close();

?>
<!doctype html>
<html lang="en">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag ---------->
    <head>
        <? include 'navbar.html' ?>

        <title>Details</title>

    </head>
    <body>
            <div class="main-panel">
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4" style="margin-top:5%;">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Message from: <b><? echo $sender ?></b></div>
                                    <div class="panel-body">
                                        <div class="content">
                                            <p class="text-muted"> Message:</p>
                                            <h4> <? echo $message ?></h4>
                                        </div>
                                    </div>
                                </div>
                                <a href="messages.php" class="btn btn-secondary">Back</a>
                                <a href="messages-form.php?patient_id=<? echo $sender_id?>" class="btn btn-secondary">Reply</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </body>
        </html>

