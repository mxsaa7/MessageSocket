<?php 

require_once 'Classes/include.php';

if(isset($_POST['update'])){
    $user = new User();

    $email = $_POST['email'];

    $bio = $_POST['bio'];

    $user_profile = $_POST['hidden_user_profile'];

    if($_FILES['profile']['name'] != ''){
        $user_profile = $user->uploadImage($_FILES['profile']);
    }

    $user->setBio($bio);
    $user->setEmail($email);
    $user->setUserID($_SESSION['user_id']);
    $user->setUserProfile($user_profile);
    $user->updateUser();
    $_SESSION['profile_picture'] = $user->getUserProfile();
    $_SESSION['bio'] = $user->getBio();
    header('location: myprofile.php?update=success');
  
}



if(isset($_POST['search'])){
    $crud = new Crud();
    $name = $_POST['name'];
    $users = $crud->searchUser($name);
    $_SESSION['users'] = $users;

}

if(isset($_GET['uid'])){
    $crud = new Crud();
    $user_id = $_GET['uid'];
    $user_data = $crud->viewProfile($user_id);  
    $_SESSION['user_data'] = $user_data;
}