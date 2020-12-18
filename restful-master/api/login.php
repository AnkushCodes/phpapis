<?php
require_once "database/DB.php";
require_once "api/auth/repository/RepoAuth.php";

class Login
{
   
    private Utility $util;
    private RepoAuth $repoAuth;
    function __construct(Utility $setUtilObj)
    {
        // $this->Input = $setUtilObj->getInputHandel();
        // $this->uconn = DB::getConnection();
        $this->util =  $setUtilObj;
        // $this->repoAuth = new RepoAuth();
    }
   
    function doGet()
    {
        // print_r( $this->util->getCallFuntion()); exit;
        $calls = $this->util->getCallFuntion();
       
         $this->repoAuth->$calls();
        exit;

        // $state = "SELECT * FROM products";

        // $query = $this->uconn->prepare($state);

        // $query->execute();
        // return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    function doPost()
    {
        //     try{
        //     $state = 'insert into login (email,password,active,created_on) values(:email,:password,1,:created_on)';
        //     $demail = $this->Input['data']['email'];
        //     $dpassword = $this->Input['data']['password'];
        //     $dcreated_on = $this->Input['data']['created_on'];
        //     $query = $this->uconn->prepare($state);
        //     $query->bindParam(':email', $demail);
        //     $query->bindParam(':password',md5($dpassword));
        //     $query->bindParam(':created_on', date('Y-m-d'));

        //     if ($query->execute()) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        // }catch (Exception $e) {
        //     $this->util->throwError(402, 'Database Error: ' . $e->getMessage());
        // }

    }
    function doPut()
    {
        // return "Product Put method called";
    }
    function doDelete()
    {
        // return "Product Delete method called";
    }
}
