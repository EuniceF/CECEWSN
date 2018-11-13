<?PHP
/**
 * Registers a new user in the database.
 */
session_start();

// Database
include_once("inc/database.php");

// Get the json data from the form body
$json = file_get_contents('php://input');

// Call the form validator
if (isset($json)) {
    $error = validateRegistrationForm($json);
}

// TODO: Comments
function validateRegistrationForm($json) {

    // Convert the json form data to an array
    $data = json_decode($json, true);

    // Variables for JSON encoding
    $response = array('response' => 'failure',
              'message' => 'error',
    );

    // Check if all data fields are set.
    if (!isset($data['firstName'])) {
        $response['message'] = 'Please enter your first name.';
        return json_encode($response);
    } else if (!isset($data['lastName'])) {
        $response['message'] = 'Please enter your last name.';
        return json_encode($response);
    } else if (!isset($data['affiliation'])) {
        $response['message'] = 'Please enter your organisation name.';
        return json_encode($response);
    } else if (!isset($data['email'])) {
        $response['message'] = 'Please enter your email address.';
        return json_encode($response);
    } else if (!isset($data['password'])) {
        $response['message'] = 'Please enter a password.';
        return json_encode($response);
    } else if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
        return json_encode($response);
    } else if (strlen($data['password']) < 12) {
        $response['message'] = 'Your password must have at least 12 characters.';
        return json_encode($response);
    } else {
        // No errors set all variables
        // Cleans validates and assign variables from the $data array
        $firstName = filter_var($data['firstName'], FILTER_SANITIZE_STRING);
        $lastName = filter_var($data['lastName'], FILTER_SANITIZE_STRING);
        $affiliation = filter_var($data['affiliation'], FILTER_SANITIZE_STRING);
        $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // Hash the password

        // Set the session variables so other that variables can be accessed outside of this function
        // and in other files.
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['affiliation'] = $affiliation;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password; // TODO: encode password hash and salt?
    }
}

// Send the error message as a response
// JavaScript will have to parse this and display it as appropriate
if (isset($error) && $error) {
    echo $error;
} else {
    // No error time to send the db request
    try {
        $_SESSION['id'] = insert($dbConnection, $_SESSION['firstName'], $_SESSION['lastName'], $_SESSION['affiliation'], $_SESSION['email'], $_SESSION['password']);
    } catch (PDOException $e) {
        $response['response'] = 'failure';
        $response['message'] = $e->getMessage();
    }
    if (isset($_SESSION['id'])) {
        // Record the success message
        $response['response'] = 'success';
        $response['message'] = 'Registration successful.';
    } else {
        $response['response'] = 'failure';
        $response['message'] = 'Could not create account.';
    }

    echo json_encode($response);

    $dbConnection = null; // disconnect the database & exit
    exit();
}
?>