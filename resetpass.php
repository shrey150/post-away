<?php 
    error_reporting(E_ALL ^ E_NOTICE);
    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Reset Password</title>
    </head>
    <body>
    <?php
    
    if ($username) {
        if ($_POST["resetpass"]) {
            $oldpass = $_POST["oldpass"];
            $newpass = $_POST["newpass"];
            $confirmpass = $_POST["confirmpass"];
          
            if ($oldpass) {
                if ($newpass) {
                    if ($confirmpass) {
                        if ($newpass === $confirmpass) {
                            $password = md5(md5("w4lkrh5kgq".$oldpass."4p967iujhn"));
                            require("connect.php");
                            
                            $query = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$password'");
                            $numrows = mysql_num_rows($query);
                            
                            if ($numrows == 1) {
                                $newpassword = md5(md5("w4lkrh5kgq".$newpass."4p967iujhn"));
                                
                                mysql_query("UPDATE users SET password='$newpassword' WHERE username='$username'");
                                
                                $query = mysql_query("SELECT * FROM users WHERE username='$username' AND password='$newpassword'");
                                $numrows = mysql_num_rows($query);
                                
                                if ($numrows == 1) {
                                    echo "Password was reset.";
                                } else {
                                    echo "500 Internal Server Error | Please Try Again Later";
                                }
                            } else {
                                echo "Incorrect password.";
                            }
                            
                            mysql_close();
                        } else {
                            echo "The passwords do not match. $form";
                        }
                    } else {
                        echo "You must confirm your password. $form";
                    }
                } else {
                    echo "You must enter your new password. $form";
                } 
            } else {
                echo "You must enter your old password. $form";
            }
        }
        
        $form = "
        <form action='resetpass.php' method='POST'>
            <table>
                <tr>
                    <td><input type='password' placeholder='Old password' name='oldpass'></td>
                </tr>
                <tr>
                    <td><input type='password' placeholder='New password' name='newpass'></td>
                </tr>
                <tr>
                    <td><input type='password' placeholder='Confirm password' name='confirmpass'></td>
                </tr>
                <tr>
                    <td><input type='submit' name='resetpass' value='Reset'></td>
                </tr>
                <tr>
                    <td><a href='login.php'>Back</a></td>
                </tr>
            </table>
        </form>
        ";
        
         echo $form;
        
    } else {
        echo "<a href='login.php'>Login</a> to access this page.";
    }

    ?>
    </body>
</html>
