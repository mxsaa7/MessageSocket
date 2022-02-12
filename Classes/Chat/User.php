<?php 

class User extends DB{

    private $email;
    private $user_profile;
    private $bio;
    private $user_id;


    public function setUserProfile($user_profile){
        $this->user_profile = $user_profile;
    }

    public function getUserProfile(){
        return $this->user_profile;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setUserID($user_id){
        $this->user_id = $user_id;
    }

    public function getUserID(){
        return $this->user_id;
    }

    public function setBio($bio){
        $this->bio = $bio;
    }

    public function getBio(){
        return $this->bio;
    }

    public function logout(){
        $sql = "UPDATE users SET user_online_status=? WHERE id=?";
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array("Offline", $this->user_id));
    }

    public function uploadImage($user_profile){
        $extension = explode('.', $user_profile["name"]);
        $new_name = rand() . '.' . $extension[1];
        $destination = "images/" . $new_name;
        move_uploaded_file($user_profile["tmp_name"], $destination);
        return $destination;
    }

    
    public function updateUser(){
        $sql = 'UPDATE users SET user_email_address=?, user_profile=?, user_bio=? WHERE id=?';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->email, $this->user_profile, $this->bio, $this->user_id));
    }
    
 

    












}


?>