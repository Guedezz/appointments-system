<?php
//insert.php
session_start();
$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');
// Check connection
if(isset($_POST))
{
    //get values from form
    $date_string = $_POST['dateTime'];
    $doctor= $_POST['doctor'];
    $doctor_id = $_POST['doctor_id'];
    $appointment_id = $_POST['appointment_id'];
    $event_id = $_POST['event_id'];
}


//Delete from appointments table
$query = "DELETE FROM calendar.appointments WHERE id = $appointment_id;";
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
$_SESSION['message'] = "Your appointment with <b>". $doctor. "</b> has been cancelled.";
header('location: ../info.php');


// Send mail confirmation
$_SESSION['mailto'] = $_SESSION['email'];
$_SESSION['email_subject'] = 'Appointment cancelled';
$_SESSION['email_body'] = '
Dear '.$_SESSION['first_name'].',

Your appointment has been cancelled. For more information please contact your medical practice.
Details of the cancelled appointment are below.

Date and Time: '.$date_string.'
Doctor name: '.$doctor.'
Address: '.$_SESSION['practice_address'].'
Postcode: '.$_SESSION['practice_postcode'].'
Phone Number: '.$_SESSION['practice_phone'].'

Kindest regards, 

The Patient Hub team on behalf of '.$_SESSION['practice_name'].'.';

header("location: ../mail.php"); 
