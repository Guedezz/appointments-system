<?php 
session_start();
// Check if user is logged in using the session variable
include 'profile-verification.php';
include '../db-calendar.php';

$sql = "SELECT * FROM calendar.appointments WHERE patient_id = $id AND start >= CURDATE() ORDER BY start";
$result = $mysqli->query($sql);
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
    <head>
       
        <?php include 'navbar.html'; ?>
    </head>
    <body>
        <div class="container target">

            <div class="panel" style="box-shadow: 0px 0px 18px grey; width: 100%; padding: 25px;">
                <div class="col-md-2">
                    <a href="settings.php">  <img src="images/profile.jpg" name="aboutme" width="130" height="130" class="img-circle"></a>
                </div>
                <h1 class="card-title"><?php echo $first_name. " " .$last_name ?></h1>
                <p class="card-text"><b>Your ID:</b> <?php echo $id ?></p>
                <p class="card-text"><b>Registered to:</b> <?php echo $practice ?></p>
            </div>
            <br>
            <div class="row">
                <div class="col-md-4 panel-primary">
                    <div class="panel-heading"  style="box-shadow: 3px 3px 18px #428bca;">Details <i class="fa fa-link fa-1x"></i></div>     
                    <ul class="list-group" style="box-shadow: 3px 3px 18px #428bca;">
                        <li class="list-group-item text-muted" contenteditable="false">Profile</li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Full Name: </strong>
                            </span> <?php echo $first_name, '&nbsp', $last_name ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Registration ID: </strong>
                            </span> <?php echo $id ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Address: </strong>
                            </span> <? echo $address ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Email: </strong>
                            </span> <?php echo $email ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Birthday: </strong>
                            </span> <? echo $dob ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Age: </strong>
                            </span> <? echo date_diff(date_create($dob), date_create('today'))->y; ?>
                        </li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Sex: </strong>
                            </span> <? echo $sex ?>
                        </li>
                        <li class="list-group-item text-muted" contenteditable="false">Contact Details</li>
                        <li class="list-group-item text-right">
                            <span class="pull-left">
                                <strong class="">Phone Number: </strong>
                            </span> <? echo $phone ?>
                        </li>
                    </ul>

                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="box-shadow: 3px 3px 18px #428bca;">Appointment Library</div>
                        <ul class="list-group">
                            <?php 
    if ($result->num_rows > 0) {
        // output data of each row
        foreach($result as $row) {
            $start = $row['start'];
            $timestamp = strtotime($start);
            $date = date('M/j/y', $timestamp);
            $day = date("l", $timestamp);
            $time = date('H:i', $timestamp);
            $doctor = $row['doctor'];
            echo '
                                <li class="list-group-item text-right">
                                <span class="pull-left">
                                <strong>' .$day." ".$date.'</strong>
                                </span>
                                </li>';
        }
        echo ' <li class="list-group-item text-right">
                                        <span class="pull-left">
                                            <a href="appointments.php" class="btn btn-primary" style="color:white">Manage appointment</a>
                                        </span>
                                    </li>';
    } else {
        echo '<div class="panel-body">You don\'t have any appointments</div>';
    }
                    $mysqli->close();
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading" style="box-shadow: 3px 3px 18px #428bca;">Reminders:</div>
                        <div class="panel-body">
                            <?php if ($result->num_rows > 0) {
    echo "You have ".$result->num_rows." upcoming appointments.
                                     Click <a style='text-decoration:none' href='appointments.php'>here</a> for details";
} else {
    echo "Nothing to remember at the moment";
}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>