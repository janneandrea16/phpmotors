<?php
//A cleaner way to ensure that only a logged in user who is an adminstrator can access the inventory management area
if ($_SESSION['clientData']['clientLevel'] < 2) {
 header('location: /phpmotors/');
 exit;
}
?>
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
        <?php echo $nav ?>
    </nav>
    <main>
        <!--add-classification-->
        <h1 class="form-title">Add Car-classification</h1><br><br>
        <?php
        if (isset($message)) {
            echo $message;
        }
        ?>
        <br>
        <form method="post" action="/phpmotors/vehicles/index.php">
            <label for="claname">Classification Name</label><br>
            <span class="aclarations">Add no more than 30 characters</span><br>
            <input type="text" id="claname" name="classificationName" required><br><br>
            <!--Hidden-->
            <input type="hidden" name="action" value="create-classification">
            <!--Action name-->
            <input type="submit" name="submit" value="Add Classification" ><br><br>
        </form>
    </main>

    <hr class="line">
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>

</html>