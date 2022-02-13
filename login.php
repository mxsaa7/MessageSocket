<?php 

require_once 'Classes/include.php';
session_start();
require_once 'Classes/include.php';
if(isset($_SESSION['user_id'])){
    header('location: chats.php');
}
?>
<html>
    <body>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <?php 

            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(strpos($fullUrl, "error=empty") == true){
                $error = "Please fill out all the fields on the form";
                echo '<div class="alert alert-danger" style="text-align:center;">
                        '.$error.'
                    </div>';
            }
            elseif(strpos($fullUrl, "login=ntfnd") == true){
                $error = "We cannot find an account with that username or password";
                echo '<div class="alert alert-danger" style="text-align:center;">
                        '.$error.'
                    </div>';
            }
            elseif(strpos($fullUrl, "login=invalid") == true){
                
                $error = "Your credentials are incorrect";
                echo '<div class="alert alert-danger" style="text-align:center;">
                        '.$error.'
                    </div>';
            }
            elseif(strpos($fullUrl, "accnt=notenabled") == true){
                $error = "Your account email hasn't been verified, please click the link in the email we sent to you";
                echo '<div class="alert alert-danger" style="text-align:center;">
                        '.$error.'
                    </div>';
            }
            elseif(strpos($fullUrl, "logout=success") == true){
                $message = "You have successfully logged out!";
                echo '<div class="alert alert-info" style="text-align:center;">
                        '.$message.'
                    </div>';
            } 

        ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" name="login" value="Login">
        </form>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>