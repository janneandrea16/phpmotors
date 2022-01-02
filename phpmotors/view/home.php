<!DOCTYPE html>
    <html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP Motors | Log in</title>
    <link href="css/small.css" rel="stylesheet">
    <link href="css/medium.css" rel="stylesheet">
    <link href="css/large.css" rel="stylesheet">
</head>
<body>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?> 
        <nav>
            <?php //require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; 
            echo $navList; ?>
        </nav>
        <div class="text-car">
            <h2>Welcome to PHP Motors!</h2> 
            <h3>DMC Delorean</h3>
            <p>3 Cup holders</p>
            <p>Superman doors</p>
            <p>Fuzzy dice!</p>
            <input class="button" type="submit" value="Own Today">
        </div>
        <img alt="car" class="car" src="images/delorean.jpg">

        <main class="main-home">  
            <div>
                <h2>Delorean Upgrades</h2>
                <div class="contain-upgrades">
                    <div class="content1">
                        <div>
                            <div class="upgrades">
                                <img alt="car" src="images/upgrades/flux-cap.png">
                            </div>
                        <p>Flux Capacitor</p>
                        </div>

                        <div>
                            <div class="upgrades">
                                <img alt="car" src="images/upgrades/flame.jpg">
                            </div>
                        <p>Flame Decals</p>
                        </div>

                        <div>
                            <div class="upgrades">
                                <img alt="car" src="images/upgrades/bumper_sticker.jpg">
                            </div>
                        <p>Bumper Stickers</p>
                        </div>

                        <div>
                            <div class="upgrades">
                                <img alt="car" src="images/upgrades/hub-cap.jpg">
                            </div>
                        <p>JHub Caps</p>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="content2">
                <h2>DMC Delorean Reviews</h2>
                <div>
                    <ul>
                        <li>"So fast its almost like traveling in time." (4/5)</li>
                        <li>"Coolest ride on the road." (4/5)</li>
                        <li>"I'm feeling Marty McFly!" (5/5)</li>
                        <li>"The most futuristics ride of our day"</li>
                        <li>"80's living and i love it!" (5/5)</li>
                    </ul>
                </div>
            </div>
        </main>

        <hr class="line">
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
</body>
</html>
