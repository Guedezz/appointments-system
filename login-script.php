<?php
// User login process, checks if user exists and password is correct

//if password is wrong send to info.php page - to be used below
function wrongpassword() {
    $_SESSION['message_header'] = "Error";
    $_SESSION['message'] = "You have entered a wrong password, please try again!";
    header("location: info.php");
}

// Escape email to protect against SQL injections (the escape_string would escape the dash - which represents a comment in case of SQL injection attack)
require 'db.php';
$email = $mysqli->escape_string($_POST['email']); //get email from form

//different queries for patient and staff
$patient_query = $mysqli->query("SELECT * FROM users WHERE email='$email'");
$staff_query = $mysqli->query("SELECT * FROM staff WHERE email='$email'");

if ( $patient_query->num_rows == 0 && $staff_query->num_rows == 0 ){ // User doesn't exist
    $_SESSION['message_header'] = "Error";
    $_SESSION['message'] = "User with that email doesn't exist!";
    header("location: info.php");
}
else { // User exists

    // if query on staff table returns 0 results this means that the email must be on the patient table
    if ( $staff_query->num_rows == 0 ){
        $user = $patient_query->fetch_assoc();

        if ( password_verify($_POST['password'], $user['password']) ) {

            //join query on Practice ID -i.e. match results from both tables where practice ID is the same for the User ID
            $join_query = $mysqli->query(
                "SELECT users.email as 'User Email', users.first_name AS 'First Name', 
                        users.last_name AS 'Last Name', users.id, users.active, users.hash, users.address, users.postcode, users.dob, users.sex, users.phone_number, 
                        practice.name AS 'Practice Name', practice.id AS 'Practice ID', 
                        practice.address as 'Practice Address', practice.post_code AS 'Practice Postcode', 
                        practice.phone_number AS 'Practice Phone'
                FROM users
                INNER JOIN practice ON users.practice_id = practice.id
                WHERE users.id = " . $user['id']);

            $join = $join_query->fetch_assoc();

            //set all session variables
            $_SESSION['email'] = $join['User Email'];
            $_SESSION['first_name'] = $join['First Name'];
            $_SESSION['last_name'] = $join['Last Name'];
            $_SESSION['id'] = $join['id'];
            $_SESSION['hash'] = $join['hash'];
            $_SESSION['address'] = $join['address'];
            $_SESSION['postcode'] = $join['postcode'];
            $_SESSION['dob'] = $join['dob'];
            $_SESSION['sex'] = $join['sex'];
            $_SESSION['phone'] = $join['phone_number'];
            $_SESSION['practice_id'] = $join['Practice ID'];
            $_SESSION['practice_name'] = $join['Practice Name'];
            $_SESSION['practice_address'] = $join['Practice Address'];
            $_SESSION['practice_postcode'] = $join['Practice Postcode'];
            $_SESSION['practice_phone'] = $join['Practice Phone'];
            $_SESSION['active'] = $join['active'];

            // This is how we'll know the user is logged in
            $_SESSION['patient_logged_in'] = true;

            //open patient page
            header("location: patient-area/");

        }
        else {
            wrongpassword();
        }
    } else { //else if not on patient table, email is from the staff table

        $user = $staff_query->fetch_assoc();

        if ( password_verify($_POST['password'], $user['password']) ) {

            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['id'] = $user['id'];
            $_SESSION['practice_id'] = $user['practice_id'];
            $_SESSION['active'] = $user['active'];
            $staff_position_id = $user['staff_position_id'];

            //get the staff position from a different table
            $staff_pos_query =$mysqli->query("SELECT position FROM accounts.staff_position WHERE id = ".$staff_position_id);
            $position = $staff_pos_query->fetch_assoc();
            $_SESSION['staff_position'] = $position['position'];

            // This is how we'll know the staff is logged in
            $_SESSION['staff_logged_in'] = true;

            //retrieve all info for practice where this user is registered to
            $practice_id = $_SESSION['practice_id'];
            $practice_query = $mysqli->query("SELECT * FROM practice WHERE id= $practice_id ");
            $practice = $practice_query->fetch_assoc();

            $_SESSION['practice_name'] = $practice['name'];
            $_SESSION['practice_address'] = $practice['address'];
            $_SESSION['practice_postcode'] = $practice['post_code'];
            $_SESSION['practice_phone'] = $practice['phone_number'];

            header("location: staff-area/");

        }
        else {
            wrongpassword();
        }

    }
}