<?php

//load.php
session_start();
$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');

$data = array();
$uid = $_SESSION['id'];
//only load on calendar days after today
$query = "SELECT * FROM events WHERE uid = $uid and start >= CURDATE() ORDER BY id";

$statement = $connect->prepare($query);

$statement->execute();

$result = $statement->fetchAll();

foreach($result as $row)
{
 $data[] = array(
  'id'   => $row["id"],
  'available'   => $row["available"],
  'start'   => $row["start"],
  'end'   => $row["end"]
 );
}

echo json_encode($data);

?>