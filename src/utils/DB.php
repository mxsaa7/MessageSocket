<?php 

class DB{

    protected function conn(){
        try{
            $username = 'root';
            $password = '';
            $db = new PDO('mysql:host=localhost; dbname=message', $username, $password);
            return $db;
        }
        catch(PDOException $e){
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }


    





}

?>