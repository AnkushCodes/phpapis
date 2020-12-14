<?php
class Routes{

//  static public funtion is(){

//  }   

static public function getRoutes()
{
    // $Routes =
    return array(
        "/api/auth" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/auth",
            "function"=>[
                "signup",
                "gettoken"
            ]
        ),
        "/api/product" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/product"
        ),

        "/api/login" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/auth/login"
        ));
        
}

}

?>