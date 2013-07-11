<?php
    
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    
?>
<html>
    <head>
        <title>Logout</title>
    </head>
    <body>
    <?php
    
        if ($username) {
            session_destroy();
            echo "You have been logged out. <a href='login.php'>Back to Login</a>";
        } else {
            echo "You must login to logout. <a href='login.php'>Back</a>";
        }
    
    ?>
    </body>
</html>
