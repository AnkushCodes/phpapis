<?php
require_once "database/DB.php";

class Login
{
    private $Input;
    private $uconn;
    private Utility $util;
    function __construct(Utility $setUtilObj)
    {
        $this->Input = $setUtilObj->getInputHandel();
        $this->uconn = DB::getConnection();
        $this->util =  $setUtilObj;
    }

    function doGet()
    {

        $state = "SELECT * FROM products";

        $query = $this->uconn->prepare($state);

        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function doPost()
    {
        try{
        $state = 'insert into login (email,password,active,created_on) values(:email,:password,1,:created_on)';
        $demail = $this->Input['data']['email'];
        $dpassword = $this->Input['data']['password'];
        $dcreated_on = $this->Input['data']['created_on'];
        $query = $this->uconn->prepare($state);
        $query->bindParam(':email', $demail);
        $query->bindParam(':password',md5($dpassword));
        $query->bindParam(':created_on', date('Y-m-d'));

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }catch (Exception $e) {
        $this->util->throwError(402, 'Database Error: ' . $e->getMessage());
    }
    
    }
    function doPut()
    {
        return "Product Put method called";
    }
    function doDelete()
    {
        return "Product Delete method called";
    }
}
