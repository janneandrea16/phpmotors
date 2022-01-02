<?php
// Build a select list using the $classifications array
   $listCla= '';
   foreach ($selectLists as $selectList) {
      $listCla .= "<option value='$selectList[classificationId]'";
      if(isset($classificationId)){
          if($classification['classificationId']===$classificationId){
              $listCla.=' selected ';
          }
      }
      $listCla .= " >$selectList[classificationName]</option>";
      }
   $listCla.= '';
?><!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Motors | Log in</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
       
        <nav><?php echo $nav ?></nav>
    <main class="main-vehicle">
        <h1 class="form-title">Add Vehicle</h1><br><br>
        <p>*Note all fields are required</p><br><br>
        <?php
        if (isset($message)) {
        echo $message;
        }
        ?>
        <br><br>
   
        <form  method="post" action="/phpmotors/vehicles/index.php">
            
        <label for="cars">Choose a car Classification:</label><br>
        <select id="cars" name="cars">
        <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
            echo $listCla; ?>
        </select>
        <br><br>

            <label for="invMake">Make</label><br>
            <input name="invMake" id="invMake" type="text" <?php if(isset($invMake)){echo "value='$invMake'";} ?>required><br><br>
            
            <label for="invModel">Model</label><br>
            <input type="text" id="invModel" name="invModel" <?php if(isset($invModel)){echo "value='$invModel'";} ?> required><br><br>
            
            <label for="invDescription">Description</label><br>
            <textarea name="invDescription" id="invDescription" rows="8" cols="25"  required><?php if(isset($invDescription)){echo "$invDescription";}?></textarea><br><br>
            <!-- Passwords must be at least 8 characters and contain at least 1 number.<br>
            1 capital letter and 1 special character.<br> -->
            <label for="imagepath">Image Path</label><br>
            <input type="text"  id="imagepath" value="/images/no-image.png" name="invImage" readonly  <?php if(isset($invImage)){echo "value='$invImage'";} ?> required><br><br>
              
            <label for="thumbnail"> Thumbnail Path</label><br>
            <input type="text"  id="thumbnail" value="/phpmotors/images/vehicles/no-image.png" name="invThumbnail" <?php if(isset($invThumbnail)){echo "value='$invThumbnail'";} ?> required><br><br>

            <label for="price">Price</label><br>
            <input type="text"  id="price" name="invPrice" <?php if(isset($invPrice)){echo "value='$invPrice'";} ?> required><br><br>

            <label for="stock"># In Stock</label><br>
            <input type="text"  id="stock" name="invStock" <?php if(isset($invStock)){echo "value='$invStock'";} ?> required><br><br>

            <label for="color">Color</label><br>
            <input type="text"  id="color" name="invColor" <?php if(isset($invColor)){echo "value='$invColor'";} ?> required><br><br>

            <input type="submit"  name="submit" id="form-button" value="Add Vehicle"  ><br><br>
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="create-inventory"><br><br>
        </form> 
    </main>
        
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>