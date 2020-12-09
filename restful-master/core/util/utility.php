
<?php
require_once "constant/constants.php";

class Utility
{
	public $Input;

	public function __construct()
	{
		parse_str(file_get_contents("php://input"), $_PUT);
		$this->Input['GET']     = $_GET;
		$this->Input['POST']    = $_POST;
		$this->Input['PUT']     = $_PUT;
		$this->Input['FILES']   = $_FILES;

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

	public function setId(int $setId)
	{
		$this->Input['Id'] = $setId;
	}



	public function getInputHandel()
	{
		return $this->Input;
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
