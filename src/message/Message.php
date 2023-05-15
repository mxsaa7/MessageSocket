<?php 

class Message extends User{
    
    private $user_to_id;
    private $user_from_id;
    private $timestamp;
    private $message;
    private $message_id;


    public function setMessageId($message_id){
        $this->message_id = $message_id;
    }

    public function getMessageId(){
        return $this->message_id;
    }
    public function setUserToId($user_to_id){
        $this->user_to_id = $user_to_id;
    }

    public function getUserToId(){
        return $this->user_to_id;
    }

    public function setUserFromId($user_from_id){
        $this->user_from_id = $user_from_id;
    }

    public function getUserFromId(){
        return $this->user_from_id;
    }

    public function setTimeStamp($timestamp){
        $this->timestamp = $timestamp;
    }

    public function getTimeStamp(){
        return $this->timestamp;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }

    public function loadMessages(){
        $sql = "SELECT * FROM messages 
                INNER JOIN users ON messages.message_from_id = users.id
                WHERE message_to_id=? AND message_from_id=? 
                OR message_to_id=? AND message_from_id=?";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->user_from_id, $this->user_to_id, $this->user_to_id, $this->user_from_id));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }

    public function sendMessage(){
        $sql = "INSERT into messages (message_to_id, message_from_id, message_body, message_timestamp) VALUES (?, ?, ?, ?);";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->user_to_id, $this->user_from_id, $this->message, $this->timestamp));
    }

    public function deleteMessage(){
        $sql = "DELETE FROM messages WHERE id=?";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->message_id));
    }








}




?>