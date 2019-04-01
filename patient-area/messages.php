<?php 
session_start();
require 'profile-verification.php';
$connect = new PDO('mysql:host=localhost;dbname=accounts', 'root', '');

$messages = array();
$users = array();
$query = "SELECT * FROM user_messages WHERE receiver_id = $id  ORDER BY date DESC";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>

<!doctype html>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html lang="en">
    <head>
        <? include 'navbar.html' ?>
        <meta http-equiv="refresh" content="2" >
    </head>
    <body>
        <div class="content">
            <div class="container-fluid">
                <hr>
                <div class="card col-md-6 col-md-offset-2">
                    <div class="header">
                        <h4 class="title">Inbox</h4>
                        <a class="btn btn-success" href="new-message.php">
                            Compose new message
                        </a>
                    </div>
                    <hr>

                    <div class="content">

                        <div class="row">
                            <div class="col-sm-9 col-md-12">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane fade in active" id="home">

                                        <?
                                        // if messages are more than 0
                                        if (count($result) > 0){
                                            foreach($result as $row) {
                                                $id = $row["id"];
                                                $message = $row["message"];
                                                $receiver_id = $row["receiver_id"];
                                                $sender_id = $row["sender_id"];
                                                $date = $row["date"];
                                                $opened = $row["opened"];
                                    
                                                //for each message query the database and get the name of the sender
                                                $query = "SELECT * FROM accounts.staff WHERE id = $sender_id";
                                                $statement = $connect->prepare($query);
                                                $statement->execute();
                                                $result = $statement->fetchAll();
                                                foreach($result as $row)
                                                {
                                                    $user_id = $row["id"];
                                                    $first_name = $row["first_name"];
                                                    $last_name = $row["last_name"];
                                                }
                                                //change border color depending on message being read or not-read
                                                if($opened==false){
                                                    $border_color = 'solid red';
                                                }else{
                                                    $border_color = ''; 
                                                }
                                                echo '
                                                    <div class="list-group" style="border-left: 6px '.$border_color.';">
                                                    <a href="message-open.php?id='.$id.'&name='.$first_name.'&surname='.$last_name.'&uid='.$user_id.'" class="list-group-item">
                                                        <span class="name" style="min-width: 120px; display: inline-block;">From: '. $row["first_name"].' '.$row["last_name"].'</span>
                                                        <span class=""></span>
                                                        <span class="text-muted" style="font-size: 11px;">'.$message.'</span> 
                                                        <span class="badge">' .$date.'</span> 
                                                    </a>
                                                    </div>';
                                                    }
                                                } else{
                                                    echo "<h2>Your inbox is empty</h2>";
                                                        }
                                                    $connect = null;
                                        ?>
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