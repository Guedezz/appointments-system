<?php
//insert.php
session_start();
$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');
// Check connection
if(isset($_POST)) {
    $event_id = $_GET['event_id'];
    $appt_id = $_GET['appt_id'];
    $mailto = $_GET['mailto'];
}

//Delete from appointments table
$query = "DELETE FROM calendar.appointments WHERE id = $appt_id;";
$statement = $connect->prepare($query);

if (!$result = $statement->execute()) {
    echo  "\nPDO: errorInfo:\n";
    print_r($statement->errorInfo());
}else {
    echo " Appointment-deleted: ". json_encode($result);
}

//Make time slot available again
$query = "UPDATE calendar.events SET available = true WHERE id = '$event_id';";
$statement = $connect->prepare($query);

if (!$result = $statement->execute()) {
    echo  "\nPDO: errorInfo:\n";
    print_r($statement->errorInfo());
}else {
    echo " Event-updated: ". json_encode($result);
}

//close PDO (database) connection
$connect = null;

//message for info page
$_SESSION['message_header'] = "Cancelled!";
$_SESSION['message'] = "This appointment has been cancelled, and the slot has been made free on your calendar.";
header('location: ../info.php');


// Send mail confirmation
$_SESSION['mailto'] = $mailto;
$_SESSION['email_subject'] = 'Appointment cancelled';
$_SESSION['email_body'] = '
Dear patient,

Your Doctor has cancelled your appointment. For more information please contact your medical practice.
Kindest regards, 

The Patient Hub team on behalf of '.$_SESSION['practice_name'].'.';

header("location: ../mail.php"); 
