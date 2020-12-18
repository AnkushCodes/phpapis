<?php

class common{
    
  private $db;

  function __construct($setDb)
  {
    $this->db = $setDb;
  }

  
   public function query($sql){
       $this->stmt = $this->db->prepare($sql);
   }

    public function execute(){
        return $this->stmt->execute();
    }

    public function resultSet(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single(){
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
}
    ?>