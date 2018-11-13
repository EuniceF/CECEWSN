<?php
session_start();
try{
    session_destroy();
    $response['response'] = 'success';
    $response['message'] = 'Logout successful.';
} catch(Exception $e){
    $response['response'] = 'failure';
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>