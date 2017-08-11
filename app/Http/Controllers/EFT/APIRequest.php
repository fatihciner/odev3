<?php
namespace App\Http\Controllers\EFT;

use Illuminate\Http\Request;

abstract class APIRequest
{
	protected $postFields;
	protected $dataFetcher;
	protected $request;
	protected $apiResponse;
	private $result;

	const fieldTypeNameRequired = 'required';
	const fieldTypeNameOptional = 'optional';

	/**
	 * RequestHandler constructor.
	 * @param $dataFetcher
	 */
	public function __construct(DataFetcher $dataFetcher,Request $request)
	{
		$this->dataFetcher = $dataFetcher;
		$this->request = $request;

	}

	protected function getPostFields($type='')
	{
		return array_filter (
			$this->postFields,
			function ($parameters,$parameter_type) use ($type)
			{
				return ( empty($type) || $type == $parameter_type ) ? $parameters : null;
			},
			ARRAY_FILTER_USE_BOTH
		);
	}



	protected function getValidPostFields()
	{
		$validFields = [];
		array_walk_recursive (
			$this->postFields,
			function ($apiField) use (& $validFields)
			{
				!$apiField->getValue() ? : $validFields[$apiField->getName() ] = $apiField->getValue() ;
			}
		);
		return $validFields;
	}


	//abstract public function doRun();
	abstract protected function setOptionalPostFields();
	abstract protected function setRequiredPostFields();
	abstract protected function handleApiResponse();
	abstract protected function handleSuccessfulAttempt();
	abstract protected function handleUnsuccessfulAttempt();
	abstract protected function getApiEndPoint();


	protected function doRun()
	{
		$this->setPostFields();
	}

	private function setPostFields()
	{
		$this->postFields = [
			self::fieldTypeNameRequired => $this->setRequiredPostFields(),
			self::fieldTypeNameOptional => $this->setOptionalPostFields()
		];
	}

	protected function getApiResponse()
	{
		$curl = new DataFetcher();
		$response = $curl->getResponse($this->getApiEndPoint(),$this->getValidPostFields());
		return $response;
		/*$response = (object) [
			'status' => 'ERROR',
			'error_message' => 'Curl failed, err_msg : '. $exception->getCode().' , error: '.$exception->getMessage().
				' posted data: '.$this->getApiEndPoint(). ' -  '.print_r($this->getValidPostFields(),true)
		];*/
	}

	protected function setResult($error_message='Default Error', $data=[])
	{
		$this->result = [
			'error' => $error_message,
			'data' => $data
		];
		return $this;
	}

	public function getJsonResult()
	{
		return json_encode($this->result);
	}
	public function getResult()
	{
		return json_encode($this->result);
	}

}