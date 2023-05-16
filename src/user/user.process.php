<?php 

require_once '..\src\utils\include.php';

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

if(isset($_POST['view_profile'])){
    $crud = new Crud();
    $user_id = json_decode($_POST['data']);
    echo $user_id;
}

if(isset($_POST['action']) && $_POST['action'] == 'fetch_chat'){
    header('Content-type: application/json charset=utf-8', true); 
    $all_messages = new Message();
    $all_messages->setUserToId($_POST['to_user_id']);
    $all_messages->setUserFromId($_POST['from_user_id']);
    echo json_encode($all_messages->loadMessages(), true);
    exit();
   
    
}