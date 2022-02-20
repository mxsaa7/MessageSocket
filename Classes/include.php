<?php 
include 'Classes/DB.php';
include ('phpmailer/src/PHPMailer.php');
include ('phpmailer/src/POP3.php');
include ('phpmailer/src/OAuth.php');
include ('phpmailer/src/SMTP.php');
include ('phpmailer/src/Exception.php');

include 'Classes/Login/UserLogin.php';
include 'Classes/Login/login.process.php';

include 'Classes/Chat/User.php';
include 'Classes/Chat/Crud.php';
include 'Classes/Chat/Message.php';
include 'Classes/Chat/user.process.php';


include 'Classes/Register/UserRegister.php';
include 'Classes/Register/register.process.php';

include 'layout.php';



?>