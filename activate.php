<?php
    
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Activate Account</title>
    </head>
    <body>
        <?php
        
            $getuser = $_GET["user"];
            $getcode = $_GET["code"];
            
            
            if ($_POST["activate"]) {
                $getuser = $_POST["user"];    
                $getcode = $_POST["code"];
                
                if ($getuser) {
                    if ($getcode) {
                        require("connect.php");
                        $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                        $numrows = mysql_num_rows($query);
                        
                        if ($numrows == 1) {
                            $row = mysql_fetch_assoc($query);
                            $dbcode = $row["code"];
                            $dbactive = $row["active"];
                            
                            if ($dbactive == 0) {
                                if ($dbcode == $getcode) {
                                    mysql_query("UPDATE users SET active='1' WHERE username='$getuser'");
                                    $query = mysql_query("SELECT * FROM users WHERE username='$getuser' AND active='1'");
                                    $numows = mysql_num_rows($query);
                                    
                                    if ($numrows == 1) {
                                        echo "Success! <a href='login.php'>Back</a>";
                                        $getuser = "";
                                        $getcode = "";
                                    } else {
                                        $errormsg = "500 Internal Server Error | Please try again later.";
                                    }
                                } else {
                                    $errormsg = "Incorrect code.";
                                }
                            } else {
                                $errormsg = "Account is already active.";
                            }
                        } else {
                            $errormsg = "Invalid username.";
                        }
                        
                        mysql_close();
                    } else {
                        $errormsg = "Missing activation code.";
                    }
                } else {
                    $errormsg = "Missing username."; 
                }
            }
    
    
            echo "
                <form action='activate.php' method='POST'>
                    <table>
                        <tr>
                            <td>$errormsg</td>
                        </tr>
                        <tr>
                            <td><input type='text' placeholder='Username' name='user' value='$getuser'</td>
                        </tr>
                        <tr>
                            <td><input type='text' placeholder='Activation Code' name='code' value='$getcode'</td>
                        </tr>
                        <tr>
                            <td><input type='submit' name='activate' value='Activate'</td>
                        </tr>
                    </table>
                </form>";
        ?>
    </body>
</html>
