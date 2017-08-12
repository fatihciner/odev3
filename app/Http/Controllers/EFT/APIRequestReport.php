<?php
/**
 * Created by PhpStorm.
 * User: fyilmaz
 * Date: 12.08.2017
 * Time: 00:56
 */
namespace App\Http\Controllers\EFT;

use Illuminate\Http\Request;

class APIRequestReport extends APIRequest
{
	public function __construct(Request $request, TokenTracker $tokenTracker)
	{
		$this->tokenTracker = $tokenTracker;
		$this->request = $request;
	}

	public function initialize()
	{
		return $this;
	}

	protected function setHeaderData()
	{
		$this->header = [
			'Authorization' => $this->tokenTracker->get()
		];
		return $this;
	}

	protected function handleApiResponse()
	{
		$this->apiResponse = array_map(
				function($response){
					return [
						'count' => $response->total,
						'total' => $response->total,
						'currency' => $response->currency
					];
				},
				$this->apiResponse->response
			);
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