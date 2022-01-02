<header>
    <picture>
        <img src="/phpmotors/images/site/logo.png" alt="logo-phpmtors">
    </picture>
    <?php 

        //once the user logs in, the user's name and 'logout' must appear in all views
        if (isset($_SESSION['loggedin'])){
            $firstName =  $_SESSION['clientData']['clientFirstname'];
            echo '<div class="one-two-words">';
            echo '<a href="/phpmotors/accounts/" class="name">Welcome, '.$firstName.'</a> | '; 
            echo '<a href="/phpmotors/accounts/index.php?action=logout" class="word">Logout</a>';
            echo '</div>';
        }
        
        //The not-logged in user is able to see "My account" in all views
        if (!isset($_SESSION['loggedin'])){ 
            echo '<a href="/phpmotors/accounts/index.php?action=login"  class="word" >My account</a>';
        }
    ?> 

</header>