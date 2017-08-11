<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:56
 */
namespace App\Http\Controllers\EFT;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class APIRequestReport extends APIRequest
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function doRun()
	{
		try {
			parent::doRun();
			$this->handleApiResponse()
				->handleSuccessfulAttempt();
		} catch (\Exception $exception) {
			Log::alert("kod: {$exception->getCode()} | mesaj: ".$exception->getMessage());
			$this->handleUnsuccessfulAttempt();
		}
		return $this;
	}

	protected function handleApiResponse()
	{
		$this->apiResponse = $this->getApiResponse();
		if(empty($this->apiResponse->status) || $this->apiResponse->status != 'APPROVED') {
			throw new \RuntimeException(
				'Basarisiz islem|apiResponse:'.print_r($this->apiResponse,true).
				'|gonderilenler: '.$this->getApiEndPoint().
				'|'.print_r($this->getValidPostFields(),true)
			);
		}
		return $this;
	}

	protected function handleUnsuccessfulAttempt()
	{
		return $this->setResult('Bakmak istediğiniz aralığı genişletin', []);
	}

	protected function handleSuccessfulAttempt()
	{
		return $this->setResult('', $this->apiResponse);
	}

	protected function setOptionalPostFields()
	{
		return  [];
	}

	protected function setRequiredPostFields()
	{
		return  [
			ApiField::fromDate($this->request->input(FieldType::FROMDATE)),
			ApiField::toDate($this->request->input(FieldType::TODATE))
		];
	}

	protected function getApiEndPoint()
	{
		return env('API_BASE_URL').'transactions/report';
	}
}