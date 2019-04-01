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
        $practice = $_SESSION['practice_name'];
    }
}
?>


<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<html>
    <head>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <?php include 'navbar.html'; ?>
    </head>
    <body>
        <div class="container target">


            <!--/col-3-->
            <form>
                <div class="col-sm-9" style="" contenteditable="false">
                    <div class="panel panel-default">
                        <div class="panel-heading"><b>Update your profile</b></div>
                        <div class="panel-body">
                            <i class="fa fa-envelope fa" aria-hidden="true"></i>
                            <div class="col-xs-3">
                                <input type="text"  class="form-control input-sm" name="givenName" id="givenName"  placeholder="Given Name"/>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" class="form-control input-sm" name="middleName" id="middleName"  placeholder="Middle Name"/>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" class="form-control input-sm" name="lastName" id="lastName"  placeholder="Last Name"/>                </div>
                            <div class="col-xs-9">
                                <input type="text" class="form-control input-sm" name="homeAddress" id="homeAddress"  placeholder="Home Address"/>
                            </div>
                            <div class="col-xs-3">
                                <input type="email" class="form-control input-sm" name="email" id="email"  placeholder="Email Address"/>
                            </div>
                            <div class="col-xs-3">
                                <input type="tel" class="form-control input-sm" name="telNumber" id="telNumber"  placeholder="Tel. No."/>
                            </div>
                            <div class="col-xs-3">
                                <input type="text" class="form-control input-sm" name="cellNumber" id="cellNumber"  placeholder="Cellphone Number"/>
                            </div>
                            <div class="col-xs-3">
                                <input type="number" class="form-control input-sm" name="age" id="age" min=24  placeholder="Age"/>
                            </div>
                            <div class="col-xs-3">
                                <b> Birthday:</b>
                                <input type="date" class="form-control input-sm" name="birthday" id="birthday"  placeholder="Birthday"/>
                            </div>
                            <p align="right"></p>
                            <b>    Gender:</b><br>
                            <div class="col-xs-1">
                                <input type="radio" class="form-control" name="sex" value="male" id="sex" checked/><center><i>Male</i></center>
                            </div>
                            <div class="col-xs-1">
                                <input type="radio" class="form-control" name="sex" value="female" id="sex"/><center><i>Female</i></center>
                            </div>
                        </div>
                        <center></center>
                            <button type="button" class="btn btn-primary">      Update</button>   <button type="button" class="btn btn-secondary">Clear</button>

                            </div>
                    </div>
                    </form>

                </div>
            </body>
        </html>