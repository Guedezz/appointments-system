<?php 

session_start();
include 'profile-verification.php';
include '../db.php';

$message_id = $_GET['id'];
$sender = $_GET['name'].$_GET['surname'];
$sender_id = $_GET['uid'];

//set message as read
$sql = "UPDATE accounts.staff_messages SET opened = true WHERE id = $message_id";
$result = $mysqli->query($sql);

$sql = "SELECT * FROM accounts.staff_messages WHERE id = $message_id";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {

    //$message = $result['message'];
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
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Details</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />


        <!-- Bootstrap core CSS     -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Animation library for notifications   -->
        <link href="assets/css/animate.min.css" rel="stylesheet"/>

        <!--  Paper Dashboard core CSS    -->
        <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>


        <!--  Fonts and icons     -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link href="assets/css/themify-icons.css" rel="stylesheet">


        <!--  Calendar   -->
        <link rel='stylesheet' href='../css/calendar/fullcalendar.css' />
        <script src='../js/jquery.min.js'></script>
        <script src='../js/moment/moment.min.js'></script>
        <script src='../js/calendar/fullcalendar.min.js'></script>





    </head>
    <body>

        <div class="wrapper">


            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Message</a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a class="btn btn-danger" href="../logout.php">
                                        <p>Logout</p>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8" style="margin-top:5%;">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Message from: <a href="patient_details.php?id=<? echo $sender_id.'">'.$sender ?></a></div>
                                        <div class="panel-body">
                                        <div class="content">
                                            <h5> <? echo $message ?></h5>
                                        </div>
                                    </div>
                                </div>
                                <a href="messages.php" class="btn btn-primaary">Back</a>
                                <a href="messages-form.php?patient_id=<? echo $sender_id?>" class="btn btn-primaary">Reply</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--   Core JS Files   -->
            <script src="assets/js/jquery.min.js" type="text/javascript"></script>
            <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

            <!--  Checkbox, Radio & Switch Plugins -->
            <script src="assets/js/bootstrap-checkbox-radio.js"></script>

            <!--  Notifications Plugin    -->
            <script src="assets/js/bootstrap-notify.js"></script>


            <script src="../js/bootstrap.min.js"></script>
            <script src="../js/nprogress.js"></script>

            <!-- bootstrap progress js -->
            <script src="../js/progressbar/bootstrap-progressbar.min.js"></script>
            <script src="../js/nicescroll/jquery.nicescroll.min.js"></script>
            <!-- icheck -->
            <script src="../js/icheck/icheck.min.js"></script>

            <script src="../js/custom.js"></script>

            <script src="../js/moment/moment.min.js"></script>
            <script src="../js/calendar/fullcalendar.min.js"></script>
            <!-- pace -->
            <script src="../js/pace/pace.min.js"></script>

            </body>
        </html>

