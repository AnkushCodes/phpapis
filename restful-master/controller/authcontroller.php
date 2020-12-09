<?php

class AuthController 
{
    public Auth $auth;
    public function __construct($utiObj)
    {
        $this->auth = new Auth($utiObj);
    }

    public function getGenrateToken()
    {
        $this->auth->generateToken();
    }

    public function getValidateToken(){
      return $this->auth->validateToken();
    }
}
?>