<?php
    
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];

?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Forgot Password?</title>
    </head>
    <body>
        <?php
        
            if (!$username) {
                echo "
                <form action='forgot.php' method='POST'>
                    <table>
                        <tr>
                            <td><input type='text' placeholder='Username' name='user'></td>
                        </tr>
                        <tr>
                            <td><input type='email' placeholder='Email' name='email'></td>
                        </tr>
                        <tr>
                            <td><input type='submit' name='getnewpass' value='Get password'></td>
                        </tr>
                        <tr>
                            <td><a href='login.php'>Back</a></td>
                        </tr>
                    </table>
                </form>
                ";
                
                
                    if ($_POST["getnewpass"]) {
                        $user = $_POST["user"];
                        $email = $_POST["email"];
                   
                        if ($user) {
                            if ($email) {
                                if ((strlen($email) >= 6) && (strstr($email, "@")) && (strstr($email, "."))) {
                                    require("connect.php");
                                
                                    $query = mysql_query("SELECT * FROM users WHERE username='$user'");
                                    $numrows = mysql_num_rows($query);
                                
                                    if ($numrows == 1) {
                                        $row = mysql_fetch_assoc($query);
                                        $dbemail = $row["email"];
                                    
                                        if ($email === $dbemail) {
                                            $pass = rand();
                                            $pass = md5($pass);
                                            $pass = substr($pass, 0, 15);
                                            $pass = md5(md5("w4lkrh5kgq".$pass."4p967iujhn"));
                                            
                                            mysql_query("UPDATE users SET password='$pass' WHERE username='$user'");
                                            $query = mysql_query("SELECT * FROM users WHERE username='$user' AND password='$pass'");
                                            $numrows = mysql_num_rows($query);
                                            
                                            if ($numrows == 1) {
                                                $webmaster = "shrey150@yahoo.com";
                                                $header = "From: Login System <$webmaster>";
                                                $subject = "Password Reset";
                                                $message = "You requested a password reset. Your password is now: $pass.";
                                                
                                                if (mail($email, $subject, $message, $header)) {
                                                    echo "Success!";
                                                } else {
                                                    echo "ABC - 500 Internal Server Error | Please Try Again Later"; 
                                                }
                                            } else {
                                                echo "XYZ - 500 Internal Server Error | Please Try Again Later";
                                            }
                                        } else {
                                            echo "Incorrect email. $form";
                                        }
                                
                                        mysql_close();
                                    } 
                                } else {
                                    echo "Invalid email. $form";
                                }
                            } else {
                                echo "Missing email.";    
                            }  
                        } else {
                            echo "Missing username.";
                        }
                    }
                    
            } else {
                echo "<a href='logout.php'>Logout</a> to access this page.";
            }
        ?>
    </body>
</html>
