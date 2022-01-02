<?php
//contain a function for inserting a new classification to the carclassifications table.
function regClassification($classificationName){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement prepared statements as they provide additional  built-in security to protect our
    //databse from sequal injections attacks.
    $sql = 'INSERT INTO carclassification (classificationName)VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    //We are using php pdo
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    //bind_value methods
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    //and capture that number
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    //which cousld be in accounts controller since we are using MVC approach
    return $rowsChanged;
   }

//Contain a function for inserting a new inventory to the inventory table.
function regInventory($cars, $invMake, $invModel, $invDescription, $invImage,$invThumbnail,$invPrice,$invStock,$invColor){
    // Create a connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The SQL statement prepared statements as they provide additional  built-in security to protect our
    //databse from sequal injections attacks.
    $sql = 'INSERT INTO inventory (invMake, invModel, invDescription, invImage,invThumbnail,invPrice,invStock,invColor,classificationId)
        VALUES (:invMake, :invModel, :invDescription, :invImage,:invThumbnail,:invPrice,:invStock,:invColor,:cars)';
    // Create the prepared statement using the phpmotors connection
    //We are using php pdo
    $stmt = $db->prepare($sql);
    // The next four lines replace the placeholders in the SQL
    // statement with the actual values in the variables
    // and tells the database the type of data it is
    //bind_value methods
    $stmt->bindValue(':cars', $cars, PDO::PARAM_STR);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_STR);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a result of our insert
    //and capture that number
    $rowsChanged = $stmt->rowCount();
    // Close the database interaction
    $stmt->closeCursor();
    // Return the indication of success (rows changed)
    //which cousl d be in accounts controller since we are using MVC approach
    return $rowsChanged;
   }

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    //Calls the database connection
    $db = phpmotorsConnect(); 
    //Sql statement to query all inventory from the inventory table with a classificationId 
    //that matches the value passed in through the parameter.
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    //Creates the PDO prepared statement
    $stmt = $db->prepare($sql); 
    //Replaces the named placeholder with the actual value as an integer.
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    //Runs the prepared statement with the actual value
    $stmt->execute(); 
    //Requests a multi-dimensional array of the vehicles as an associative array,
    //stores the array in a variable
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    //Closes the database connection
    $stmt->closeCursor(); 
    return $inventory; 
   }

// Get vehicle information by invId
function getInvItemInfo($invId){
    $db = phpmotorsConnect();
    //*means "everything" in SQL
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }

// Update a vehicle
function updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor,
$classificationId, $invId) {
$db = phpmotorsConnect();
$sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
$stmt = $db->prepare($sql);
$stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
$stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
$stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
$stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
$stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
$stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
$stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
$stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
$stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
$stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
$stmt->execute();
$rowsChanged = $stmt->rowCount();
$stmt->closeCursor();
return $rowsChanged;
}

//Delate a vehicle
function deleteVehicle($invId) {
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
   }

//get a list of vehicles based on the classification
function getVehiclesByClassification($classificationName){
    $db = phpmotorsConnect();
    //This is a sub query that allows us to query first the classificationId based on the classification name.
    $sql = "SELECT * FROM inventory Inner JOIN images ON inventory.invId=images.invId WHERE classificationId IN (SELECT classificationId FROM carclassification WHERE classificationName=:classificationName) AND images.imgPath LIKE '%-tn%' AND images.imgPrimary=1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicles;
   }

//Get a specific vehicle in inventory and return it to the controller.
function getVehiclebyinvId($invId){
    $db = phpmotorsConnect();
    $sql = "SELECT * FROM inventory INNER JOIN images ON inventory.invId=images.invId WHERE inventory.invId=:invId AND images.imgPath NOT LIKE '%-tn%' AND images.imgPrimary=1";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $vehicleDetail = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicleDetail;
   }

//Get information for all vehicles
function getVehicles(){
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
   }


?>