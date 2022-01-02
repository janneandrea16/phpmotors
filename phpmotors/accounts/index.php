<?php

//Accounts Controller

//Create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';



// Get the array of classifications
$classifications = getClassifications();      
//var_dump($classifications);
//exit;

//shows navbar
$navList=navbar($classifications);

// Build a navigation bar using the $classifications array
$navList = '<ul>';
$navList .= "<li><a href='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
foreach ($classifications as $classification) {
 $navList .= "<li><a href='/phpmotors/index.php?action=".urlencode($classification['classificationName'])."' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';
//echo $navList;
//exit;

//Accounts Controller
$action = filter_input(INPUT_GET, 'action');
 if ($action == NULL){
  $action = filter_input(INPUT_POST, 'action');
 }
//echo $action;
//exit;
switch ($action){
   case 'register':
      // Filter and store the data
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
      //Recreate the $clientEmail variable and assign to it what is returned from calling the checkEmail($clientEmail) function
      $clientEmail = checkEmail($clientEmail);
      //As previously explained, the code is executed from right to left. The original $clientPassword variable's value is passed
      // to the function and the returned value is sent back and stored in the $checkPassword variable on the left
      $checkPassword = checkPassword($clientPassword);

      //Return data to the client-update view for correction if errors are found.
      if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)){
         $_SESSION['message'] = "Please provide information for all empty form fields.";
         header('Location: /phpmotors/accounts/?action=login');
         exit; 
      }

      // Hash the checked password
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

      // Send the data to the model
      $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

      // Check and report the result
      if($regOutcome === 1){
         setcookie('clientFirstname', $clientFirstname, strtotime('+1 year'), '/');
         setcookie('clientLastname', $clientLastname, strtotime('+1 year'), '/');
         $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
         header('Location: /phpmotors/accounts/?action=login');
         exit;
      } else {
         $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
         include '../view/registration.php';
         exit;
      }
      break;
   case 'register-page':
      include '../view/registration.php';
      break;
   case 'login-page':
      include '../view/login.php';
      break;
   case 'login':
      //Filter and store data
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
      //Recreate the $clientEmail variable and assign to it what is returned from calling the checkEmail($clientEmail) function
      $clientEmail = checkEmail($clientEmail);
      //As previously explained, the code is executed from right to left. The original $clientPassword variable's value is passed
      // to the function and the returned value is sent back and stored in the $checkPassword variable on the left
      $checkPassword = checkPassword($clientPassword);

      
      // Run basic checks, return if errors
      if (empty($clientEmail) || empty($checkPassword)) {
         $message = '<p>Please provide a valid email address and password.</p>';
         include '../view/login.php';
         exit;
      }

      // A valid password exists, proceed with the login process
      // Query the client data based on the email address
      $clientData = getClient($clientEmail);
      // Compare the password just submitted against
      // the hashed password for the matching client
      $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
      // If the hashes don't match create an error
      // and return to the login view
      if(!$hashCheck) {
         $message = '<p>Please check your password and try again.</p>';
         include '../view/login.php';
         exit;
      }
      
      // A valid user exists, log them in
      $_SESSION['loggedin'] = TRUE;
      // Remove the password from the array
      // the array_pop function removes the last
      // element from an array
      array_pop($clientData);
      // Store the array into the session
      $_SESSION['clientData'] = $clientData;

      //get client Id
      $clientId=$_SESSION['clientData']['clientId'];
      //Query the review data array by clientId
      $reviewsData=getReviewsbyClientId($clientId);
      if(count($reviewsData)<1){
         $message = "<p>Sorry, no vehicle information could be found..</p>";
         $_SESSION['message'] = $message;
      }else{
         $productReviews=displayClientreviews($reviewsData);
         }
      // Send them to the admin view
      include '../view/admin.php';
      exit;
      break;

   case 'logout':
      if(session_destroy()){
      header('Location:/phpmotors');
      }
      break;
   case 'clientUpdate':
      // Filter and store the data
      $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING));
      $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING));
      $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
      $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
      //Recreate the $clientEmail variable and assign to it what is returned from calling the checkEmail($clientEmail) function
      $clientEmail = checkEmail($clientEmail);
       
      //Check if the email address is different than the one in the session. 
      $existingEmail=checkUpdatedEmail($clientEmail,$clientId);
      
      //check that the new email address does not already exist in the clients table (the same process as during registration).
      if($existingEmail){
         $message = "<p class='message'>That email address already exists.Please provide a different email address.</p>";
         include '../view/client-update.php';
         exit;
      }else{
         // Check for missing data
         if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)){
            $_SESSION['message'] = "<p>Please provide information for all empty form fields</p>";
            header('Location: /phpmotors/accounts/?action=update');
            exit; 
       }
 
      //Process the update using an appropriate function
      $updateClientinfo=clientUpdate($clientFirstname,$clientLastname,$clientEmail,$clientId);

      //Query the client data from the database, based on the clientId - this may require a new function in the model
      $clientData=getClientByid($clientId);

      //Store the new client data into the session (just as you did during the login).
      $_SESSION['clientData'] = $clientData;
 
      // Check and report the result
      if($updateClientinfo === 1){
         //setcookie('clientFirstname', $clientFirstname, strtotime('+1 year'), '/');
         //setcookie('clientLastname', $clientLastname, strtotime('+1 year'), '/');
         $_SESSION['message'] = "<p>$clientFirstname, your information has been updated.</p>";
         include '../view/admin.php';
         exit;
       } else {
         $_SESSION['message'] = "<p>Sorry $clientFirstname, but the update failed. Please try again.</p>";
         include '../view/client-update.php';
         exit;
       }
      }

      break; 
   case 'update':
      include '../view/client-update.php';
      break;
   case 'updatePassword':
      //Filter and collect the new password.
      $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING));
      $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
      if(empty($clientPassword)){
      $_SESSION['message2']='<p>Please provide information for all empty form fields</p>';
      include '../view/client-update.php';
      exit;
      }
      //Check that it meets the password requirements (the same as during registration).
      $checkPassword = checkPassword($clientPassword); 
      //If no error is found, the password must be hashed then sent to a function to be updated in the database.
      $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
      //if(empty($checkPassword)){ $_SESSION['message2'] = "<p>Please make sure your password matches the desired pattern.</p>";
      //include '../view/client-update.php';
      //exit; 
      //}
      
      //checks if the email mathches the requested format.
      if (!$checkPassword) {
         $_SESSION['message2']= "<p>Please follow the requested format.</p>";
         include '../view/client-update.php';
         exit;
      }else{
         //Determine the result of the update. 1 or 0.
         $passwordOutcome=updatePassword($hashedPassword,$clientId);
         //Set a success or failure message and store it in the session.
         //Deliver the "admin.php" view where the client information will be displayed along with the success or failure message.
         if($passwordOutcome === 1){
            $_SESSION['message'] = $_SESSION['clientData']['clientFirstname'].", your password has been updated.";
            $_SESSION['clientData']['clientPassword'] = $clientPassword;
            session_write_close();
            include '../view/admin.php';
            exit;
         } 
      }
      break;
   default:
   $clientId=$_SESSION['clientData']['clientId'];
   $reviewsData=getReviewsbyClientId($clientId);
   $productReviews=displayClientreviews($reviewsData);
   include '../view/admin.php';
   }
?>