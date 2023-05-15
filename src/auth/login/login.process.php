<?php 
require_once '..\src\utils\include.php';

if(isset($_POST['login'])){
    $user = new UserLogin();
    $user->setUsername($_POST['username']);
    $user->setPassword($_POST['password']);
    if($user->checkIfEmpty()){
        header('location: login.php?error=empty');
    }
    else{
       $user->validateUser(); 
    }
    

}









?>