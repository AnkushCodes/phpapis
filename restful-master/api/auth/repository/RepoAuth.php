<?php

class RepoAuth{
    private $Input;
    public function __construct(Utility $utility)
    {
        $this->Input=$utility;
    }
    
    public function signup(){
        echo "signup called";
    }

    public function login(){
        echo "gettoken";
    }

    public function gettoken(){
        echo "gettoken";
    }
}
?>