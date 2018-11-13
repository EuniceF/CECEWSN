<?php
session_start();

// Include the database config
include("config.php");

// Connect to database CECEWSN
$db = new mysqli(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the json data from the form body
$obj = file_get_contents('php://input');

if (isset($obj)) {
    $error = validateLoginForm($obj,$db);
}

// TODO: Comments
function validateLoginForm($obj,$db) {

    // Convert the json form data to an array
    $data = json_decode($obj, true);

    // Check if all data fields are set.
    if (!isset($data['email'])) {
        return "Please enter your email address.";
    } else if (!isset($data['password'])) {
        return "Please enter a password.";
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        return "Please enter a valid email address.";
    } else if (strlen($data['password']) < 12) {
        return "Your password must have at least 12 characters.";
    } else {
        // No errors set all variables

        // Cleans validates and assign variables from the $data array
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password =$data['password']; // Not sure how to clean this input


        $sql = "SELECT * FROM USER WHERE email= '$email'";
        $result = mysqli_query($db,$sql);
        $row = $result->fetch_assoc();
        
        //Count the number of selected tuples
        $count = mysqli_num_rows($result);

        if($count == 1) {
            if(password_verify($password,$row['password'])) {
                // Set the session variables so other that variables can be accessed
                // outside of this function and in other files.
                $_SESSION["id"] = $row['user_id'];
                $_SESSION["firstName"] = $row['first_name'];
                $_SESSION["lastName"] = $row['last_name'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["affiliation"] = $row['organisation'];
            } else {
                return "Password is invalid";
                }
        } else {
            return "Email is invalid";
        }
    }
}

if (isset($error) && $error) {
    $response['response'] = 'failure';
    $response['message'] = $error;
} else {
    try{
        $response['response'] = 'success';
        $response['message'] = 'Registration successful.';
    } catch(Exception $e){
        $response['response'] = 'failure';
        $response['message'] = $e->getMessage();
    }
    
}
echo json_encode($response);
//Close connection with database
$db->close();

exit();
?>