<?php
require_once "core/util/auth/JWT.php";
class Auth
{
    // private $aData;
    // public function __construct($aData)
    // {
    //     $this->aData = $aData;

    // }

		public function validateParameter($fieldName, $value, $dataType, $required = true) {
			if($required == true && empty($value) == true) {
				$this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName . " parameter is required.");
			}

			switch ($dataType) {
				case BOOLEAN:
					if(!is_bool($value)) {
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be boolean.');
					}
					break;
				case INTEGER:
					if(!is_numeric($value)) {
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be numeric.');
					}
					break;

				case STRING:
					if(!is_string($value)) {
						$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be string.');
					}
					break;
				
				default:
					$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName);
					break;
			}

			return $value;

		}

    public function generateToken() {
        // $email = $this->validateParameter('email', $this->param['email'], STRING);
        // $pass = $this->validateParameter('pass', $this->param['pass'], STRING);
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
                'exp' => time() + (60*60),
                'userId' => '1' 
               
            ];

            $token = JWT::encode($paylod, SECRETE_KEY);
            
            $data = ['token' => $token];
         
           $this->returnResponse(SUCCESS_RESPONSE, $data); // todo //
        } catch (Exception $e) {
            $this->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
        }
    }

    public function validateToken() {
        try {
            $token = $this->getBearerToken();
            $payload = JWT::decode($token, SECRETE_KEY, ['HS256']);

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
            $this->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
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
        $this->throwError(ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
    }


    public function getAuthorizationHeader()
    {       
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
   

    public function throwError($code, $message)
    {
        header("content-type: application/json");
        $errorMsg = json_encode(['error' => ['status' => $code, 'message' => $message]]);
        echo $errorMsg;
        exit;
    }

    public function returnResponse($code, $data)
    {
        header("content-type: application/json");
        $response = json_encode(['resonse' => ['status' => $code, "result" => $data]]);
        echo $response;
        exit;
    }
}
