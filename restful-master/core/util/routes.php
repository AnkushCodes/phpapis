<?php
class Routes{

static public function getRoutes()
{
    // $Routes =
    return array(
        "/api/user" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/user"
        ),
        "/api/product" => array(
            "get" => true,
            "post" => true,
            "put" => true,
            "delete" => true,
            "resource" => "api/product"
        ));
        
}

}

?>