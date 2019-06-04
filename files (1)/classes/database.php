<?php
 
require_once('config.php');

class Database{
    
    private $connection;
    
    function __construct(){
        $this->open_db_connection();
    }
    public function open_db_connection(){
        
        $this->connection=new mysqli("localhost","iscoralil","katlanim","iscorali_ART");
        if ($this->connection->connect_error){
            die("Connection failed: ".$this->connection->connect_error);
        }

    }
    public function get_connection(){
        return $this->connection;
    }
    public function query($sql){
        
        $result=$this->connection->query($sql);
        if (!$result){
            echo 'Query failed<br>';
            echo 'SQL='.$sql;
            echo '<br>';
            die($this->connection->error);

        }
        else{
            return $result;
        }
    }
    
    public function escape_string($string){
        return $this->connection->real_escape_string($string);
    }
}
$database=new Database();
?>