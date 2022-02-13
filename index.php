<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}
?>