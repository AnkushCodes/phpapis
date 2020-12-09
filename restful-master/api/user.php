<?php 
require_once "database/connectdb.php";
require_once "core/util/utility.php";

class user{  
    private $Input;
    private $uconn; 
    function __construct(Utility $setUtilObj){
       $this->Input = $setUtilObj->getInputHandel();
        $instance = ConnectDb::getInstance(); 
        $this->uconn = $instance->getConncection();
    }
    function doGet(){
       $state = "SELECT * FROM `users` ";
       $query = $this->uconn->prepare($state);
       $query->execute();
       return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function doPost(){

    }
    function doPut(){
         
        return $this->Input['PUT']['username'];
    }
    function doDelete(){
        return "Do Delete";
    }
}


?>