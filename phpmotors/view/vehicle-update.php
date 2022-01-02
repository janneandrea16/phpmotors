<?php
// Build the classifications option list
$classifList = '<select name="classificationId" id="classificationId">';
$classifList .= "<option>Choose a Car Classification</option>";
foreach ($classifications as $classification) {
 $classifList .= "<option value='$classification[classificationId]'";
 if(isset($classificationId)){
  if($classification['classificationId'] === $classificationId){
   $classifList .= ' selected ';
  }
 } elseif(isset($invInfo['classificationId'])){
 if($classification['classificationId'] === $invInfo['classificationId']){
  $classifList .= ' selected ';
 }
}
$classifList .= ">$classification[classificationName]</option>";
}
$classifList .= '</select>';

//A cleaner way to ensure that only a logged in user who is an adminstrator can access the inventory management area
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
   }
?><!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	 echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
	elseif(isset($invMake) && isset($invModel)){ 
		echo "Modify $invMake $invModel"; }?> | PHP Motors</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
       
        <nav><?php echo $nav ?></nav>
    <main class="main-vehicle">
        <h1 class="form-title"><?php if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
	echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
    elseif(isset($invMake) && isset($invModel)) { 
	echo "Modify$invMake $invModel"; }?></h1><br><br>
        <p>*Note all fields are required</p><br><br>
        <?php
        if (isset($message)) {
        echo $message;
        }
        ?>
        <br><br>
   
        <form  method="post" action="/phpmotors/vehicles/">
        <br>
        <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
            echo $classifList; ?>
        <br><br>

            <label for="invMake">Make</label><br>
            <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>            
            
            <label for="invModel">Model</label><br>
            <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
            
            <label for="invDescription">Description</label><br>
            <textarea name="invDescription" id="invDescription" required>
            <?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea>
            <br><br>

            <!-- Passwords must be at least 8 characters and contain at least 1 number.<br>
            1 capital letter and 1 special character.<br> -->
            <label for="invImage">Image Path</label><br>
            <input type="text" name="invImage" id="invImage" required <?php if(isset($invImage)){ echo "value='$invImage'"; } elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?>>
            <br><br>
              
            <label for="invThumbnail"> Thumbnail Path</label><br>
            <input type="text" name="invThumbnail" id="invThumbnail" required <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'"; } elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?>>
            
            <label for="invPrice">Price</label><br>
            <input type="text" name="invPrice" id="invPrice" required <?php if(isset($invPrice)){ echo "value='$invPrice'"; } elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?>>
            <br><br>

            <label for="invStock"># In Stock</label><br>
            <input type="text" name="invStock" id="invStock" required <?php if(isset($invStock)){ echo "value='$invStock'"; } elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?>>
            <br><br>

            <label for="invColor">Color</label><br>
            <input type="text" name="invColor" id="invColor" required <?php if(isset($invColor)){ echo "value='$invColor'"; } elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?>>
            <br><br>

            <input type="submit" value="Update Vehicle"><br><br>
            <!-- Add the action name - value pair -->
            <input type="hidden"  name="action" value="updateVehicle"><br><br>
            <!--store the primary key value for the item being updated-->
            <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
            elseif(isset($invId)){ echo $invId; } ?>">
        </form> 
    </main>
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>