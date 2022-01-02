<?php
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
<title><?php if(isset($invInfo['invMake'])){ 
	echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?> | PHP Motors</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
        <nav><?php echo $navList ?></nav>
    <main class="main-vehicle">
        <h1><?php if(isset($invInfo['invMake'])){ 
        echo "Delete $invInfo[invMake] $invInfo[invModel]";} ?></h1><br><br>
            <p>*Note all fields are required</p><br><br>
            <?php
            if (isset($message)) {
            echo $message;
            } 
            ?>
            <br><br>
        <p>Confirm Vehicle Deletion. The delete is permanent.</p>
        <form  method="post" action="/phpmotors/vehicles/">   
            <fieldset>
            <br><br>
                <label for="invMake">Vehicle Make</label> 
                <input type="text" readonly name="invMake" id="invMake" <?php
                if(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>>
                
                <label for="invModel">Vehicle Model</label>
                <input type="text" readonly name="invModel" id="invModel" <?php
                if(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>>
                
                <label for="invDescription">Vehicle Description</label>
                <textarea name="invDescription" readonly id="invDescription"><?php
                if(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }
                ?></textarea>
                <br><br>
                <input type="submit" value="Delete Vehicle"><br><br>
                <!-- Add the action name - value pair -->
                <input type="hidden"  name="action" value="deleteVehicle"><br><br>
                <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){
                echo $invInfo['invId'];} ?>">

            </fieldset>
        </form>
    </main>
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>