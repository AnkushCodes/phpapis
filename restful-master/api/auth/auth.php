<?php
require_once "database/DB.php";
require_once "api/auth/repository/authrepo.php";
class Auth
{
    private $util;
    private $repoAuth;
    function __construct(Utility $setUtilObj)
    {
       $this->repoAuth = new AuthRepo($setUtilObj);
       $this->util = $setUtilObj;
    }

    function doGet()
    {
        $calls = $this->util->getCallFuntion();     
        $this->repoAuth->$calls();
        exit;
    }
    function doPost()
    {
        $calls = $this->util->getCallFuntion();
        $this->repoAuth->$calls();
        exit;
    }
    function doPut()
    {
        $calls = $this->util->getCallFuntion();
        $this->repoAuth->$calls();
        exit;
    }
    function doDelete()
    {
        $calls = $this->util->getCallFuntion();
        $this->repoAuth->$calls();
        exit;
    }
}
