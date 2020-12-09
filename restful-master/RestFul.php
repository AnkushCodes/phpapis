<?php
require_once "core/util/utility.php";
require_once "controller/authcontroller.php";
require_once "core/util/auth.php";

class RestFul
{
    public $RequestURI;
    public $RequestedRoute;
    public $Input;
    public $Routes;
    public $Id;
    
    function __construct($routes)
    {
        $this->Routes = $routes;
        
        $this->RequestURI = Utility::getPathValue($_SERVER['REQUEST_URI']);
 
        $this->RequestMethod = $_SERVER['REQUEST_METHOD'];
     

        if ($this->RequestURI == "/") {
            foreach ($this->Routes as $key => $Route) {
                echo $key . "<br>";
            }
        } else {
            $this->RequestedRoute = $this->Routes["/".$this->RequestURI[2] . "/" . $this->RequestURI[3]];
    
            $ResourceName = $this->RequestURI[3];
            $tableName = (string)  $this->RequestURI[3];
            $utility = new Utility();
            if ($this->RequestURI[4] != null) {
                $utility->setId((int) $this->RequestURI[4]);
               
            } 

           
            //  $authControllre = new AuthController($utility);
            //  $authControllre->getValidateToken();

           //  $authControllre->getGenrateToken(); exit;
           
            require $this->RequestedRoute['resource'] . ".php";
            $ResourceObj = new $ResourceName($utility);

            switch ($this->RequestMethod) {
                case "GET":
                    if ($this->RequestedRoute['get'] == true) {
                        $this->response($ResourceObj->doGet());
                    } else {
                        $this->response(array("message" => "not allowed"));
                    }
                    break;
                case "POST":
                    if ($this->RequestedRoute['post'] == true) {
                        $this->response($ResourceObj->doPost());
                    } else {
                        $this->response(array("message" => "not allowed"));
                    }
                    break;
                case "PUT":
                    if ($this->RequestedRoute['put'] == true) {
                        $this->response($ResourceObj->doPut());
                    } else {
                        $this->response(array("message" => "not allowed"));
                    }
                    break;
                case "DELETE":
                    if ($this->RequestedRoute['delete'] == true) {
                        $this->response($ResourceObj->doDelete());
                    } else {
                        $this->response(array("message" => "not allowed"));
                    }
                    break;
            }
        }
    }

    function response($data)
    {
        echo json_encode(array("status" => 200, "data" => $data));
    }
}

