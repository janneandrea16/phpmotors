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
    <h2 class="form-title">Sign in</h2>
    <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
        }
    ?>
    <form  class="forma" action="/phpmotors/accounts/" method="post">
            <label for="clientEmail">Email</label><br>
            <input type="text" name="clientEmail" id="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";} ?> required><br><br>
            <label for="clientPassword">Password</label><br>
            <span class="aclarations">Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
            <input type="text" name="clientPassword" id="clientPassword" required ><br><br>
      

            <input class="form-button" type="submit" name="action" value="login" ><br><br>
            <!--hidden" input passes a key - value pair to the controller-->
            <input class="form-button" type="hidden" name="action" value="login" ><br><br>
            <a href="/phpmotors/accounts/index.php?action=register-page">Don't have an account yet?</a><br>
        </form> 
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>