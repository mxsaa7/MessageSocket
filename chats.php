<?php 
session_start();
require_once 'Classes/include.php';
if(!isset($_SESSION['user_id'])){
    header('location: login.php');
}

$user = new User();
$token = md5(uniqid());
$user->setUserID($_SESSION['user_id']);
$user->setUserToken($token);
$user->updateToken();

$_SESSION['user_token'] = $user->getUserToken();
$token = $_SESSION['user_token'];
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
            <input type="hidden" name="login_user_id" id="login_user_id" value="<?php echo $_SESSION['user_id'];?>">
            <?php 
                $crud = new Crud();
                $users = $crud->getAllUsers($_SESSION['user_id']);
                foreach($users as $user){
                    if($user['user_online_status'] == 'Online'){

                        $icon = '<i class="fa fa-circle text-success"></i>';
        
                    }
                    else{

                        $icon = '<i class="fa fa-circle text-danger"></i>';

                    }

                    echo 
                        "<a class='list-group-item list-group-item-action select_user' style='cursor:pointer' data-userid='".$user['id']."'>
                            <img src='".$user['user_profile']."' class='img-fluid rounded-circle img-thumbnail' width='50' />
                            <span class='ml-2'>
                                <strong>
                                    <span id='list_user_name_".$user["id"]."'>".$user['user_username']."</span>
                                    <span id='userid_".$user['id']."'>5</span>
                                </strong>
                            </span>
                            <span class='mt-3 float-right' id='userstatus_".$user['id']."'>".$icon."</span>
                        </a>
                        ";

                }
            ?>
            </div>

        </div>
        <div class="col-lg-9 col-md-8 col-sm-7">
            <div id="message_area"></div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function(){
        
        var to_user_id = '';

        var conn = new WebSocket('ws://localhost:80?token=<?php echo $token; ?>');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        function make_message_area(user_name, to_user_id){
            var html = `
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col col-sm-6">
                            <b>Chat with <span class="text-danger" id="chat_user_name">`+ user_name +`</span></b>
                        </div>
                        <div class="col col-sm-6 text-right">
                            <a href="profile.php?uid=`+to_user_id+`" class="btn btn-info">Profile</a>
                            <button type="button" class="close" id="close" data-dismis"alert" arial-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                    </div> 
                </div>
                <div class="card-body" id="messages_area" style="max-height:75vh; min-height:75vh; overflow-y:scroll;">
                </div>
            </div>
            <form id="message_form" method="POST">
                <div class="input-group mb-3">
                        <textarea type="text" name="message" id="message" class="form-control" placeholder="Message"></textarea>
                        <div class="input-group-append">
                            <button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
                        </div>
                </div>
            </form>  
            `;

            $('#message_area').html(html);
            
        }

        $(document).on('click', '.select_user', function(){

            to_user_id = $(this).data('userid');

            var from_user_id = $('#current_user_id').val();

            var to_user_name = $('#list_user_name_'+ to_user_id).text();

            $('.select_user.active').removeClass('active');

            $(this).addClass('active');

            make_message_area(to_user_name, to_user_id);

            $('#is_active_chat').val('Yes');


            $.ajax({
                method:"POST", 
                data:{action:'fetch_chat', to_user_id:to_user_id, from_user_id:from_user_id},
                dataType:"json",
                success:function(data){
                    

                    if(data.length > 0){
                        
                        var html_data = '';

                        for(var count = 0; count < data.length; count++){
                            
                            var row_class = '';
                            var background_class = '';
                            var user_name = '';
                            var delete_icon = '';

                            if(data[count].message_from_id == from_user_id){

                                row_class = 'chat-message-right pb-4'
                                background_class = 'alert-primary';
                                delete_icon = '<i class="fa fa-trash" id="delete_message"></i>';
                                user_name = 'Me';
                                
                            }
                            else{

                                row_class = 'chat-message-left pb-4';
                                background_class = 'alert-success';
                                user_name = data[count].user_username;
                            }

                             html_data = 
                             `
                             <div class="`+row_class+`">
                                 <img src="`+data[count].user_profile+`" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                                 <div class="col-sm-10">
                                     <div class="shadow alert `+background_class+`">
                                         <b id="message_id_"`+data[count].id+`>`+user_name+` - </b>
                                         `+data[count].message_body+`
                                         <div class="text-right">
                                             `+delete_icon+`
                                         <div>
                                         <br>
                                         <div class="text-right">
                                             <small><i>`+data[count].message_timestamp+`</i><small>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                            
                             `;


                            $('#messages_area').append(html_data);
                        }
                        $('#userid_').html('');

                        

                        $('#message_area').scrollTop($('#message_area')[0].scrollHeight);

                    }
                }
            });
    
        });

        $(document).on('click', '#close', function(){

            $('#message_area').html('');

            $('.select_user.active').removeClass('active');


        });

        $(document).on('submit', '#message_form', function(event){
            event.preventDefault();
            var current_user_id = $('#login_user_id').val();
            var receiver_user_id = $().val();
            var message = $('#message').val();
            var data = {
                current_user_id: current_user_id, 
                msg : message,
                receiver_user_id : to_user_id
            };

            conn.send(JSON.stringify(data));

        });

        conn.onmessage = function(e) {
            console.log(e.data);

            var data = JSON.parse(e.data);

            var row_class = '';

            var background_class = '';

            var delete_icon = '';

            if(data.from == 'Me'){
                row_class = 'chat-message-right pb-4';
                background_class = 'alert-primary';
                delete_icon = '<i class="fa fa-trash" id="delete_message"></i>';
                
            }
            else{
                row_class = 'chat-message-left pb-4';
                background_class = 'alert-success';
            }

            if(to_user_id == data.userId || data.from == 'Me'){
                
            }
            var html_data = `
                    <div class='`+row_class+`'>
                        <img src="`+data.user_profile+`" class="rounded-circle mr-1" alt="Chris Wood" width="40" height="40">
                        <div class='col-sm-10'>
                            <div class='shadow alert `+background_class+`'>
                            <b>`+data.from+` - </b>`+data.msg+`<br>
                                <div class="text-right">
                                '`+delete_icon+`'
                                </div>
                                <br>
                                <div class="text-right">
                                    <small><i>`+data.datetime+`</i></small>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    
                    $('#messages_area').append(html_data);
                    $('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
                    $('#message').val('');


        };

  
    });

</script>
