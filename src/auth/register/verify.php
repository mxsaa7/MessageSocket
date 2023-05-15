<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<?php 

if(isset($_GET['code'])){
    require_once 'Classes/include.php';
    $verification_code = $_GET['code'];
    $user = new UserRegister();
    $user->setVerificationCode($verification_code);
    if($user->verifyUser()){
        $user->setUserStatus('Enabled');
        if($user->enableUser()){
            header('location:verify.php?emailv=success');
        }
        else{

        }
    }
    else{
        
    }
}

            $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if(strpos($fullUrl, "emailv=success") == true){
                $success = "Your email has been verified!";
                echo '<div class="alert alert-success" style="text-align:center;">
                        '.$success.'
                    </div>';
            }



?>