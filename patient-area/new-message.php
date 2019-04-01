<?php 
session_start();
require 'profile-verification.php';
include '../db.php';

$practice_id = $_SESSION['practice_id'];
$query = $mysqli -> query("SELECT * FROM accounts.staff WHERE practice_id = $practice_id");
//create an array to hold results
while ($array[] = $query -> fetch_object());
//remove blank from end of array
array_pop($array);

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $connect = new PDO('mysql:host=localhost;dbname=accounts', 'root', '');
    $id_select = $_POST['id_select'];
    $message = $_POST['new_message'];
    $receiver_id = $id_select;
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
?>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <? include 'navbar.html'?>
        <title>Messages</title>
    </head>

    <body>
        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4" style="margin-top:5%;">
                <form class="panel panel-default" name="my-form" method="post">
                    <div class="panel-heading">
                        <h4 class="title">Send message</h4>
                    </div>
                    <div class="panel-body">
                        <label>To:</label>
                        <select class="form-control" name="id_select">
                            <?php foreach ($array as $option) : ?>
                            <option value="<?php echo $option->id; ?>">
                                <?php echo $option->first_name.' '.$option->last_name.' (ID: '.$option->id.')'; ?>
                            </option>
                            <?php endforeach; $mysqli->close(); ?>
                        </select>

                        <div class="form-group">
                            <textarea rows="5" class="form-control border-input" placeholder="Type in your message here" id="new_message" name="new_message" required></textarea>
                        </div>
                        <a href="messages.php" class="btn btn-info btn-wd">Back</a>
                        <button type="submit" class="btn btn-info btn-wd">Send message</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4">
            </div>
        </div>
    </body>
</html>