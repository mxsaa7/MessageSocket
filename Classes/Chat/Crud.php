<?php 

class Crud extends User{


    public function searchUser($name){
        $sql = 'SELECT * FROM users WHERE user_username=?;';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($name));
        if($stmt->rowCount() == 0){
            header('location: explore.php?er=ntfound');
        }
        else{
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
            header('location: explore.php?search=?'. $name . '%20');
            return $user;
            
        }
    }


    public function viewProfile($user_id){
        $sql = 'SELECT * FROM users WHERE id=?;';
        $stmt = $this->conn()->prepare($sql);
        $stmt->execute(array($user_id));
        $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $user;
    }






}



?>