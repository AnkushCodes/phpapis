<?php
require_once "api/auth/Bean/authbean.php";

class AuthRepo
{

  public Utility $utili;
  public AuthBean $auth;
  public function __construct($utiObj)
  {
    $this->auth = new AuthBean($utiObj);
    $this->utili = $utiObj;
  }

  public function signup()
  {
    $input = $this->utili->Input["data"];
    var_dump("signup");
    $name = $this->utili->validateParameter('name', $input['name'], STRING);
    $email = $this->utili->validateParameter('email', $input['email'], STRING);
    $pass = $this->utili->validateParameter('pass', $input['password'], STRING);
    $isActive = $this->utili->validateParameter('isactive', $input['isactive'], INTEGER);

    $this->auth->setName($name);
    $this->auth->setEmail($email);
    $this->auth->setPass($pass);
    $this->auth->setIsActive($isActive);

    if (!$this->auth->insert()) {
      $message = 'Failed to insert.';
    } else {
      $message = "Inserted successfully.";
    }

    $this->utili->returnResponse(SUCCESS_RESPONSE, $message);
  }

  public function login()
  {

    $input = $this->utili->Input["data"];
    $email = $this->utili->validateParameter('email', $input['email'], STRING);
    $pass = $this->utili->validateParameter('password', $input['password'], STRING);
    $this->auth->setEmail($email);
    $this->auth->setPass($pass);
    $this->auth->generateToken();
  }

  public function gettoken()
  {
    return $this->auth->validateToken();
  }
}
