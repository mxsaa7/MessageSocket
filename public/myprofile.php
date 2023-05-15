<?php 
session_start();
require_once '../src/utils/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}
        $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        if(strpos($fullUrl, "login=success") == true){
            $success = "You Have Successfully Logged In";
            echo '<div class="alert alert-success" style="text-align:center;">
                    '.$success. " " .$_SESSION['username'].'
                </div>';
        }
        elseif(strpos($fullUrl, "update=success") == true){
            $success = "You're profile has been updated!";
            echo '<div class="alert alert-info" style="text-align:center;">
                    '.$success.'
                </div>';
        }

?>
<div class="row">
    <div class="col-sm">

    </div>
    <div class="col-lg">
        <div class="mt-3 mb-3 text-center">
            <img src='<?php echo $_SESSION['profile_picture']; ?>' class="img-fluid rounded-circle img-thumbnail" width="150" alt=""/>
            <br>
            <br>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name='profile' id='profile'>
                    <input type="hidden" name="hidden_user_profile" value='<?php echo $_SESSION['profile_picture'];?>'>
                </div>
                <textarea name="bio" id="" cols="50" rows="5" placeholder="Tell us about yourself..." ><?php echo $_SESSION['bio'];?></textarea>
                <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['email'];?>">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" name="username" class="form-control"  value="<?php echo $_SESSION['username'];?>" disabled>
                </div>
                <div class="form-group">
                    <input type="submit" name="update" class="btn btn-info" value="Update">
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </form>
        </div>
    </div>
    <div class="col-sm">

    </div>
</div>