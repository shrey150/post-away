<?php


?>
<!DOCTYPE HTML>
<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <?php
            
            if ($_POST["register"]) {
                $getuser = $_POST["user"];
                $getemail = $_POST["email"];
                $getpass = $_POST["pass"];
                $getretypepass = $_POST["retypepass"];
                
                if ($getuser) {
                    if ($getemail) {
                        if ($getpass) {
                            if ($getretypepass) {
                                if ($getpass === $getretypepass) {
                                    if ((strlen($getemail) >= 6) && (strstr($getemail, "@")) && (strstr($getemail, "."))) {
                                        require("connect.php");
                                        
                                        $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                        $numrows = mysql_num_rows($query);
                                        
                                        if ($numrows == 0) {
                                            $query = mysql_query("SELECT * FROM users WHERE email='$getemail'");
                                            $numrows = mysql_num_rows($query);
                                            
                                            if ($numrows == 0) {
                                                $getpass = md5(md5("w4lkrh5kgq".$getpass."4p967iujhn"));
                                                $date = date("F d, Y");
                                                $code = md5(rand());
                                                
                                                mysql_query("INSERT INTO users VALUES (
                                                    '', '$getuser', '$getpass', '$getemail', '0', '$code', '$date'
                                                )");
                                                
                                                $query = mysql_query("SELECT * FROM users WHERE username='$getuser'");
                                                $numrows = mysql_num_rows($query);
                                                
                                                if ($numrows == 1) {
                                                    $site = "http://shrey150.koding.com/login-system";
                                                    $webmaster = "Login System <shrey150@yahoo.com>";
                                                    $header = "From: $webmaster";
                                                    $subject = "Activate your Account";
                                                    $message = "You registered for an account on Login System at $site/activate.php?user=$getuser&code=$code'. Click to activate your account.";
                                                    $message .= "Not you? Ignore this email.";
                                                    
                                                    if (mail($getemail, $subject, $message, $header)) {
                                                        echo "Success! Confirm the verification email to continue.";
                                                        $getuser = "";
                                                        $getemail = "";
                                                    } else {
                                                        $errormsg = "500 - Internal Server Error | Please try again later.";
                                                    }
                                                } else {
                                                    $errormsg = "500 - Internal Server Error | Please try again later.";
                                                }
                                            } else {
                                                $errormsg = "Email taken.";
                                            }
                                        } else {
                                            $errormsg = "Username taken.";
                                        }
                                        
                                        mysql_close();
                                    } else {
                                        $errormsg = "Invalid email.";
                                    } 
                                } else {
                                    $errormsg = "Passwords do not match.";
                                }
                            } else {
                                $errormsg = "Missing retyped password.";
                            }
                        } else {
                            $errormsg = "Missing password.";
                        }
                    } else {
                        $errormsg = "Missing email.";
                    }
                } else {
                    $errormsg = "Missing username.";
                }
            }
            
            $form = "
            <form action='register.php' method='POST'>
                <table>
                    <tr><td><h1>Register</h1></td></tr>
                    <tr>
                        <td><font color='red'>$errormsg</font></td>
                    </tr>
                    <tr>
                        <td><input type='text' name='user' placeholder='Desired username' value='$getuser'></td>
                    </tr>
                    <tr>
                        <td><input type='email' name='email' placeholder='Email' value='$getemail'></td>
                    </tr>
                    <tr>
                        <td><input type='password' name='pass' placeholder='Password'></td>
                    </tr>
                    <tr>
                        <td><input type='password' name='retypepass' placeholder='Retype password'></td>
                    </tr>
                    <tr>
                        <td><input type='submit' name='register' value='Register'></td>
                    </tr>
                    <tr>
                        <td><a href='login.php'>Back</a></td>
                    </tr>
                </table>
            </form>
            ";
        
            echo $form;
        ?>
    </body>
</html>
