<?php


class UserRegister extends DB{

    private $username;
    private $email;
    private $password;
    private $verification_code;
    private $user_profile;
    private $user_status;

    
    

    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }


    public function setEmail($email){
        $this->email = $email;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setVerificationCode($verification_code){
        $this->verification_code = $verification_code;
    }

    public function getVerificationCode(){
        return $this->verification_code;
    }

    public function setUserProfile($user_profile){
        $this->user_profile = $user_profile;
    }

    public function getUserProfile(){
        return $this->user_profile;
    }

    public function setUserStatus($user_status){
        $this->user_status = $user_status;
    }

    public function getUserStatus(){
        return $this->user_status;
    }

    function make_profile($character){
        $path = "images/" . time() . ".png";
        $image = imagecreate(200, 200);
        $red = rand(0, 255);
        $green = rand(0, 255);
        $blue = rand(0, 255);
        imagecolorallocate($image, $red, $green, $blue);
        $textcolor = imagecolorallocate($image, 255, 255, 255);

        $font = 'font/arial.ttf';

        imagettftext($image, 75, 0, 55, 150, $textcolor, $font, $character);
        imagepng($image, $path);
        imagedestroy($image);
        return $path;
    }


    function addUser($username, $email, $password, $user_profile, $verification_code){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn()->prepare('INSERT into users (user_username, user_email_address, user_password, user_profile, user_verification_code) VALUES (?,?,?, ?, ?);');
        if(!$stmt->execute(array($username, $email, $hashed_password, $user_profile, $verification_code))){
            $stmt = null;
            header("location: register.php?error=error");
            exit();
        }

        $stmt = null;
    }


    function checkIfExist($username, $email){
        $exist_user = true;
        $stmt = $this->conn()->prepare('SELECT * FROM users WHERE user_username=? or user_email_address=?;');
        if(!$stmt->execute(array($username, $email))){
            $stmt = null;
            header("location: login.php?error=stmtfailed");
            exit();
        }
        if($stmt->rowCount() > 0){
            $exist_user = true;
        }
        else{
            $exist_user = false;
        }
        return $exist_user;

    }

    function registerUser(){
        if($this->checkIfExist($this->username, $this->email)){
            header('location: register.php?error=alreadyexists');
            exit();
        }
        $this->addUser($this->username, $this->email, $this->password, $this->user_profile, $this->verification_code);
    }

    function verifyUser(){
        $sql = 'SELECT * FROM users WHERE user_verification_code=?;';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->verification_code));
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }
    function enableUser(){
        $stmt = $this->conn()->prepare("UPDATE users SET user_account_status=? WHERE user_verification_code=?;");
        if($stmt->execute(array($this->user_status, $this->verification_code))){
            return true;
        }
        else{
            return false;
        }

    }

    









}



?>