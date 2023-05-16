<?php 


class DB{

    protected function conn(){
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
        try{
            $username = $_ENV['MYSQL_USER'];
            $password = $_ENV['MYSQL_PASSWORD'];
            $host = $_ENV['MYSQL_HOST'];
            $db_name = $_ENV['MYSQL_DB_NAME'];
            $db = new PDO('mysql:host=' .$host. ';' . $db_name . '', $username, $password);
            return $db;
        }
        catch(PDOException $e){
            print "Error!" . $e->getMessage() . "<br/>";
            die();
        }
    }


    





}

?>