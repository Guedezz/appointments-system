<?php 
session_start();

include 'profile-verification.php';
include '../db-calendar.php';
$sql = "SELECT * FROM calendar.appointments WHERE doctor_id = $id ORDER BY start LIMIT 1";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {

    // appointment from database
    foreach($result as $row) {
        $appt_id = $row['id'];
        $event_id = $row['event_id'];
        $start = $row['start'];
        $timestamp = strtotime($start);
        $date = date('M/j/y', $timestamp);
        $day = date("l", $timestamp);
        $time = date('H:i', $timestamp);
        $patient = $row['patient'];
        $patient_id = $row['patient_id'];
        $end_string = new DateTime($start);
        $end_string->modify('+25 minutes');
        $end = $end_string->format('H:i'); 
    }
    $mysqli->close();
}

//query users table to get info for 
include '../db.php';
$sql = "SELECT * FROM accounts.users WHERE id = $patient_id";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {

    // users data
    foreach($result as $row) {
        $patient_first_name = $row['first_name'];
        $patient_last_name = $row['last_name'];
        $patient_address = $row['address'];
        $patient_email = $row['email'];
        $patient_dob = $row['dob'];
        $patient_age = $patient_dob;
        $patient_sex = $row['sex'];
        $patient_phone = $row['phone_number'];
    }
    //close DB connection
    $mysqli->close();
}
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

    </head>
    <body>
        <div class="wrapper">
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Appointment Details</a>
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
                            <div class="col-md-6 col-md-offset-2">
                                <div class="col-md-8 panel-warning">
                                    <div class="panel-heading" >Details <i class="fa fa-link fa-1x"></i></div>     
                                    <ul class="list-group" >
                                        <li class="list-group-item text-right">
                                            <span class="pull-left">
                                                <strong class="">Patien name: </strong>
                                            </span> <?php echo '<a href="patient_details.php?id='.$patient_id.'">' .$patient_first_name.'&nbsp'.$patient_last_name.'</a>'?>
                                        </li>
                                        <li class="list-group-item text-right">
                                            <span class="pull-left">
                                                <strong class="">Date: </strong>
                                            </span> <?php echo $day. ' '. $date ?>
                                        </li>
                                        <li class="list-group-item text-right">
                                            <span class="pull-left">
                                                <strong class="">From: </strong>
                                            </span> <?php echo $time ?>
                                        </li>
                                        <li class="list-group-item text-right">
                                            <span class="pull-left">
                                                <strong class="">To: </strong>
                                            </span> <?php echo $end ?>
                                        </li>
                                    </ul>
                                    <a class="btn btn-warning" href="index.php">Back</a>
                                    <a class="btn btn-warning" href="cancel.php?appt_id=<? echo $appt_id.'&event_id='.$event_id.'&mailto='.$patient_email ?>">Cancel Appointment</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="copyright pull-right">
                            &copy; <script>document.write(new Date().getFullYear())</script> The Patient Hub - Staff Portal</div>
                    </div>
                </footer>
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
