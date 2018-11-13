<?php
// You need to creat your own config.php - can't be added to GIT as it has sensitive credentials.
include("config.php");

// Create a new connection // Turn on prepared statements // Allow to catch exceptions
try {
    $dbConnection = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4', DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (PDOException $e) {
    echo $e->getMessage();
}

function insert($dbConnection, $firstName, $lastName, $affiliation, $email, $password) {    
    // Prepared statement
    $statement = $dbConnection->prepare("INSERT INTO USER(first_name, last_name, organisation, email, password) VALUES(:first_name,:last_name,:organisation,:email,:password);");

    // Execute the query
    $statement->execute(array(':first_name' => $firstName, ':last_name' => $lastName, ':organisation' => $affiliation, ':email' => $email, ':password' => $password));

    // Get the last inserted ID
    $insertId = $dbConnection->lastInsertId(); // TODO: Does this let me get other inserts from other sessions?
   
    return $insertId;
}
?>
