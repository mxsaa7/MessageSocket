<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}
$user = $_SESSION['user_data'];
?>
<title><?php echo $user[0]['user_username'] . "'s Profile";?></title>
<div class="row">
    <div class="col-sm">

    </div>
    <div class="col-lg">
        <div class="mt-3 mb-3 text-center">
            <img src='<?php echo $user[0]['user_profile']; ?>' class="img-fluid rounded-circle img-thumbnail" width="150" alt=""/>
            <br>
            <br>
            <div class="form-group">
                <h2><?php echo $user[0]['user_username'];?></h2>
            </div>
            <div class="form-group">
                <a href="chat.php?cuid=<?php echo $user[0]['id'];?>" class="btn btn-info">Message</a>
                <a href="fuid=<?php echo $user[0]['id'];?>" class="btn btn-secondary">Follow</a>
            </div>
            <div class="form-group">
                <textarea name="bio" id="" cols="30" rows="5" disabled><?php echo $user[0]['user_bio'];?></textarea>
            </div>
        </div>
    </div>
    <div class="col-sm">

    </div>
</div>