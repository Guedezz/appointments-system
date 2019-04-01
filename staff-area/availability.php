<?php 
session_start();
// Check if user is logged in using the session variable
if ( $_SESSION['staff_logged_in'] != 1 ) {
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
        $practice_name = $_SESSION['practice_name'];
        $practice_id = $_SESSION['practice_id'];
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

        <title>Paper Dashboard by Creative Tim</title>

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


        <!--  Calendar     -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <link href="../fonts/css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/animate.min.css" rel="stylesheet">

        <!-- Custom styling plus plugins -->
        <link href="../css/custom.css" rel="stylesheet">
        <link href="../css/icheck/flat/green.css" rel="stylesheet">
        <link href="../css/calendar/fullcalendar.css" rel="stylesheet">
        <link href="../css/calendar/fullcalendar.print.css" rel="stylesheet" media="print">

        <script src="../js/jquery.min.js"></script>

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
                        <li class="active">
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
                <nav class="navbar ">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle">
                                <span class="sr-only"></span>
                                <span class="icon-bar bar1"></span>
                                <span class="icon-bar bar2"></span>
                                <span class="icon-bar bar3"></span>
                            </button>
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

                        <div class="row col-md-8">
                            <div class="card">
                                <div class="header">
                                    <h4 class="title">My Schedule</h4>
                                    <p class="category"> <?php echo "$practice_name" ?></p>
                                </div>
                                <div class="content ">
                                    <div id='calendar'></div>
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
        </div>




        <!--   Core JS Files   -->

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

        <script>
            $.notify({
                // options
                message: 'Click on date to add availability. Click on event to delete it. Drag to update' 
            },{
                // settings
                type: 'success',
            });
        </script>

        <script>
            $(document).ready(function() {
                var calendar = $('#calendar').fullCalendar({
                    defaultView: 'agendaWeek',
                    editable:true,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'agendaWeek,agendaDay'
                    },
                    events: '../calendar/load.php',
                    selectable:true,
                    selectHelper:true,
                    select: function(start, end, allDay)
                    {
                        if(start.isBefore(moment())) {
                            $('#calendar').fullCalendar('unselect');
                            alert("This date is not available for an appointment. Please select a date after today.");
                            return false;
                        }

                        var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                        var uid = <?php echo $id ?>;
                        var name = "<?php echo $first_name . " ". $last_name ?>";
                        var practice_id = <?php echo $practice_id ?>;
                        $.ajax({
                            url:"../calendar/insert.php",
                            type:"POST",
                            data:{start:start, end:end, uid:uid, name:name, practice_id:practice_id},
                            success:function()
                            {
                                calendar.fullCalendar('refetchEvents');
                                alert("Your availability to see patients has been set for this date.");
                            }
                        })

                    },
                    editable:true,
                    eventResize:function(event)
                    {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url:"../calendar/update.php",
                            type:"POST",
                            data:{title:title, start:start, end:end, id:id},
                            success:function(){
                                calendar.fullCalendar('refetchEvents');
                                alert('Event Update');
                            }
                        })
                    },

                    eventDrop:function(event)
                    {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url:"../calendar/update.php",
                            type:"POST",
                            data:{title:title, start:start, end:end, id:id},
                            success:function()
                            {
                                calendar.fullCalendar('refetchEvents');
                                alert("Event Updated");
                            }
                        });
                    },

                    eventClick:function(event)
                    {
                        if(confirm("Are you sure you want to remove it?"))
                        {
                            var id = event.id;
                            $.ajax({
                                url:"../calendar/delete.php",
                                type:"POST",
                                data:{id:id},
                                success:function()
                                {
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event Removed");
                                }
                            })
                        }
                    },
                });
            });
        </script>
    </body>
</html>
