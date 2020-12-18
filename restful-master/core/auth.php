<?php
require_once "core/package/token/JWT.php";
class Auth
{
    // private $aData;
    private $utilObj;
    public function __construct($setUtilObj)
    {
        $this->utilObj = $setUtilObj;
    }


    public function generateToken()
    {
        // $email = $this->utilObj->validateParameter('email', $this->param['email'], STRING);
        // $pass = $this->utilObj->validateParameter('pass', $this->param['pass'], STRING);
        try {
            // $stmt = $this->dbConn->prepare("SELECT * FROM users WHERE email = :email AND password = :pass");
            // $stmt->bindParam(":email", $email);
            // $stmt->bindParam(":pass", $pass);
            // $stmt->execute();
            // $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // if(!is_array($user)) {
            //     $this->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
            // }

            // if( $user['active'] == 0 ) {
            //     $this->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
            // }

            $paylod = [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + (60 * 60),
                'userId' => '1'

            ];

            $token = JWT::encode($paylod, SECRETE_KEY);

            $data = ['token' => $token];

            $this->utilObj->returnResponse(SUCCESS_RESPONSE, $data); // todo //
        } catch (Exception $e) {
            $this->utilObj->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
        }
    }

    public function validateToken()
    {
        try {
            $token = $this->getBearerToken();
            $payload = JWT::decode($token, SECRETE_KEY, ['HS256']);
            echo  $payload->userId;
            // $stmt = $this->dbConn->prepare("SELECT * FROM users WHERE id = :userId");
            // $stmt->bindParam(":userId", $payload->userId);
            // $stmt->execute();
            // $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // if(!is_array($user)) {
            //     $this->returnResponse(INVALID_USER_PASS, "This user is not found in our database.");
            // }

            // if( $user['active'] == 0 ) {
            //     $this->returnResponse(USER_NOT_ACTIVE, "This user may be decactived. Please contact to admin.");
            // }

            $this->userId = $payload->userId;
        } catch (Exception $e) {
            $this->utilObj->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }


    /**
     * get access token from header
     * */
    public function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        $this->utilObj->throwError(ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
    }


    public function getAuthorizationHeader()
    {
        $input = $this->utilObj->getInputHandel();

        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($input["Authorization"]);
            
            print_r(1);
        } else if (isset($input['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($input["HTTP_AUTHORIZATION"]);
            print_r(2);
        } elseif ($input['is_apache_request_headers']) {
            $requestHeaders = $input['apache_request_headers'];
            print_r(3);
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
                print_r(4);
            }
        }
        return $headers;
    }
}
