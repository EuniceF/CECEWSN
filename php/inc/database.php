<?php

    // You need to creat your own config.php - can't be added to GIT as it has sensitive credentials.
    include("config.php");

    $dbConnection = new PDO('mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . '', DB_USERNAME, DB_PASSWORD); // Create a new connection
    $dbConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Turn on prepared statements
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Allow to catch exceptions

    // Set the db connection session variable.
    $_SESSION['db'] = $dbConnection;

    // Prepared statement
    function insert(){
        $preparedStatementInsert = $_SESSION['db']->prepare('INSERT INTO registration (email, name, date) VALUES (:email, :name, :date)');
        $preparedStatementInsert->execute(array(
            'email' => $_SESSION['email'] ,
            'name' => $_SESSION['name'],
            'date' => $_SESSION['date']
        ));
    }
?>
