<?php 
session_start();
// Check if user is logged in using the session variable
if ( $_SESSION['patient_logged_in'] != 1 ) {
    header("location: ../login.php");    
}
else {
    // Check if user is registered to a medical practice
    if ($_SESSION['practice_id'] == null){
        header("location: ../practice_reg.php");
    } else {
        // Create these variable for readability
        $first_name = $_SESSION['first_name'];
        $last_name = $_SESSION['last_name'];
        $email = $_SESSION['email'];
        $id = $_SESSION['id'];
        $practice = $_SESSION['practice_id'];
    }
}
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
    <head>

        <link href='css/bootstrap.css' rel='stylesheet' />
        <link href='css/rotating-card.css' rel='stylesheet' />

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

        <?php include 'navbar.html'; ?>
    </head>
    <body>         
        <div class="container" style="margin-top: 10%;">
            <div class="row col-md-6 col-md-offset-2">
                <table class="table table-striped custab">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <?php
                    include '../db-calendar.php';
                    $id = $_SESSION['id'];
                    $sql = "SELECT * FROM calendar.appointments WHERE patient_id = $id AND start >= CURDATE() ORDER BY start";
                    $result = $mysqli->query($sql);
                    if ($result->num_rows > 0) {

                        // output data of each row
                        foreach($result as $row) {
                            $start = $row['start'];
                            $timestamp = strtotime($start);
                            $date = date('j/M/Y', $timestamp);
                            $day = date("l", $timestamp);
                            $time = date('H:i', $timestamp);

                            $name = $row['doctor'];
                            $doctor_id = $row['doctor_id'];
                            $event_id = $row['event_id'];
                            $appointment_id = $row['id'];

                            //for eacch new value a new table row will be created
                            echo 
                                '<form id="cancel-form" action="cancel.php" method="post">
                                <tr>
                                    <td>'.$day." ".$date.'</td>
                                    <td>'.$time. '</td>
                                    <td>'.$name.'</td>

                                    <input type="hidden" name="dateTime" value="'.$date." ".$time.'" />
                                    <input type="hidden" name="doctor" value="'.$name.'" />
                                    <input type="hidden" name="doctor_id" value="'.$doctor_id.'" />
                                    <input type="hidden" name="appointment_id" value="'.$appointment_id.'" />
                                    <input type="hidden" name="event_id" value="'.$event_id.'" />

                                    <td class="text-center">
                                        <button type="submit" class="btn btn-danger btn-xs" href="#" onclick="document.getElementById("cancel-form").submit()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                                Cancel
                                        </button>
                                    </td>
                                </tr>
                                </form>';
                        }
                    }else {
                        $_SESSION['message_header'] = "Info";
                        $_SESSION['message'] = "You have no upcoming appointments. Click <a href='patient-area/book-appt.php'>here</a> if you wish to book an appointment.";                  
                        header('location: ../info.php');
                    }
                    $mysqli->close();
                    ?>
                </table>
            </div>
        </div>

    </body>
</html>