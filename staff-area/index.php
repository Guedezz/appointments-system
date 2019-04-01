<?php 
session_start();

include 'profile-verification.php';
include '../db-calendar.php';
$sql = "SELECT * FROM calendar.appointments WHERE doctor_id = $id ORDER BY start";
$result = $mysqli->query($sql);
if ($result->num_rows > 0) {

    // output data of each row
    foreach($result as $row) {
        $appt_id = $row['id'];
        $start = $row['start'];
        $timestamp = strtotime($start);
        $date = date('M/j/y', $timestamp);
        $day = date("l", $timestamp);
        $time = date('H:i', $timestamp);
        $patient = $row['patient'];
        $patient_id = $row['patient_id'];
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>Dashboard</title>

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
            <div class="sidebar" data-background-color="white" data-active-color="danger">
                <div class="sidebar-wrapper">
                    <div class="logo">
                        <a href="index.php" class="simple-text">
                            <img src="../images/logo.png" style="width: 30%; heigth:30%; display: block; margin-left: auto; margin-right: auto;">
                            The Patient Hub
                        </a>
                    </div>

                    <ul class="nav">
                        <li class="active">
                            <a href="index.php">
                                <p>Home</p>
                            </a>
                        </li>
                        <li>
                            <a href="availability.php">
                                <p>Set My Availability</p>
                            </a>
                        </li>
                        <li>
                            <a href="messages.php">
                                <p>Messages</p>
                            </a>
                        </li>  
                        <li>
                            <a href="profile.php">
                                <p>Profile</p>
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>
            <div class="main-panel">
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="index.php">Welcome <?php echo $first_name, '&nbsp', $last_name ?></a>
                            <p class="category"><? echo $_SESSION['staff_position']?></p>
                            <p class="category"><? echo $_SESSION['practice_name']?></p>
                            <p class="category"><? echo '<h3>'.date("l dS Y").'<h3>'; ?></p>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a href="../logout.php">
                                        <button class="btn btn-danger">Logout</button>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="content col-md-offset-2">
                    <div class="container-fluid"> 
                        <? if ($result->num_rows > 0) {
    echo '
                                    <div class="row">
                                        <div class="col-lg-8 col-sm-6">
                                            <div class="card">
                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-xs-7">
                                                            <p>Next Appointment: <a href="patient_details.php?id=' .$patient_id.'">' .$patient. '(Patient ID: '.$patient_id.')</a></p>
                                                        </div>
                                                    </div>
                                                    <div class="footer">
                                                        <hr />
                                                        <i class="ti-calendar"></i> Date: '.$start. '
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
}
                        ?>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card">
                                    <div class="header">
                                        <h4 class="title">My Schedule</h4>
                                        <p class="category"><? echo $_SESSION['practice_name']?></p>
                                    </div>
                                    <div class="content table-responsive table-full-width">
                                        <table class="table table-striped">
                                            <thead>
                                                <th>Event</th>
                                                <th>Date</th>
                                                <th>From</th>
                                                <th>To</th>                                    	
                                            </thead>
                                            <tbody>
                                                <?
                                                foreach($result as $row) {
                                                    $end_string = new DateTime($start);
                                                    $end_string->modify('+25 minutes');
                                                    $end = $end_string->format('H:i'); 
                                                    
                                                    echo '<tr>
                                                    <td class="text-success"><a href="appt_details.php?id='.$appt_id.'">Appointment</a></td>
                                                    <td>'.$date.'</td>
                                                    <td>'.$time.'</td>
                                                    <td>'.$end.'</td>
                                                </tr>';
                                                }
                                            
                                            //query events table to display free slots on the screen
                                            $sql = "SELECT * FROM calendar.events WHERE uid = $id AND available = true AND start >= CURDATE() ORDER BY start";
                                            $result = $mysqli->query($sql);
                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                foreach($result as $row) {
                                                    $start = $row['start'];
                                                    $timestamp = strtotime($start);
                                                    $date = date('M/j/y', $timestamp);
                                                    $time = date('H:i', $timestamp);
                                                    
                                                    $end_string = new DateTime($start);
                                                    $end_string->modify('+25 minutes');
                                                    $end = $end_string->format('H:i'); 
                                                   
                                                    echo '
                                                    <tr>
                                                        <td class="text-danger">Not booked slot</td>
                                                        <td>'.$date.'</td>
                                                        <td>'.$time.'</td>
                                                        <td>'.$end.'</td>
                                                    </tr>';
                                                }
                                                $mysqli->close();
                                            } else{
                                                echo "<div class='col-md-10 col-md-offset-1'><h4>You don't have any event on your schedule. Please set your availability by clicking the link on the side panel</h4></div>";
                                            }
                                            ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
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

        <!-- NEW -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

    </body>
</html>