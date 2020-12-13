<?php
require_once "database/DB.php";

class Login
{
    private $Input;
    private $uconn;
    function __construct(Utility $setUtilObj)
    {
        $this->Input = $setUtilObj->getInputHandel();
        $this->uconn = DB::getConnection();
        print_r($this->Input['POST']);
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
        print_r('anc');
        // $state = 'insert into login (email,password,active,created_on) values(:email,:password,1,:created_on)';
        // $demail = $this->Input['POST']['email'];
        // $dpassword = $this->Input['POST']['password'];
        // $dcreated_on = $this->Input['POST']['created_on'];
        // $query = $this->uconn->prepare($state);
        // $query->bindParam(':email', $demail);
        // $query->bindParam(':password', $dpassword);
        // $query->bindParam(':created_on', $dcreated_on);

        // if ($query->execute()) {
        //     return true;
        // } else {
        //     return false;
        // }
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
