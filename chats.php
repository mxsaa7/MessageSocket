<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

?>
<div class="container-fluid">
    <br>
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-5" style="height:100vh; border-right:1px solid grey;">
            <div class="mt-3 mb-3 text-center">
                <input type="hidden" name="current_user_id" id="current_user_id" value="<?php echo $_SESSION['user_id'];?>">
                <img src='<?php echo $_SESSION['profile_picture']; ?>' class="img-fluid rounded-circle img-thumbnail" width="150" alt=""/>
                <h3 class="mt-2"><?php echo $_SESSION['username'];?></h3>
                <a href="myprofile.php" class="btn btn-info">Profile</a>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
            <h3 class="text-center">Chat List</h3>
            <div class="list-group" style="max-height:100vh; margin-bottom:10px; overflow-y:scroll; -webkit-overflow-scrolling:touch;">
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
                <li class="list-group-item">Musa</li>
            </div>

        </div>
        <div class="col-lg-9 col-md-8 col-sm-7">
            <div class="card">
                <div class="card-header"><h3>This is a chat application</h3></div>
                <div class="card-body" id="message_area" style="min-height:70vh; background:gainsboro; max-height:70vh; overflow-y:scroll; -webkit-overflow-scrolling:touch;">

                </div>
            </div>
            <form action="" method=""POST id="chat_form">
                <div class="input-group mb-3">
                    <textarea class="form-control" name="message" id="message" data-parsley-maxlength="400" data-parsley-pattern="/^a-zA-Z0-9\s]+$/" placeholder="Message"></textarea>
                    <div class="input-group-append">
                        <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){

        var conn = new WebSocket('ws://localhost:80');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        conn.onmessage = function(e) {
            console.log(e.data);

            var data = JSON.parse(e.data);

            var row_class = 'row justify-content-start';

            var background_class = 'text-dark alert-light';

            var html_data = "<div class='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'>"+data.msg+"</div></div></div>";

            $('#message_area').append(html_data);

            $('#message').val('');

        };

        $('#chat_form').on('submit', function(event){
            event.preventDefault();
            
            var user_id = $('#login_user_id').val();

            var message = $('#message').val();

            var data = {
                userId : user_id,
                msg : message
            };

            conn.send(JSON.stringify(data));

        });




    });

</script>
