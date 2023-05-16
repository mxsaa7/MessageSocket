<?php 

class UserLogin extends DB{

    
    private $username;
    private $password;
    private $online_status;



    public function setUsername($username){
        $this->username = $username;
    }

    public function getUsername(){
        return $this->username;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function getUserAccountStatus(){
        $sql = 'SELECT * FROM users WHERE user_username=? or user_email_address=?;';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($this->username, $this->username));
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $user_status = $user[0]['user_account_status'];
        if($user_status == 'Enabled'){
            return true;
        }
        else{
            return false;
        }
    }

    public function setUserStatusOnline($user_id, $online_status){
        $sql = 'UPDATE users SET user_online_status = ? WHERE id = ?;';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($online_status, $user_id));
        $this->online_status = $online_status;
    }

    public function getOnlineStatus(){
        return $this->online_status;
    }


    function checkIfEmpty(){
        if(empty($this->username || $this->password)){
            return true;
        }
        else{
            return false;
        }
    }

    function validateUser(){
        $sql = 'SELECT user_password FROM users WHERE user_username = ? OR user_email_address = ?;';
        $stmt = $this->conn()->prepare($sql);
        if(!$stmt->execute(array($this->username, $this->username))){
            $stmt = null;
            header('location: login.php?error=!');
            exit();
        }

        if($stmt->rowCount() == 0){
            $stmt = null;
            header('location: login.php?login=ntfnd2');
            exit();
        }

        $pwd_hashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($this->password, $pwd_hashed[0]['user_password']);
        if($checkPwd == false){
            //incorrect password
            $user = null;
            header('location: login.php?login=invalid');
            exit();
        }
        elseif($checkPwd == true){
            $sql = "SELECT * FROM users WHERE user_username = ? OR user_email_address = ? AND user_password = ?;";
            $stmt = $this->conn()->prepare($sql);

            if(!$stmt->execute(array($this->username, $this->username, $this->password))){
                //failed statement
                $stmt = null;
                header('location: login.php?error=!');
                exit();
            }

            if($stmt->rowCount() == 0){
                //user not found
                //when email is typed in, it says it is not found
                $stmt = null;
                header('location: login.php?login=ntfnd1');
                exit();
            }

            if($this->getUserAccountStatus()){
                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
                session_start();
                $_SESSION['user_id'] = $user[0]['id'];
                $_SESSION['username'] = $user[0]['user_username'];
                $_SESSION['email'] = $user[0]['user_email_address'];
                $_SESSION['profile_picture'] = $user[0]['user_profile'];
                $_SESSION['bio'] = $user[0]['user_bio'];
                $this->setUserStatusOnline($_SESSION['user_id'], 'Online');
                $_SESSION['online_status'] = $this->getOnlineStatus();
                //fetch data 
                header("location: myprofile.php?login=success".$user[0]['username']);
                $stmt = null;
                
            }
            else{
                header('location: login.php?accnt=notenabled');
                $stmt = null;
                
            }

        }



    }   












}




?>