<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

?>

<title>Explore</title>
<div class="container-fluid" style="margin-top:5%;">
    <div class="row">
        <div class="col">
            <h3>Search by Username</h3>
            <br>
            <form action="" method="POST" class="form-inline">
                <div class="input-group">
                    <input type="text" name="name" class="form-control" placeholder="Search...">
                    <button type="submit" name="search" class="input-group-addon"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        <div class="col-6"></div>
    </div>
    <div class="row">
        <div class="col">
            <ul class="list-group" style="width:30%;">
                    
                    <?php if(!empty($_SESSION['users'])){
                            foreach($_SESSION['users'] as $user){?>
                            <li class="list-group-item"><img src="<?php echo $user['user_profile'];?>" alt="" width="40" height="40" style="margin-right:5px;"><a href="profile.php?uid=<?php echo $user['id'];?>"><?php echo $user['user_username'] ;?></a></li>
                    <?php }
                    
                        }
                        if(isset($_GET['er']) && $_GET['er'] == "ntfound"){
                            echo " <li class='list-group-item'>No users found</li>";
                        }
                    ?>
                    
            </ul>
        </div>
        <div class="col-6"></div>
    </div>
</div>

