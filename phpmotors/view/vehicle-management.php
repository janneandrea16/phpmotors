<?php 
// No one except the admin (once logged in) can access the vehicle-management
//if (isset($_SESSION['clientData'])){
//    $clientLevel=$_SESSION['clientData']['clientLevel'];
//   if($clientLevel<3){
//    header('Location:/phpmotors/');
//    exit;
// }
//}

//if (!isset($_SESSION['clientData'])){
//    header('Location:/phpmotors/');
//    exit;
//}

//A cleaner way to ensure that only a logged in user who is an adminstrator can access the inventory management area
if ($_SESSION['clientData']['clientLevel'] < 2) {
    header('location: /phpmotors/');
    exit;
   }
   if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
   }
?> <!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Motors | Log in</title>
    <link href="/phpmotors/css/small.css" rel="stylesheet">
    <link href="/phpmotors/css/medium.css" rel="stylesheet">
    <link href="/phpmotors/css/large.css" rel="stylesheet">
</head>
<body>
    
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
    
<nav><?php echo $nav ?></nav>
    <main class="vehicle-management">
        <h1>Vehicle Management</h1><br>
        <ul>
           <li><a href="/phpmotors/vehicles/index.php?action=add-classification">Add Classification</a></li>
           <li><a href="/phpmotors/vehicles/index.php?action=add-vehicle">Add Vehicle</a></li>
        </ul>
    <?php
        if (isset($message)) { 
        echo $message; 
        } 
        if (isset($classificationList)) { 
        echo '<br><h2>Vehicles By Classification</h2><br>'; 
        echo '<br><p>Choose a classification to see those vehicles</p><br>'; 
        echo $classificationList; 
        }  
    ?>
    <!--this tells that JavaScript is required-->
        <noscript>
        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
        </noscript>
        <!--This is used as a JavaScript hook to know where to inject the inventory list-->
        <table id="inventoryDisplay"></table>
    </main>
<hr class="line">
<footer>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</footer>
<script src="/phpmotors/js/inventory.js"></script>
</body>
</html>
<?php unset($_SESSION['message']); ?>
