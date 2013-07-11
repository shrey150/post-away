<?php
    
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    
?>
<html>
    <head>
        <title>PostAway</title>
        <link rel="stylesheet" href="style.css">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
    </head>
    <body align="center" class="font">
        Welcome to:<br><img src="https://photos-2.dropbox.com/t/0/AAD-ZjTibfsuYLuPiS_8819giG4PlJORgxx5cLABK5oghg/12/81996402/jpeg/32x32/3/_/1/2/PostAway.jpg/KCyF-pmJ2M_eOXXM9ZKJccTa1xfTVaIKmIhe-b5zVNs?size=200x200" alt="PostAway">
        <hr>
        <h2>Messages:</h2>
        <div class="border"><br>
        <?php
        
            require("connect.php");
            
            $query = mysql_query("SELECT message, username FROM messages");
            $numrows = mysql_num_rows($query);
            
            if ($numrows > 0) {
                
                while ($row = mysql_fetch_assoc($query)) {
                    echo $row["username"] . " " . "posted: \"";
                    echo $row["message"] . "\"<br>";
                }
                
            } else {
                echo "No messages right now :(";
            }
            
            mysql_close();
        
        
        ?>
        
        <br></div><br><br>
        
        <?php
        
            if ($username) {
                
                if ($_POST["post"]) {
                    $message = $_POST["new_message"];
                    
                    if ($message) {
                        require("connect.php");
                        
                        mysql_query("INSERT INTO messages VALUES (
                            '', '$message', '$username'
                        )");
                        
                        header("Location: http://www.post-away.tk");

                        mysql_close();
                    } else {
                        echo "Empty message.";
                    }
                }
                
                $form = "
                
                <form action='index.php' method='POST'>
                    <h2>Post:</h2>
                    <input type='text' name='new_message' placeholder='Message' size='50'>
                    <input type='submit' name='post'>
                </form>
                ";
                
                echo $form;
                
            } else {
                echo "<a href='login.php'>Login</a> to post.";
            }
        
        ?>
    </body>
</html>
