<?php
namespace App\Http\Controllers\EFT;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

abstract class APIRequest
{
	protected $request, $tokenTracker, $postFields, $apiResponse, $header;
	private $result;

	const fieldTypeNameRequired = 'required';
	const fieldTypeNameOptional = 'optional';

	public function __construct(Request $request, TokenTracker $tokenTracker)
	{
		$this->tokenTracker = $tokenTracker;
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

	abstract protected function setOptionalPostFields();
	abstract protected function setRequiredPostFields();
	abstract protected function handleApiResponse();
	abstract protected function setHeaderData();
	abstract protected function handleSuccessfulAttempt();
	abstract protected function handleUnsuccessfulAttempt();
	abstract protected function getApiEndPoint();


	public function doRun()
	{

		//try {
			$this->setPostFields()
				->initialize()
				->setHeaderData()
				->setApiResponse()
				->checkApiResponse()
				->handleApiResponse()
				->handleSuccessfulAttempt();
//		} catch (\Exception $exception) {
//			Log::alert("kod: {$exception->getCode()} | mesaj: ".$exception->getMessage());
//			$this->handleUnsuccessfulAttempt();
//		}
		return $this;
	}

	private function setPostFields()
	{
		$this->postFields = [
			self::fieldTypeNameRequired => $this->setRequiredPostFields(),
			self::fieldTypeNameOptional => $this->setOptionalPostFields()
		];
		return $this;
	}

	protected function setApiResponse()
	{
		$curl = new DataFetcher();
		$this->apiResponse = $curl->getResponse(
										$this->getApiEndPoint(),
										$this->getValidPostFields(),
										$this->header
									);
		return $this;
	}

	protected function checkApiResponse()
	{
		if(!empty($this->apiResponse->error) || (!empty($this->apiResponse->status) && $this->apiResponse->status != 'APPROVED') )  {
			throw new \RuntimeException(
				'Basarisiz islem|apiResponse:'.print_r($this->apiResponse,true).
				'|gonderilenler: hedef:'.$this->getApiEndPoint().
				'|'.print_r(array_merge($this->header,$this->getValidPostFields()),true)
			);
		}
		return $this;
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
		return $this->result;
	}
	public function getHTMLResult($dataName='data',$viewName='')
	{
		//dd($this->result);
		return view($viewName, [ $dataName => $this->result ] )->render();
	}
}