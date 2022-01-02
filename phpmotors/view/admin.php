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
    <title>PHP Motors</title>
        <link href="../css/small.css" rel="stylesheet">
        <link href="../css/medium.css" rel="stylesheet">
        <link href="../css/large.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
<nav>
    <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
        echo $navList; ?>
</nav>
<main class="admin-main">
<!--Display the user's full name-->

<div class="user-info">
<h1><?php 
if(isset($_SESSION['loggedin'])){
  $userName=$_SESSION['clientData']['clientFirstname'];
  $UserLast= $_SESSION['clientData']['clientLastname'];
  echo $userName, " ", $UserLast ;
}
?></h1>
  <h2>You are logged in</h2><?php
    if (isset($_SESSION['message'])){
    echo $_SESSION['message'];
    }
  ?><ul>
  <li>First name: 
      <?php
      if(isset($_SESSION['clientData'])){
        $firstName =  $_SESSION['clientData']['clientFirstname'];
        echo "<span>$firstName</span>";
      }
    ?>
  </li>

<li>Last name: 
    <?php
      if(isset($_SESSION['clientData'])){
        $clientLastname=  $_SESSION['clientData']['clientLastname'];
        echo "<span>$clientLastname</span>";
      }
    ?>
</li>

<li>Email: 
    <?php
    if(isset($_SESSION['clientData'])){
      $clientEmail =  $_SESSION['clientData']['clientEmail'];
      echo "<span>$clientEmail</span>";
    }?></li>

</ul>
</div>


<?php 
if (isset($_SESSION['loggedin'])){
    echo '<div class="extra-info">';
    echo '<h2>Account Management</h2>';
    echo '<p>Use this link to update account information.</p>';
    echo "<a class='update-account-link' href='/phpmotors/accounts/?action=update'>Update Account Information</a>";
    echo '</div>';
        }
?>
<?php 
$clientLevel=$_SESSION['clientData']['clientLevel'];
if ($clientLevel >1){
    echo '<div class="extra-info">';
    echo '<h2>Inventory Management</h2>';
    echo '<p>Use this link to manage the inventory.</p>';
    echo '<a href="/phpmotors/vehicles/">Vehicle Management</a>';
    echo '</div>';
    }
?>

<!--if (isset($_SESSION['loggedin'])-->
<?php if (isset($productReviews)) {
            echo $productReviews;
        } ?>

</main>
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>   
</body>
</html>