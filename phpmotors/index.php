<?php

//Main controller

//Create or access a session
session_start();

// Get the database connection file
require_once 'library/connections.php';
// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';
// Get the functions library
require_once 'library/functions.php';


// Get the array of classifications
$classifications = getClassifications();

//shows navbar
$navList=navbar($classifications);

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if($action == NULL){
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}
//Check if the firstname cookie exists, get its value
if(isset($_COOKIE['firstname'])){
    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
}
switch($action){
    case 'template':
        include 'view/template.php';
        break;
    case 'login':
        include 'accounts/index.php';
        break;
    default:
        include 'view/home.php';
}




?>