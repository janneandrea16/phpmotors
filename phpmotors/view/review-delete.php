<?php 
// If the visitor is NOT logged in send him to the PHP Motors home view 
if(!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] == FALSE) {
  header('Location: /phpmotors/');
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>
<body>
        <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
            <nav><?php echo $navList ?></nav>
            <?php
            if (isset($message)) {
            echo $message;
            } 
        ?>
        <br><br>
        <section class='reviews-form-section'>
        <h1>
        <?php 
        if(isset($review['invMake'])&& isset(($review['invModel']))){echo "$review[invMake]   $review[invModel]";}
        ?> Delete</h1>
        <h2><?php 
        $reviewDate=date("j F, Y",strtotime($review['reviewDate']));
        echo "<p>Reviewed on $reviewDate</p>";
        ?></h2>
        <p class='del-question'>Are you sure you want to delete it? The delete is permanent.</p>
        <form class='review-form' method="post" action="/phpmotors/reviews/">  
            <label for="reviewText">Review text</label><br>
            <textarea name="reviewText" id="reviewText" required readonly><?php if(isset($reviewText)){ echo $reviewText; } elseif(isset($review['reviewText'])) {echo $review['reviewText'];}?></textarea><br><br>
            <input type="submit" class="form-button" value="Delete Review"><br><br>
            <!-- Add the action name - value pair -->
            <input type="hidden"  name="action" value="deleteReview"><br><br>
            <!--store the primary key value for the item being deleted-->
            <input type="hidden" name="reviewId" value="<?php if(isset($reviewInfo['reviewId'])){ echo $reviewInfo['reviewId'];} 
            elseif(isset($reviewId)){ echo $reviewId; } ?>">
        </form>   
        </section>
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>