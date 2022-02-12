<?php 
require_once 'Classes/include.php';
session_start();
$user = new User();
$user->setUserID($_SESSION['user_id']);
$user->logout();
session_unset();
session_destroy();
header('location: login.php?logout=success');


?>