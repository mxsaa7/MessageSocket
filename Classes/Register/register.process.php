<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'Classes/include.php';

$user = new UserRegister();

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];


    if(empty($username || $email || $password)){
        header('location: register.php?error=empty');
    }
    else{
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($password);
        if(!$user->checkIfExist($user->getUsername(), $user->getEmail())){
            $user->setUserProfile($user->make_profile(strtoupper($user->getUsername())));
        }
        $user->setVerificationCode(md5(uniqid()));
        $user->registerUser();

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPDebug = 1;
        $mail->SMTPAuth = true;
        $mail->SMTPKeepAlive = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = 'ethan.garr2000@gmail.com';
        $mail->Password = 'Shakopee1';
        $mail->setFrom('test.mailer.ad@gmail.com', 'SupporTech');
        $mail->addAddress($user->getEmail());
        $mail->isHTML(true);
        $mail->Subject = 'Registration Verification for SupporTech Messaging';
        $mail->Body = '<p>Thank you for registering for SupporTech Messaging!</p>
                        <p>Please click the verification link below to verify your email.</p>
                        <br>
                        <p><a href="http://localhost:8080/Messaging/verify.php?code='.$user->getVerificationCode() . '">Click to Verify Email</a></p>
                        <br>
                        <p>Thank you, </p>
                        <p>SupporTech LLC.</p> 
        ';

        $mail->send();
        $mail->smtpClose();

        header('location: register.php?regsucv&uem='.$user->getEmail(). '');
    }



}


?>