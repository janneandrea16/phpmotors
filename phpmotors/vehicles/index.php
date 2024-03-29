<?php

//Accounts Controller
//Create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/vehicles-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the uploads model
require_once '../model/uploads-model.php';


// Get the array of classifications
$classifications =getClassificationsSelect();
$selectLists=getClassificationsSelect();

//shows navbar
$navList=navbar($classifications);


//Accounts Controller
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
   $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
   case 'create-inventory':
      //Inventory
      $cars=trim(filter_input(INPUT_POST, 'cars', FILTER_SANITIZE_STRING));
      $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING));
      $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING));
      $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING));
      $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING));
      $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING));
      $invPrice = trim(filter_input(INPUT_POST, 'invPrice',  FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION));
      $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_STRING));
      $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING));
      //calls the navbar function
      

      // Check for missing data add-vehicle
      if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage)|| empty($cars) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)
      ) {
         $message = '<p>Please provide information for all empty form fields.</p>';
         include '../view/add-vehicle.php';
         exit;
      }
      
      // Send the data to the model
      $regOutcome= regInventory($cars, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);
 
      // Check and report the result
      if ($regOutcome === 1) {
         $message = "<p>Thanks for registering $invMake.</p>";
         include '../view/add-vehicle.php';
         exit;
      } else {
         $message = "<p>Sorry $invMake, but the registration failed. Please try again.</p>";
         include '../view/add-vehicle.php';
         exit;
      }

      break;
   case 'create-classification':
      
      // Filter and store the data
      //Carclassification
      $classificationName = filter_input(INPUT_POST, 'classificationName');
      

      // Check for missing data add-classification
      if (empty($classificationName)) {
         $message = '<p>Please provide information for all empty form fields.</p><br><br>';
         include '../view/add-classification.php';
         exit;
      }

      // Send the data to the model
      $regOutcome = regClassification($classificationName);
    
      // Check and report the result
      if ($regOutcome === 1) {
         $message = "<p>Thanks for registering $classificationName.</p>";
         header("Refresh:0");
        
      } else {
         $message = "<p>Sorry $classificationName, but the registration failed. Please try again.</p>";
        
      }
      include '../view/add-classification.php';
      exit;
      break;
      
      
   case 'add-classification':
      include '../view/add-classification.php';
      break;

   case 'add-vehicle':
      include '../view/add-vehicle.php';
      break;
  
   // Get vehicles by classificationId 
   //Used for starting Update & Delete process 
   case 'getInventoryItems': 
      // Get the classificationId 
      //Collects and filters the input of classificationId from the view
      $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
      // Fetch the vehicles by classificationId from the DB 
      $inventoryArray = getInventoryByClassification($classificationId); 
      // Convert the array to a JSON object and send it back 
      echo json_encode($inventoryArray); 
      break;
   case 'mod':
      $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
      //get the information for a single vehicle
      $invInfo = getInvItemInfo($invId);
      if(count($invInfo)<1){
         $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
      break;
   case 'updateVehicle':
      $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
      $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
      $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
      $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
      $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
      $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
      $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
      $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
      $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
      
      if (empty($classificationId) || empty($invMake) || empty($invModel) 
      || empty($invDescription) || empty($invImage) || empty($invThumbnail)
      || empty($invPrice) || empty($invStock) || empty($invColor)) {
      $message = '<p>Please complete all information for the item! Double check the classification of the item.</p>';
         include '../view/vehicle-update.php';
      exit;
      }

      $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
      if ($updateResult) {
         $message = "<br><p>Congratulations, the $invMake $invModel was successfully updated.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      } else {
         $message = "<p>Error. the $invMake $invModel was not updated.</p>";
         include '../view/vehicle-update.php';
         exit;
         }
      break;
   case 'delete':
      $invId = filter_input(INPUT_GET, 'invId', FILTER_VALIDATE_INT);
      $invInfo = getInvItemInfo($invId);
      if (count($invInfo) < 1) {
         $message = 'Sorry, no vehicle information could be found.';
         }
         include '../view/vehicle-delete.php';
         exit;
         break;
   case 'deleteVehicle':  
      $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
      $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
      $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);

      $deleteResult = deleteVehicle($invId);
      if ($deleteResult) {
         $message = "<p>Congratulations the, $invMake $invModel was	successfully deleted.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      } else {
         $message = "<p>Error: $invMake $invModel was not deleted.</p>";
         $_SESSION['message'] = $message;
         header('location: /phpmotors/vehicles/');
         exit;
      }
      break;
   case 'classification':
      $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
      $vehicles = getVehiclesByClassification($classificationName);
      if(!count($vehicles)){
         $message = "<p>Sorry, no $classificationName vehicles could be found.</p>";
      }else{
         $vehicleDisplay = buildVehiclesDisplay($vehicles);
      }
      include '../view/classification.php';
      break;
   case 'vehicle-detail';
      $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
      //echo $invId;
      //exit;
      $ThumbnailbyId=getThumbnailbyId($invId);
      $vehicleDetail =getVehiclebyinvId($invId);
      $reviewsData= getReviewsbyInvid($invId);
      if(!$vehicleDetail){
         $message = "<p class='notice'>Sorry, no vehicle details could be found.</p>";
      }else{
         $thumbnailInfo=thumbnailImagedisplay($ThumbnailbyId);
         $vehicleInfo = displayVehicleinfo($vehicleDetail);
         $reviewsInfo=buildReviewsdisplay($reviewsData);
      }
      include '../view/vehicle-detail.php';
      break;
   default:
      $classificationList = buildClassificationList($classifications);
      include '../view/vehicle-management.php';
      exit;
      break;
}

?>