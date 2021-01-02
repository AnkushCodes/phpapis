<?php
require_once "core/utility.php";
// require_once "core/authcontroller.php";
// require_once "core/auth.php";

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

        $counts = count($this->RequestURI);
        $utility              = new Utility();


        //content
        if ($_SERVER['CONTENT_TYPE'] !== 'application/json') {
            $utility->throwError(REQUEST_CONTENTTYPE_NOT_VALID, 'Request content type is not valid');
            exit;
        }


        // (
        // [0] =>
        // [1] => index.php
        // [2] => api
        // [3] => product
        // [4] => getproducts
        // )
        if (!($counts  >= 4)) {
            $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API"));
        }
        $parameter = "/" . $this->RequestURI[2] . "/" . $this->RequestURI[3];

        //check routes method avilable
        if ($this->Routes[$parameter] == null) {
            $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API5"));
            exit;
        }
        $this->RequestedRoute = $this->Routes[$parameter];

        //check routes method avilable
        if ($this->RequestedRoute['function'] == null) {
            $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API6"));
            exit;
        }


        $ResourceName         = $this->RequestURI[3];
        if (strpos($this->RequestURI[4], '?') !== false) {
            $paramsVal = explode('?', $this->RequestURI[4]);
            echo json_encode($paramsVal);
            $tableName =  $paramsVal[0];
            if (strpos($this->RequestURI[4], 'id') !== false) $utility->setId();
        } else {
            $tableName = (string)$this->RequestURI[4];
        }

        //route key check
        if (!array_key_exists($tableName, $this->RequestedRoute['function'])) {

            $this->response(array(REQUEST_METHOD_NOT_VALID => "INVALID API8"));
            exit;
        }

        if (!($this->RequestedRoute['function'][$tableName] == $this->RequestMethod)) {
            $this->response(array("message" => "not allowed request method"));
            exit;
        }


        // if ($this->RequestedRoute['guard'] == true) {
        //     $authControllre = new AuthController($utility);
        //     $authControllre->getValidateToken();
        // }


        $utility->setCallFuntion((string)$this->RequestURI[4]);

        //id get from get
        // if ($counts == 6 && $this->RequestURI[5] != null && $this->RequestURI[5] ) {
        //     $utility->setId((int) $this->RequestURI[5]);
        // }

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


    function response($data)
    {

        echo json_encode(array("status" => 100, "data" => $data));
    }
}
