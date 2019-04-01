<?php 
/* Main page with two forms: sign up and log in */
require 'db.php';
session_start();
//Query database to get name of all medical practice in order to put in the select list
$query = $mysqli -> query("SELECT * FROM practice");
//create an array to hold results
while ($array[] = $query -> fetch_object());
//remove blank from end of array
array_pop($array);

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    if (isset($_POST['register'])) { //user registering
        require 'register-script.php';//run the script
    }
}
?>
<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!--Button style -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <title>Register</title>
    </head>
    <body>
        <main class="my-form">
            <div class="container" style="margin-top:10%;">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form name="my-form" method="post">
                            <div class="form-group row">
                                <label for="first_name" class="col-md-4 col-form-label text-md-right">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="first_name" class="form-control" name="firstname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="last_name" class="col-md-4 col-form-label text-md-right">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" id="last_name" class="form-control" name="lastname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Medical Practice" class="col-md-4 col-form-label text-md-right" required>Medical Practice</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="practice_select">
                                        <?php foreach ($array as $option) : ?>
                                        <option value="<?php echo $option->id; ?>">
                                            <?php echo $option->name; ?>
                                        </option>
                                        <?php endforeach; $mysqli->close(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="category" class="col-md-4 col-form-label text-md-right">Category</label>
                                <div class="col-md-6">
                                    <label id="category" required>
                                        <label class="radio-inline"><input type="radio" name="category" value="patient" required> Patient</label>
                                        <label class="radio-inline"><input type="radio" name="category" value="staff"> Medical Staff</label>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <a href="login.php" class="btn btn-primary">Back</a>
                                <button type="submit" class="btn btn-primary" name="register">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>