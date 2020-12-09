<?php 

require_once "database/DB.php";

class product {
    private $Input;
    private $uconn; 
    function __construct(Utility $setUtilObj){
       $this->Input = $setUtilObj->getInputHandel();
      
        $this->uconn = DB::getConnection();
      
    }
    function doGet(){
        
        $state = "SELECT * FROM products";
    
        $query = $this->uconn->prepare($state);
   
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function doPost(){
        return "Product Post method called";
    }
    function doPut(){
        return "Product Put method called";
    }
    function doDelete(){
        return "Product Delete method called";
    }
}
