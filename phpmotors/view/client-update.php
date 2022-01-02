<?php 
// If the visitor is NOT logged in send him to the PHP Motors home view 
if(!isset($_SESSION['loggedin']) or $_SESSION['loggedin'] == FALSE) {
  header('Location: /phpmotors/');
}
$clientData = $_SESSION['clientData'];
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
<nav>
        <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
            echo $navList; ?>
        </nav>
    <main>
        <form  method="post" action="/phpmotors/accounts/index.php">
            <h1 class="reg-title">Manage Account</h1><br>
            <?php
            if (isset($_SESSION['message'])) {
                echo $_SESSION['message'];
            }
            ?>
            <label for="clientFirstname">First Name</label><br>
                <input type="text" name="clientFirstname" id="clientFirstname"  required <?php if(isset($clientFirstname)){ echo "value='$clientFirstname'"; } elseif(isset($clientData['clientFirstname'])) {echo "value='$clientData[clientFirstname]'"; }?>><br><br>
                
                <label for="clientLastname">Last name</label><br>
                <input type="text" name="clientLastname" id="clientLastname" required <?php if(isset($clientLastname)){ echo "value='$clientLastname'"; } elseif(isset($clientData['clientLastname'])) {echo "value='$clientData[clientLastname]'"; }?>><br><br>
                
                <label for="clientEmail">E-mail</label><br>
                <input type="text" name="clientEmail" id="clientEmail" required <?php if(isset($clientEmail)){ echo "value='$clientEmail'"; } elseif(isset($clientData['clientEmail'])) {echo "value='$clientData[clientEmail]'"; }?>><br><br>
            
                <input type="submit"  name="submit" class="form-button" value="Client update"  ><br><br>
                <!-- Add the action name - value pair -->
                <input type="hidden" name="action" value="clientUpdate"><br><br>
                <!--store the primary key value for the item being updated-->
                <input type="hidden" name="clientId" value="<?php if(isset($clientData['clientId'])){ echo $clientData['clientId'];} 
                elseif(isset($clientId)){ echo $clientId; } ?>">
        </form> 
        <br>
        <form  method="post" action="/phpmotors/accounts/index.php">
            <h1 class="reg-title">Update Password</h1><br>
            <?php
            if (isset($_SESSION['message2'])) {
                echo $_SESSION['message2'];
            }
            ?>
            <label for="clientPassword">Password</label><br>
            <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> <br>
            <br><p>*Note your original password will be changed.</p>
            <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>

            <input type="submit"  name="submit" class="form-button" value="Update Password"><br><br>
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="updatePassword"><br><br>
            <!--store the primary key value for the item being updated-->
            <input type="hidden" name="clientId" value="<?php if(isset($clientData['clientId'])){ echo $clientData['clientId'];} 
            elseif(isset($clientId)){ echo $clientId; } ?>">
        </form>
    </main>

<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>