<?php 

class Message extends User{
    
    private $user_to_id;
    private $user_from_id;
    private $message;


    public function __constructor($user_to_id, $user_from_id, $message){
        $this->$user_to_id = $user_to_id;
        $this->$user_from_id = $user_from_id;
        $this->message = $message;
    }

    public function getUserToId(){
        return $this->user_to_id;
    }

    public function getUserFromId(){
        return $this->user_from_id;
    }

    public function getMessage(){
        return $this->message;
    }


    public function sendMessage(){
        $sql = "INSERT into messages (message_to_id, message_from_id, message_body) VALUES (?,?,?);";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->user_to_id, $this->user_from_id, $this->message));
    }








}




?>