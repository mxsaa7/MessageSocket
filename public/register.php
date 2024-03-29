<?php 

require_once '../src/utils/include.php';
$user = new UserRegister();

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
            elseif(strpos($fullUrl, "error=alreadyexists") == true){
                $error = "A user with that username or email already exists";
                echo '<div class="alert alert-danger" style="text-align:center;">
                        '.$error.'
                    </div>';
            }
            elseif(strpos($fullUrl, "regsucv") == true){
                $user_email = $_GET['uem'];
                $message = "A verification email has been sent to " .$user_email. ", please verify before attempting to login";
                echo '<div class="alert alert-info" style="text-align:center;">
                        '.$message.'
                    </div>';
            }

        ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="text" name="email" placeholder="Email">
            <input type="text" name="password" placeholder="Password">
            <input type="submit" name="register" value="Register">
        </form>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>