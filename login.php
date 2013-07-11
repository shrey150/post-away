<?php
    
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Login</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,700' rel='stylesheet' type='text/css'>
    </head>
    <body class="font">
        <?php
        
        if ($username) {
            header("Location: http://www.post-away.tk");
        } else {
            $form="
            <form action='login.php' method='POST'>
                <table align='center'>
                    <tr><td><h1>PostAway</h1></td></tr>
                    <tr>
                        <td><input type='text' name='user' placeholder='Username'></td>
                    </tr>
                    <tr>
                        <td><input type='password' name='password' placeholder='Password'></td>
                    </tr>
                    <tr>
                        <td><input type='submit' name='login' value='Login'></td>
                    </tr>
                    <tr>
                        <td><a href='register.php'>Register</a></td>
                    </tr>
                    <tr>
                        <td><a href='forgot.php'>Forgot Password?</a></td>
                    </tr>
                </table>
            </form>";
            
            
            if ($_POST["login"]) {
                $user = $_POST["user"];
                $password = $_POST["password"];
                
                
                if ($user) {
                    if ($password) {
                       require("connect.php");
                       $password = md5(md5("confidential".$password."confidental"));
                       $query = mysql_query("SELECT * FROM users WHERE username='$user'");
                       $numrows = mysql_num_rows($query);
                    
                        if ($numrows == 1) {
                            $row = mysql_fetch_assoc($query);
                            $dbid = $row["id"];
                            $dbuser = $row["username"];
                            $dbpass = $row["password"];
                            $dbactive = $row["active"];
                            
                            if ($password === $dbpass) {
                                if ($dbactive == 1) {
                                    $_SESSION["id"] = $dbid;
                                    $_SESSION["username"] = $dbuser;
                                    
                                    header("Location: http://www.post-away.tk");
                                } else {
                                    echo "Activate your account to login. $form";
                                }
                            } else {
                                echo "Incorrect password. $form";
                                echo $password;
                            }
                        } else {
                            echo "Incorrect username. $form";
                        }
                    
                       mysql_close();
                    } else {
                        echo "Your must enter your password. $form";
                    }
                } else {
                    echo "You must enter your username. $form";
                }
                
            } else {
                echo $form;
            }
        }
        
        ?>
    </body>
</html>
