<?php

//update.php

$connect = new PDO('mysql:host=localhost;dbname=calendar', 'root', '');

if(isset($_POST["id"]))
{
 $query = "
 UPDATE events 
 SET start=:start, end=:end 
 WHERE id=:id
 ";
 $statement = $connect->prepare($query);
 $statement->execute(
  array(
   ':start' => $_POST['start'],
   ':end' => $_POST['end'],
   ':id'   => $_POST['id']
  )
 );
}

?>