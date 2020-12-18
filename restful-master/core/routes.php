<?php

class Routes{

//  static public funtion is(){

//  }   

static public function getRoutes()
{
    // $Routes =
    return array(
        "/api/login" => array(
            "get" => false,
            "post" => false,
            "put" => false,
            "delete" => false,
            "resource" => "api/auth/login",
            "function"=>array(
                "signup"=>"GET",
                "gettoken"
            ),
            "gurd"=>false
        ),
        "/api/product" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/product/product",
            "function"=>array(
                "getproducts"=>"GET"              
            ),
            "gurd"=>true
        ),

        // "/api/login" => array(
        //     "get" => true,
        //     "post" => true,
        //     "put" => true,
        //     "delete" => true,
        //     "resource" => "api/auth/login",
        //     "function"=>array(
        //         "signup"=>"GET",
        //         "gettoken"=>"POST"
        //     ),
        //     "gurd"=>true
        // )
    );
        
}

}

?>