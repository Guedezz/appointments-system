<?php 
session_start();
require 'profile-verification.php';
include '../db.php';

$practice_id = $_SESSION['practice_id'];
$query = $mysqli -> query("SELECT * FROM users WHERE practice_id = $practice_id");
//create an array to hold results
while ($array[] = $query -> fetch_object());
//remove blank from end of array
array_pop($array);

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $connect = new PDO('mysql:host=localhost;dbname=accounts', 'root', '');
    $id_select = $_POST['id_select'];

    if (isset($_POST['new_message'])) { //user sending message

        $message = $_POST['new_message'];
        $receiver_id = $id_select;
        $sender_id = $id;
        $date = date("Y-m-d H:i:s");
        $query = "
                INSERT INTO user_messages 
                (message, receiver_id, sender_id, date) 
                VALUES ('$message', $receiver_id, $sender_id, '$date')";
        echo $query;

        $statement = $connect->prepare($query);
        $result = $statement->execute(); 
        $_SESSION['message_header'] = "Message sent!";
        $_SESSION['message'] = "Your message has successfully reached your patient's inbox";
        header("location: ../info.php");
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Messages</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />


        <!-- Bootstrap core CSS     -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Animation library for notifications   -->
        <link href="assets/css/animate.min.css" rel="stylesheet"/>

        <!--  Paper Dashboard core CSS    -->
        <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="assets/css/demo.css" rel="stylesheet" />

        <!--  Fonts and icons     -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link href="assets/css/themify-icons.css" rel="stylesheet">

    </head>
    <body>

        <div class="wrapper">
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle">
                                <span class="sr-only"></span>
                                <span class="icon-bar bar1"></span>
                                <span class="icon-bar bar2"></span>
                                <span class="icon-bar bar3"></span>
                            </button>
                            <a class="navbar-brand" href="#">New Message</a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a class="btn btn-danger" href="../logout.php">
                                        Logout
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>


                <div class="content">
                    <div class="container-fluid">
                         
                        <div class="row">
                           
                            <div class="col-lg-8 col-md-7">
                                <form class="card" name="my-form" method="post">
                                    <div class="header">
                                        <h4 class="title">Send message</h4>
                                    </div>
                                    <hr>
                                    <div class="col-md-4">
                                         <label>To:</label>
                                <select class="form-control" name="id_select">
                                    <?php foreach ($array as $option) : ?>
                                    <option value="<?php echo $option->id; ?>">
                                        <?php echo $option->first_name.' '.$option->last_name.' (ID: '.$option->id.')'; ?>
                                    </option>
                                    <?php endforeach; $mysqli->close(); ?>
                                </select>
                            </div>
                                    <div class="content">
                                        <form accept-charset="UTF-8" action="" method="POST">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <textarea rows="5" class="form-control border-input" placeholder="Type in your message here" id="new_message" name="new_message" required></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="messages.php" class="btn btn-info btn-wd">Back</a>
                                            <button type="submit" class="btn btn-info btn-wd">Send message</button>
                                            <div class="clearfix"></div>
                                        </form>
                                    </div>
                                </form>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="assets/js/bootstrap-checkbox-radio.js"></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>

</html>






