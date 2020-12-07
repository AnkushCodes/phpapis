<?php
require_once "core/util/auth.php";
class AuthController 
{
    public $auth ;
    public function __construct()
    {
        $auth = new Auth();
    }

    

    public function genrateToken()
    {
        $this->auth->generateToken();
    }

    public function validateToken(){
       $this->auth->validateToken();
    }
}
?>