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
    $event_id = $_POST['event_id'];
}
//Convert from string to Datetime format in order to insert into DB
$date = strtotime($date_string);
$start = date('Y/m/d H:i:s', $date);
//Each appointment has a duration of 30 minutes therefore end date and time is start + 30 minutes
$end_string = new DateTime($start);
$end_string->modify('+29 minutes');
$end = $end_string->format('Y-m-d H:i:s');


//Check if user already has an appointment for the current date
//User is only allowed to have one appointment per staff per day
$start_of_day = date('Y/m/d 00:00:00', $date);
$end_of_day = date('Y/m/d 23:59:59', $date);
$query = "SELECT COUNT(*) as Count FROM calendar.appointments WHERE start BETWEEN '$start_of_day' AND '$end_of_day' AND doctor_id = $doctor_id AND patient_id = ". $_SESSION['id'];
$statement = $connect->prepare($query);
$result = $statement->execute();

foreach ($connect->query($query) as $row) {
    //if user already has an appointment on this date show message
    if($row['Count'] > 0) {
        $_SESSION['message_header'] = "Ups..";
        $_SESSION['message'] = "It seems like you already have an appointment booked for this date with <b>$doctor</b>. You will only be allowed to book a new appointent after you attend this one, or cancel.";
        header('location: ../info.php');
    }
    else {
        $query = "
                INSERT INTO calendar.appointments
                (start, end, patient, patient_id, doctor, doctor_id, event_id)
                VALUES
                (:start, :end, :patient, :patient_id, :doctor, :doctor_id, :event_id)";

        $statement = $connect->prepare($query);
        
        //if query does not execute show error on screen for debugging puposes
        if (!$result = $statement->execute(
            array(
                ':start' => $start,
                ':end' => $end,
                ':patient' => $_SESSION['first_name']." ".$_SESSION['last_name'],
                ':patient_id' => $_SESSION['id'],
                ':doctor' => $doctor,
                ':doctor_id' => $doctor_id,
                ':event_id' => $event_id
            )
        )) {
            echo  "\nPDO: errorInfo:\n";
            print_r($statement->errorInfo());
        }else {
            echo " query-success: ". json_encode($result);
        }


        //remove the slot from the available list
        $query = "
                UPDATE calendar.events
                SET available = false
                WHERE id = '$event_id'" ;

        $statement = $connect->prepare($query);

        if (!$result = $statement->execute()) {
            echo  "\nPDO: errorInfo:\n";
            print_r($statement->errorInfo());
        }else {
            echo " Event-deleted: ". json_encode($result);
        }

        //close PDO (database) connection
        $connect = null;

        //message for info page
        $_SESSION['message_header'] = "Success!";
        $_SESSION['message'] = "Your appointment has successfully been booked for <b>". $start . "</b>, with <b>". $doctor. "</b>. See you there.";
        
        // Send mail confirmation
        $_SESSION['mailto'] = $_SESSION['email'];
        $_SESSION['email_subject'] = 'Your appointment';
        $_SESSION['email_body'] = '
Hello '.$_SESSION['first_name'].',

This is an automated email to notify you that an appointment has been booked for you.
Details of the appointment are below.

Date and Time: '.$start.'
Doctor name: '.$doctor.'
Address: '.$_SESSION['practice_address'].'
Postcode: '.$_SESSION['practice_postcode'].'
Phone Number: '.$_SESSION['practice_phone'].'

We look forward to seeing you.
Kindest regards, 
        
The Patient Hub team on behalf of '.$_SESSION['practice_name'].'.';

        header("location: ../mail.php"); 

    }
}