<?php
require_once "core/package/token/JWT.php";
class AuthBean
{
    private $name;
    private $email;
    private $isActive;
    private $pass;

    private Utility $util;
    private $db;
    public function __construct(Utility $setUtil)
    {
        $this->util = $setUtil;
        $this->db = DB::getConnection();
    }

    function setName($name){$this->name = $name;}

    function setEmail($email){$this->email = $email;}

    function setPass($ispass){$this->pass = $ispass;}

    function getName(){return $this->name;}

    function getEmail(){return $this->email;}

    function setIsActive($setIsActive){$this->isActive = $setIsActive;}

    function geIsActive(){return $this->isActive;}

    public function insert()
    {
        $date =  date('y-m-d');
        echo $date;
        $stmt = $this->db->prepare("insert into users (name,email,password,active,created_on) values (:name,:email,:password,:active,:created_on)");
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password",md5($this->pass));
        $stmt->bindParam(":active", $this->isActive);
        $stmt->bindParam(":created_on",$date);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function generateToken()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email AND password = :pass");
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":pass", md5($this->pass));
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!is_array($user)) {
                $this->util->returnResponse(INVALID_USER_PASS, "Email or Password is incorrect.");
            }

            if ($user['active'] == 0) {
                $this->util->returnResponse(USER_NOT_ACTIVE, "User is not activated. Please contact to admin.");
            }

            $paylod = [
                'iat' => time(),
                'iss' => 'localhost',
                'exp' => time() + (60 * 60),
                'userId' =>  $user['id']

            ];

            $token = JWT::encode($paylod, SECRETE_KEY);

            $data = ['token' => $token];

            $this->util->returnResponse(SUCCESS_RESPONSE, $data); // todo //
        } catch (Exception $e) {
            $this->util->throwError(JWT_PROCESSING_ERROR, $e->getMessage());
        }
    }

    public function validateToken()
    {
        try {
            $token = $this->getBearerToken();
            $payload = JWT::decode($token, SECRETE_KEY, ['HS256']);
            echo  $payload->userId;
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :userId");
            $stmt->bindParam(":userId", $payload->userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!is_array($user)) {
                $this->util->returnResponse(INVALID_USER_PASS, "This user is not found in our database.");
            }

            if ($user['active'] == 0) {
                $this->util->returnResponse(USER_NOT_ACTIVE, "This user may be decactived. Please contact to admin.");
            }

            $this->util->setuserId($payload->userId);
        } catch (Exception $e) {
            $this->util->throwError(ACCESS_TOKEN_ERRORS, $e->getMessage());
        }
    }



    public function getBearerToken()
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        $this->util->throwError(ATHORIZATION_HEADER_NOT_FOUND, 'Access Token Not found');
    }


    public function getAuthorizationHeader()
    {
        $input = $this->util->getInputHandel();

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
