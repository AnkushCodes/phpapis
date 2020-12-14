<?php
require_once "core/utility.php";
require_once "api/auth/authcontroller.php";
require_once "core/auth.php";

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
        //  echo(json_encode($this->RequestURI ));
        $this->RequestMethod = $_SERVER['REQUEST_METHOD'];

        // if ($this->RequestURI == "/") {
        //     foreach ($this->Routes as $key => $Route) {
        //         echo $key . "<br>";
        //     }
        // } else {

        $counts = count($this->RequestURI);
        if (!($counts  >= 4)) {
            $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API"));
        } else {
            $parameter = "/" . $this->RequestURI[2] . "/" . $this->RequestURI[3];

          //
            if($this->Routes[$parameter] == null){
                $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API5")); exit;
            }
            $this->RequestedRoute = $this->Routes[$parameter] ;
            
            if($this->RequestedRoute['function'] == null){
                $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API6")); exit;
            }

            $ResourceName         = $this->RequestURI[3];
            $tableName            = (string)$this->RequestURI[4];

             if(!in_array($tableName, $this->RequestedRoute['function'])){
                $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API8"));
             }
            $utility              = new Utility();
            $utility->setCallFuntion((string)$this->RequestURI[4]);
            if ($counts == 5 && $this->RequestURI[5] != null) {
                $utility->setId((int) $this->RequestURI[5]);
            }
            // }



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
