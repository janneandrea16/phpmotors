<!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
    <link href="../css/small.css" rel="stylesheet">
    <link href="../css/medium.css" rel="stylesheet">
    <link href="../css/large.css" rel="stylesheet">
</head>
<body>
    <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
        <nav>
            <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
            echo $navList; 
            ?>
        </nav>
        <main>
        <h1 class="classification-h1"><?php echo $classificationName; ?> vehicles</h1><br>
        <?php if(isset($message)){
        echo $message; }
        ?>
        <?php if(isset($vehicleDisplay)){
        echo $vehicleDisplay;
        } 
        ?>
    </main>
<hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>