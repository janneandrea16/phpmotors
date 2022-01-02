<?php
if(isset($_SESSION['reviewMessage'])){
   $reviewMessage = $_SESSION['reviewMessage'];
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($vehicleDetail['invMake']) && isset($vehicleDetail['invModel'])) {
                echo "Modify $vehicleDetail[invMake] $vehicleDetail[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";
            } ?>| PHP Motors, Inc.</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>

<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
    <nav><?php echo $navList ?></nav>
    <main class='vehicle-detailpage'>
        <?php if (isset($thumbnailInfo)) {
            echo $thumbnailInfo;
        } ?>
        <?php if (isset($vehicleInfo)) {
            echo $vehicleInfo;
        } ?>
         
    <div class="customer-review-form">
        <?php if (isset($_SESSION['loggedin'])){
            $clientInitial=substr($_SESSION['clientData']['clientFirstname'],0,1);
            $clientLastname=$_SESSION['clientData']['clientLastname'];
            //$reviewMessage = $_SESSION['reviewMessage'];
            echo '<section>';
            echo '<h2>Customer Reviews</h2>';
            if(isset($reviewMessage)){
                echo $reviewMessage;
            }
            echo "<p class='vehicle-review-messages'>Review the $vehicleDetail[invMake] $vehicleDetail[invModel]</p>"; 
            echo '<form method="post" action="/phpmotors/reviews/">';
            echo'<label for="clientFirstname">Screen Name:</label><br><br>';
            echo'<input type="text" name="clientFirstname" id="clientFirstname" readonly
            value="'.$clientInitial .$clientLastname.'"><br><br>';
            echo'<label for="reviewText">Review:</label><br><br><br><br><br>';
            echo'<textarea name="reviewText" id="reviewText" rows="8" cols="25" required></textarea><br><br>';
            //Submit button
            echo"<input type='submit' class='form-button' value='Submit Review'><br><br>";
            //Add the action name - value pair -->
            echo '<input type="hidden"  name="action" value="submitReview"><br><br>';
            //Client ID in a hidden field in the form
            echo'<input type="hidden" name="clientId" value="'.$_SESSION['clientData']['clientId'].'">';
            //Inventory ID Hidden field in the form
            //store the primary key value for the item being updated
            echo'<input type="hidden" name="invId" value="'.$vehicleDetail['invId'].'">';
            echo'</form>';
            echo '</section>';
                }?>

        <?php if (isset($reviewsInfo)){
            echo $reviewsInfo;
        }?>

        <?php if (isset($productReviews)){
                    echo $productReviews;
                }?>


        

        <!--If the visitor is NOT logged suggest them to do it.Invite him to leave a message-->
        <?php if(!isset($_SESSION['loggedin'])){
        echo "<p class='vehicle-review-messages'>You must <a href='/phpmotors/accounts/index.php?action=login'>login</a> to write a review</p>";
        }?>

        <?php
        if(!$reviewsData){
            echo "<p class='vehicle-review-messages'>Be the first to write a review.</p>";
        }?>

    </div>
    </main>
    <hr class="line">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>

</html>