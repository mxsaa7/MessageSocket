<?php 
include 'DB.php';
include ('../phpmailer/src/PHPMailer.php');
include ('../phpmailer/src/POP3.php');
include ('../phpmailer/src/OAuth.php');
include ('../phpmailer/src/SMTP.php');
include ('../phpmailer/src/Exception.php');

include '../src/auth/login/Login.php';
include '../src/auth/login/login.process.php';

include '../src/user/User.php';
include '../src/user/user.process.php';

include '../src/message/Crud.php';
include '../src/message/Message.php';


include '../src/auth/register/Register.php';
include '../src/auth/register/register.process.php';

include 'layout.php';



?>