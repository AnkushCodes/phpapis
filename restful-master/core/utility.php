
<?php
require_once "constant/constants.php";

class Utility
{
	public $Input;
	public $userId;

	public function __construct()
	{

		parse_str(file_get_contents("php://input"), $_PUT);
		$this->Input['PUT']     = $_PUT;
		$this->Input['GET']     = $_GET;
		$this->Input['FORM']    = $_POST;
		echo json_encode($this->Input['GET']);
		$this->Input['FILES']   = $_FILES;
		$handler = fopen('php://input', 'r');
		$request = stream_get_contents($handler);
		$this->Input['data'] = json_decode($request, true);

		if (isset($_SERVER['Authorization']))     $this->Input['Authorization'] = $_SERVER['Authorization'];
		if (isset($_SERVER['HTTP_AUTHORIZATION'])) $this->Input['HTTP_AUTHORIZATION']        = $_SERVER['HTTP_AUTHORIZATION'];
		if (function_exists('apache_request_headers'))   $this->Input['is_apache_request_headers'] = function_exists('apache_request_headers');
		if (isset($_SERVER['apache_request_headers']))   $this->Input['apache_request_headers']    = apache_request_headers();
	}

	public static function getPathValue($paths)
	{
		$uri = explode('/', $paths);
		return $uri;
	}

	public function setId()
	{
		$this->Input['id'] = $this->Input['GET']['id'];
	}

	public function getId()
	{
		return $this->Input['id'];
	}

	public function getInputHandel()
	{
		return $this->Input;
	}

	public function setCallFuntion(String $setfun)
	{
		$this->Input['fcall'] = $setfun;
	}

	public function getCallFuntion()
	{
		return $this->Input['fcall'];
	}

	public function setuserId(int $setUserId)
	{
		$this->userId = $setUserId;
	}

	public function getuserId()
	{
		return $this->userId;
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
		$response = json_encode(['response' => ['status' => $code, "result" => $data]]);
		echo $response;
		exit;
	}

	public function validateParameter($fieldName, $value, $dataType, $required = true)
	{
		if ($required == true && empty($value) == true) {
			$this->throwError(VALIDATE_PARAMETER_REQUIRED, $fieldName . " parameter is required.");
		}

		switch ($dataType) {
			case BOOLEAN:
				if (!is_bool($value)) {
					$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be boolean.');
				}
				break;
			case INTEGER:
				if (!is_numeric($value)) {
					$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be numeric.');
				}
				break;

			case STRING:
				if (!is_string($value)) {
					$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName . '. It should be string.');
				}
				break;

			default:
				$this->throwError(VALIDATE_PARAMETER_DATATYPE, "Datatype is not valid for " . $fieldName);
				break;
		}

		return $value;
	}
}
