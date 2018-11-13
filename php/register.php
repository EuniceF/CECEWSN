<?PHP
	session_start();
	// Database
	include("inc/database.php");

	// Change the default timezone
	date_default_timezone_set('Australia/Brisbane');
	
	// Form handler
	function validateRegistrationForm($arr) {
		extract($arr);

		// If the variables aren't set exit
		if (!isset($name, $email)) return;

		// Grab the variables from the $_POST header and grab the current datetime
		$email = $_POST['email'];
		$name = $_POST['name'];
		$date = date("Y-m-d H:i:s");

		// Set the session variables needed for the other files
		$_SESSION['email']  = $email;
		$_SESSION['name'] = $name;
		$_SESSION['date'] = $date;

		if (!$name) {
			return "Please enter your Name";
		} elseif (!$email || !preg_match("/^\S+@\S+$/", $email)) {
			return "Please enter a valid Email address";
		} else {
			insert(); // Access the insert prepared statement
			header('Location: success.php'); // Redirect the page
			$_SESSION['db'] = NULL; // End the DB connection
			exit;
		}
	}

	// Execution
	if (isset($_POST['submit'])) {
		// Call form handler
		$errorMsg = validateRegistrationForm($_POST);
	}

	// Post error message
	if (isset($errorMsg) && $errorMsg) {
		echo "<p style=\"color: red;\">*",htmlspecialchars($errorMsg),"</p>\n\n";
	}
?>


