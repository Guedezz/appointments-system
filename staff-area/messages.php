<?php 
session_start();
require 'profile-verification.php';
$connect = new PDO('mysql:host=localhost;dbname=accounts', 'root', '');

$messages = array();
$users = array();
$query = "SELECT * FROM staff_messages WHERE receiver_id = $id  ORDER BY date DESC";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();
?>


<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
        <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="refresh" content="2" >

        <title>Paper Dashboard by Creative Tim</title>

        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />


        <!-- Bootstrap core CSS     -->
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

        <!-- Animation library for notifications   -->
        <link href="assets/css/animate.min.css" rel="stylesheet"/>

        <!--  Paper Dashboard core CSS    -->
        <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>

        <!--  CSS for Demo Purpose, don't include it in your project     -->
        <link href="assets/css/demo.css" rel="stylesheet" />

        <!--     Fonts and icons     -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
        <link href="assets/css/themify-icons.css" rel="stylesheet">

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
                        <li>
                            <a href="index.php">
                                <p>Home</p>
                            </a>
                        </li>
                        <li>
                            <a href="availability.php">
                                <p>Set My Availability</p>
                            </a>
                        </li>
                        <li class="active">
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
                            <button type="button" class="navbar-toggle">
                                <span class="sr-only"></span>
                                <span class="icon-bar bar1"></span>
                                <span class="icon-bar bar2"></span>
                                <span class="icon-bar bar3"></span>
                            </button>
                            <a class="navbar-brand" href="#">Messages</a>
                        </div>
                        <div class="collapse navbar-collapse">
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <a class="btn btn-danger" href="../logout.php">
                                        Logout
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>
                </nav>
                <div class="content">
                    <div class="container-fluid">
                        <a class="btn btn-success" href="new-message.php">
                            New
                        </a>
                        <hr>
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Inbox</h4>
                            </div>
                            <div class="content">

                                <div class="row">
                                    <div class="col-sm-9 col-md-12">
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div class="tab-pane fade in active" id="home">

                                                <?
                                                if (count($result) > 0){
                                                    foreach($result as $row)
                                                    {
                                                        $id = $row["id"];
                                                        $message = $row["message"];
                                                        $receiver_id = $row["receiver_id"];
                                                        $sender_id = $row["sender_id"];
                                                        $date = $row["date"];
                                                        $opened = $row["opened"];

                                                        //for each message query the database and get the name of the sender
                                                        $query = "SELECT * FROM users WHERE id = $sender_id";
                                                        $statement = $connect->prepare($query);
                                                        $statement->execute();
                                                        $result = $statement->fetchAll();
                                                        foreach($result as $row)
                                                        {
                                                            $user_id = $row["id"];
                                                            $first_name = $row["first_name"];
                                                            $last_name = $row["last_name"];
                                                        }
                                                        //change border color depending on message being read or not-read
                                                        if($opened==false){
                                                            $border_color = 'solid red';
                                                        }else{
                                                            $border_color = ''; 
                                                        }

                                                        echo '
                                                            <div class="list-group" style="border-left: 6px '.$border_color.';">
                                                            <a href="message-open.php?id='.$id.'&name='.$first_name.'&surname='.$last_name.'&uid='.$user_id.'" class="list-group-item">
                                                            <span class="name" style="min-width: 120px; display: inline-block;">From: '. $row["first_name"].' '.$row["last_name"].'</span>
                                                            <span class=""></span>
                                                            <span class="text-muted" style="font-size: 11px;">'.$message.'</span> 
                                                            <span class="badge">' .$date.'</span> 

                                                        </a>
                                                        </div>';
                                                    }
                                                } else{
                                                    echo "<h2>Your inbox is empty</h2>";
                                                }
                                                $connect = null;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
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
    </body>
    <!--   Core JS Files   -->
    <script src="assets/js/jquery.min.js" type="text/javascript"></script>
    <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

    <!--  Checkbox, Radio & Switch Plugins -->
    <script src="assets/js/bootstrap-checkbox-radio.js"></script>

    <!--  Charts Plugin -->
    <script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
    <script src="assets/js/paper-dashboard.js"></script>

    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="assets/js/demo.js"></script>

</html>

