<?php
//This is the reviews controller
//Create or access a session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/vehicles-model.php';
// Get the accounts model
require_once '../model/reviews-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
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
    //Add a new review
    case 'submitReview';
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $clientId = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));
        $reviewDate = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));

        // Check for missing data add-vehicle
        if (empty($reviewText)){
            $message = '<p>Please provide information for the empty form field.</p>';
            include '../view/vehicle-detail.php';
            exit;
        }
        // Send the data to the model
        $regOutcome= regReview($reviewText,$invId,$clientId,$reviewDate);
        
        $ThumbnailbyId=getThumbnailbyId($invId);
        $vehicleDetail =getVehiclebyinvId($invId);
        $thumbnailInfo=thumbnailImagedisplay($ThumbnailbyId);
        $vehicleInfo = displayVehicleinfo($vehicleDetail);

        // Check and report the result
        if ($regOutcome === 1) {
            $_SESSION['reviewMessage'] = "<p class='review-messages'>Thanks for registering your review.It is displayed below.</p>";
            $reviewsData= getReviewsbyInvid($invId);
            $reviewsInfo= buildReviewsdisplay($reviewsData);    
            include '../view/vehicle-detail.php';
            //header('Location: /phpmotors/vehicles/?action=vehicle-detail&invId='.$invId);
            exit;      
        } else{
            $message = "<p class='review-messages'>Sorry but the review wasn't saved. Please try again.</p>";
            $_SESSION['message']=$message;
            include '../view/vehicle-detail.php';
            exit;
        }
        break;
    //Deliver a view to update/edit a review
    case 'update';
        $reviewId= trim(filter_input(INPUT_GET, 'reviewId', 
        FILTER_SANITIZE_NUMBER_INT));
        $review=getReview($reviewId);
        if (count($review)<1) {
           $message = "<p class='review-messages'>Sorry, the review was not found.</p>";
          }
          include '../view/review-update.php';
          exit;
        break;
    //Handler the review update
    case 'updateReview';
        $reviewId= trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
        $reviewText = trim(filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING));
        $invId  = trim(filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT));
        $clientId  = trim(filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT));

        if (empty($reviewText)){
        $message = '<p>Please provide information for the empty post.</p>';
        include '../view/review-update.php';
        exit;
        }
        //shows all the product reviews
        $clientId=$_SESSION['clientData']['clientId'];
        $reviewsData=getReviewsbyClientId($clientId);
        $productReviews=displayClientreviews($reviewsData);
        //gets all the reviews
        $review=  getReview($reviewId);
        $updateResult = updateReview($reviewText,$reviewId);
        if ($updateResult) {
        $message = "<br><p class='review-messages'>Congratulations, the review was successfully updated.</p>";
        $_SESSION['message'] = $message;
        //once updated the user will return to the admin view
        include '../view/admin.php';
        exit;
        } else {
        $message = "<p class='review-messages'>You haven't altered in any way your review.</p>";
        include '../view/review-update.php';
        exit;
        }
        break;
    //Deliver a view to confirm deletion of a review
    case 'delete';
        $reviewId= trim(filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
        $review=  getReview($reviewId);
        if (count($review) < 1) {
         $message = "<p class='review-messages'>Sorry, no review could be found.</p>";
         }
         include '../view/review-delete.php';
         exit;
         break;
    //Handle the review deletion
    case 'deleteReview';
        $reviewId= trim(filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT));
        $deleteResult = deleteVehiclereview($reviewId);
        if ($deleteResult) {
            $message = "<p class='review-messages'>Congratulations the review was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/reviews/');
            exit;
         } else {
            $message = "<p class='review-messages'>Error: The review was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/reviews/');
            exit;
         }
         break;
    //A default that will deliver the 'admin' view if the client is logged in 
    default:
        //shows all the product reviews
        $clientId=$_SESSION['clientData']['clientId'];
        $reviewsData=getReviewsbyClientId($clientId);
        $productReviews=displayClientreviews($reviewsData);
        include '../view/admin.php';
        exit;
        break;
}
?>