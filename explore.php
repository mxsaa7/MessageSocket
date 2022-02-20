<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

?>

<title>Explore</title>
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-5" style="height:100vh; border-right:1px solid grey;">
            <div class="mt-3 mb-3 text-center">
            <h3>Search by Username</h3>
            <br>
            <form action="" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Search a friend">
                    <div class="input-group-append">
                        <button type="submit" name="search" class="btn btn-primary"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </form>
            </div>
            <div class="list-group" style="max-height:100vh; margin-bottom:10px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                    
                    <?php if(!empty($_SESSION['users'])){
                            foreach($_SESSION['users'] as $user){
                                echo '<li class="list-group-item select_user" data-userid="'.$user['id'].'"><img src="'.$user['user_profile'].'" alt="" width="40"><a href="" style="margin-left: 5px;">'.$user['user_username'].'</a></li>';
                            }
                    
                        }
                        if(isset($_GET['er']) && $_GET['er'] == "ntfound"){
                            echo " <li class='list-group-item'>No users found</li>";
                        }
                    ?>
            </div>

        </div>
        <div class="col-lg-9 col-md-8 col-sm-7">
            <?php 
            
                $crud = new Crud(); 
                $message = $crud->welcomeMessage($_SESSION['username']);

            ?>
            <h3 class="text-center"><?php echo $message;?></h3>
        </div>
</div>
<script>
    $(document).ready(function(){

        $(document).on('click', '.select_user', function(){
            user_id = $(this).data('userid');
            console.log(user_id);

            $.ajax({
                url:'user.process.php',
                type: 'POST',
                data:{action: 'view_profile', user_id:user_id},
                dataType: 'JSON', 
                success:function(data){
                    for(var i = 0; i < len; i++){
                        var user_id = data[i].user_id;
                    }
                }
            });
        });




    });
</script>


