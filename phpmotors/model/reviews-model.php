<?php

//Reviews model

//Insert a review
function regReview($reviewText,$invId,$clientId){
    $db = phpmotorsConnect();
    $sql = 'INSERT INTO reviews(reviewText,invId,clientId)VALUES (:reviewText,:invId, :clientId)';
    $stmt = $db->prepare($sql);
    // The next 3 lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    //bind_value methods
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
     }

//Get reviews for a specific inventory item
function getReviewsbyInvid($invId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews INNER JOIN clients ON reviews.clientId=clients.clientId WHERE invId = :invId ORDER BY reviewDate DESC'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviewArray = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviewArray; 
   }

//Get a specific review
function getReview($reviewId){
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM reviews Inner JOIN inventory ON reviews.invId=inventory.invId WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $review = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $review;
   }

//Update a specific review
function updateReview($reviewText,$reviewId) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE reviews SET  reviewText = :reviewText WHERE reviewId= :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewText', $reviewText, PDO::PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
    }

//Delete a specific review
function deleteVehiclereview($reviewId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }
  
//Get reviews written by a specific client
function getReviewsbyClientId($clientId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM reviews  Inner JOIN inventory ON reviews.invId=inventory.invId WHERE reviews.clientId = :clientId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $reviewsByclientId = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $reviewsByclientId; 
   }

?>