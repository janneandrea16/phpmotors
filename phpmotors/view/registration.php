<!DOCTYPE html>
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
        
       <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
        ?>
        <form  method="post" action="/phpmotors/accounts/index.php">
        <h1 class="reg-title">Register</h1><br>
        <label for="clientFirstname">First Name</label><br>
            <input type="text" name="clientFirstname" id="clientFirstname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";} ?> required><br><br>
            
            <label for="clientLastname">Last name</label><br>
            <input type="text" name="clientLastname" id="clientLastname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";} ?> required><br><br>
            
            <label for="clientEmail">E-mail</label><br>
            <input type="text" name="clientEmail" id="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br><br>
         
         
            <label for="clientPassword">Password</label><br>
            <span class="aclarations">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span> <br>
            <input type="password" name="clientPassword" id="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br><br>
            <label>&nbsp;</label>

            <input type="submit"  name="submit" id="form-button" value="Register"  ><br><br>
            <!-- Add the action name - value pair -->
            <input type="hidden" name="action" value="register"><br><br>
        </form> 
    </main>
        
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>