<?php

//insert.php

$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');

if(isset($_POST["start"]))
{
    $start = $_POST['start'];
    $end = $_POST['end'];
    $uid = $_POST['uid'];
    $name = $_POST['name'];
    $practice_id = $_POST['practice_id'];

    //get difference between end-start and divide the seconds into 30 minute slots
    //30 minutes = 1800 seconds
    $difference_in_seconds = strtotime($end) - strtotime($start);
    $slots = $difference_in_seconds/1800;

    $query = "
    INSERT INTO events 
    (start, end, uid, name, practice_id) 
    VALUES (:start, :end, :uid, :name, :practice_id)";

    //Each appoint will have a duration of 25 minutes and doctor will have a 5 minute break before next one tottaling 30 minutes.
    while ($slots > 0) {

        //convert to string and add 25 minutes to start date
        $end_string = new DateTime($start);
        $end_string->modify('+25 minutes');
        $end = $end_string->format('Y-m-d H:i:s');

        $statement = $connect->prepare($query);
        $result = $statement->execute(
            array(
                ':start' => $start,
                ':end' => $end,
                ':uid' => $uid,
                ':name' => $name,
                ':practice_id' => $practice_id
            )
        );
        
        //add 5 minutes to start time (end of previous slot and start of new) in order to create a new slot in the database
        $start_string = $end_string;
        $start_string->modify('+5 minutes');
        $start = $start_string->format('Y-m-d H:i:s');
        $slots--;
    }

    echo json_encode($result);
}


?>