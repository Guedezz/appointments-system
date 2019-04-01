<?php 
session_start();
require 'profile-verification.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $connect = new PDO('mysql:host=localhost;dbname=accounts', 'root', '');

    //if form is set insert message into databse
    if (isset($_POST['new_message'])) { //user sending message

        $message = $_POST['new_message'];
        $receiver_id = $_GET['patient_id'];
        $sender_id = $id;
        $date = date("Y-m-d H:i:s");
        $query = "
                INSERT INTO staff_messages 
                (message, receiver_id, sender_id, date) 
                VALUES ('$message', $receiver_id, $sender_id, '$date')";

        $statement = $connect->prepare($query);
        $result = $statement->execute(); 
        $_SESSION['message_header'] = "Message sent!";
        $_SESSION['message'] = "Your message has successfully reached your doctor's inbox";
        header("location: ../info.php");
    }
}
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Messages</title>
        <? include 'navbar.html'?>

    </head>
    <body>
        <div class="wrapper">
            <div class="main-panel">

                <div class="content">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-6 col-md-offset-2" style="margin-top:10%">
                                <div class="card"> 
                                    <div class="content">
                                        <form accept-charset="UTF-8" action="" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea rows="5" class="form-control border-input" placeholder="Type in your message here" id="new_message" name="new_message" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="messages.php" class="btn btn-secondary">Back</a>
                                            <button type="submit" class="btn btn-secondary">Send message</button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>






