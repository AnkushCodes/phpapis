<?php

class Routes{


static public function getRoutes()
{
    // $Routes =
    return array(
        "/api/auth" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/auth/auth",
            "function"=>array(
                "signup"=>"POST",
                "login"=>"POST",
                "gettoken"=>"POST"
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
                "addproduct"=>"POST",
                "getproduct"=>"GET",
                "getproducts"=>"GET",
                "updateproduct"=>"PUT",
                "deleteproducts"=>"DELETE"            
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