<?php
session_start();

$id = $_SESSION['id'];
$email = $_SESSION['email'];
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];
$affiliation = $_SESSION['affiliation'];

// TODO: check if they're null again

$user = array('id' => $id,
              'email' => $email,
              'firstName' => $firstName,
              'lastName' => $lastName,
              'affiliation' => $affiliation);

// Variables for JSON encoding
$response = array('response' => 'success',
            'message' => 'Registration verified.',
            'user' => $user
);

echo json_encode($response);
?>